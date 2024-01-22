<?php

namespace App\Imports;

use App\Helper\CrudBag;
use App\Http\Controllers\StudentController;
use App\Models\Card;
use App\Models\CustomFields;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class StudentImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $insertIds = [];

        $defaultHeading = [
            'name' => 'Tên học sinh',
            'english_name' => 'Tên tiếng Anh',
            'gender' => 'Giới tính',
            'birthday' => 'Ngày sinh',
            'phone' => 'Số điện thoại',
            'facebook' => 'Link facebook học sinh',
            'email' => 'Email của học sinh',
            'address' => 'Địa chỉ sinh sống',
            'school' => 'Trường đang theo học',
        ];

        $customFields = CustomFields::query()->where('branch', Auth::user()->{'branch'})
            ->where('entity_type', CustomFields::ENTITY_STUDENT)->get();

        $customHeadings = [];

        foreach ($customFields as $customField) {
            $customHeadings[$customField->name] = $customField->label;
        }
        $cellHeading = $collection->get(1)->toArray();

        $cardHeadings = [
            'van' => 'Số buổi trước khi sử dụng BSM',
            'van_date' => 'Ngày chốt điểm danh ở hệ thống cũ',
            'drive_link' => 'Link PDF đơn đăng ký',
            'commitment' => 'Cam kết đầu ra',
            'original_days' => 'Số buổi đăng ký gốc',
            'bonus_days' => 'Số buổi tặng thêm',
            'bonus_reason' => 'Lý do tặng',
            'original_fee' => 'Học phí gốc',
            'promotion_fee' => 'Học phí ưu đãi',
            'fee_reason' => 'Lý do ưu đãi',
            'payment_plant' => 'Kế hoạch thanh toán',
            'paid_fee' => 'Số tiền thực tế đã thanh toán'
        ];

        $currentStudentId = 0;

        foreach ($collection as $index => $row) {
            $dataToCreate = [];
            $dataToCreateCard = [];
            if ($index > 1) {
                foreach ($row as $indexCell => $cell) {
                    foreach ($defaultHeading as $key => $label) {
                        if ($cellHeading[$indexCell] == $label) {
                            $dataToCreate[$key] = $cell;
                        }
                    }

                    foreach ($customHeadings as $customKey => $customLabel) {
                        if ($cellHeading[$indexCell] == $customLabel) {
                            $dataToCreate['custom_field'][$customKey] = $cell;
                        }
                    }

                    foreach ($cardHeadings as $cardKey => $cardLabel) {
                        if ($cellHeading[$indexCell] == $cardLabel) {
                            $dataToCreateCard[$cardKey] = $cell;
                        }
                    }
                }
                if (! empty($dataToCreate)) {
                    if ($dataToCreate['name'] !== null) {
                        $createUser = [
                            'name' => $dataToCreate['name'],
                            'uuid' => Student::newUuid(Auth::user()->{'branch'}, 'HS'),
                            'avatar' => $dataToCreate['avatar'] ?? "https://i.pinimg.com/originals/4a/5f/a7/4a5fa77ce26719459ecaab07353ef645.png",
                            'email' => $dataToCreate['email'],
                            'phone' => $dataToCreate['phone'],
                            'branch' => Auth::user()->{'branch'},
                            'password' => Hash::make('bsm123456@'),
                            'role' => User::STUDENT_ROLE,
                        ];

                        $createProfile = [
                            'english_name' => $dataToCreate['english_name'],
                            'gender' => $dataToCreate['gender'] == 'Nam' ? 1 : 2,
                            'facebook' => $dataToCreate['facebook'] ?? '',
                            'address' => $dataToCreate['address'] ?? '',
                            'school' => $dataToCreate['school'] ?? '',
//                            'birthday' => $dataToCreate['birthday'] ? Carbon::createFromFormat("d/m/Y", $dataToCreate['birthday']) : null,
                            'birthday' => $dataToCreate['birthday'] ? excel_date($dataToCreate['birthday']) : null,
                        ];

                        try {
                            $student = Student::query()->create($createUser);
                        } catch (\Exception $exception) {
                            $this->cancelUpload($insertIds);
                            throw new BadRequestException('Dòng ' . $index . ':' . $exception->getMessage());
                        }

                        $createProfile['user_id'] = $student['id'];

                        try {
                            StudentProfile::query()->create($createProfile);
                            $this->saveCustomFields($dataToCreate['custom_field'], $student['id']);
                        } catch (\Exception $exception) {
                            $this->cancelUpload($insertIds);
                            throw new BadRequestException('Dòng ' . $index . ':' . $exception->getMessage());
                        }

                        $insertIds[] = $student['id'];
                        $currentStudentId = $student['id'];
                    }
                }

                $dataToCreateCard['student_id'] = $currentStudentId;
                $dataToCreateCard['van'] = $dataToCreateCard['van'] ?? 0;
                $dataToCreateCard['drive_link'] = $dataToCreateCard['drive_link'] ?? '';
                $dataToCreateCard['commitment'] = $dataToCreateCard['commitment'] ?? '';
                $dataToCreateCard['original_days'] = $dataToCreateCard['original_days'] ?? 0;
                $dataToCreateCard['bonus_days'] = $dataToCreateCard['bonus_days'] ?? 0;
                $dataToCreateCard['bonus_reason'] = $dataToCreateCard['bonus_reason'] ?? '';
                $dataToCreateCard['original_fee'] = $dataToCreateCard['original_fee'] ?? 0;
                $dataToCreateCard['promotion_fee'] = $dataToCreateCard['promotion_fee'] ?? 0;
                $dataToCreateCard['fee_reason'] = $dataToCreateCard['fee_reason'] ?? '';
                $dataToCreateCard['payment_plant'] = $dataToCreateCard['payment_plant'] ?? '';
                $dataToCreateCard['paid_fee'] = $dataToCreateCard['paid_fee'] ?? 0;
                $dataToCreateCard['van'] = $dataToCreateCard['van'] ?? 0;
                $dataToCreateCard['uuid'] = Card::generateUUID(Auth::user()->{'branch'});
                $dataToCreateCard['branch'] = Auth::user()->{'branch'};
                $dataToCreateCard['van_date'] = isset($dataToCreateCard['van_date']) ? excel_date($dataToCreateCard['van_date']) : null;

                $notification = Validator::make($dataToCreateCard, [
                    'student_id' => 'integer|required',
                    'van' => 'integer|nullable',
                    'drive_link' => 'string|nullable',
                    'commitment' => 'string|nullable',
                    'original_days' => 'integer|min:0|required',
                    'bonus_days' => 'integer|min:0|nullable',
                    'bonus_reason' => 'string|nullable',
                    'original_fee' => 'integer|min:0|required',
                    'promotion_fee' => 'integer|min:0|nullable',
                    'fee_reason' => 'string|nullable',
                    'payment_plant' => 'string|nullable',
                    'paid_fee' => 'integer|min:0|nullable',
                    'van_date' => 'date|nullable',
                    'branch' => 'string|required',
//                        'uuid' => 'string|required|unique:cards,uuid',
                ]);

                if ($notification->fails()) {
                    $this->cancelUpload($insertIds);
                    throw new BadRequestException('Dòng ' . $index . ':' . $notification->errors()->first());
                }

                if ($dataToCreateCard['original_fee'] - $dataToCreateCard['promotion_fee'] < $dataToCreateCard['paid_fee']) {
//                        $dataToCreateCard['paid_fee'] = $dataToCreateCard['original_fee'] - $dataToCreateCard['promotion_fee'];
                    $this->cancelUpload($insertIds);
                    throw new BadRequestException('Dòng ' . $index . ' Số tiền đã đóng nhiều hơn số tiền phải đóng');
                }

                try {
                    Card::query()->create($dataToCreateCard);
                } catch (\Exception $exception) {
                    $this->cancelUpload($insertIds);
                    throw new BadRequestException('Dòng ' . $index . ':' . $exception->getMessage());
                }
            }
        }
    }

    private function saveCustomFields(array $customFields, int $studentId): void
    {
        $customFieldsData = [];

        foreach ($customFields as $name => $customField) {
            if (! $customField) {
                continue;
            }

            $customFieldRecord = CustomFields::query()->where('name', $name)->where('branch', Auth::user()->{'branch'})->first();
            if (! $customFieldRecord) {
                continue;
            }

            if ($customFieldRecord['type'] == CustomFields::DATE_TYPE) {
                $customField = excel_date($customField);
            }

            $customFieldsData[$name] = $customField;
        }

        StudentProfile::query()->where('user_id', $studentId)->update([
            'extra_information' => json_encode($customFieldsData)
        ]);
    }

    /**
     * @param $insertIds
     * @return void
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 22/01/2024 10:03 am
     */
    private function cancelUpload($insertIds): void
    {
        if (! empty($insertIds)) {
            Student::query()->whereIn('id', $insertIds)->delete();

            StudentProfile::query()->whereIn('user_id', $insertIds)->delete();

            Card::query()->whereIn('student_id', $insertIds)->delete();
        }
    }
}
