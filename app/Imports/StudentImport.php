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
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
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
            'payment_plant' => 'Kế hoạch thanh toán'
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
                if (!empty($dataToCreate)) {
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
                            'birthday' => $dataToCreate['birthday'] ? Carbon::createFromFormat("d/m/Y", $dataToCreate['birthday']) : null,
                        ];

                        $currentStudentId = DB::transaction(function () use ($dataToCreate, $createUser, $createProfile) {
                            $student = Student::query()->create($createUser);
                            $createProfile['user_id'] = $student['id'];
                            StudentProfile::query()->create($createProfile);
                            $this->saveCustomFields($dataToCreate['custom_field'], $student['id']);

                            return $student['id'];
                        });
                    }
                }

                DB::transaction(function () use ($currentStudentId, $dataToCreateCard) {
                    $dataToCreateCard['student_id'] = $currentStudentId;
                    $dataToCreateCard['van'] = $dataToCreateCard['van'] ?? 0;
                    $dataToCreateCard['uuid'] = Card::generateUUID(Auth::user()->{'branch'});
                    $dataToCreateCard['branch'] = Auth::user()->{'branch'};
                    $dataToCreateCard['van_date'] = Carbon::createFromFormat("d/m/Y", $dataToCreateCard['van_date']);

                    Card::query()->create($dataToCreateCard);
                });
            }
        }
    }

    private function saveCustomFields(array $customFields, int $studentId): void
    {
        $customFieldsData = [];

        foreach ($customFields as $name => $customField) {
            if (!$customField) {
                continue;
            }

            $customFieldRecord = CustomFields::query()->where('name', $name)->where('branch', Auth::user()->{'branch'})->first();
            if (!$customFieldRecord) {
                continue;
            }

            if ($customFieldRecord['type'] == CustomFields::DATE_TYPE) {
                $customField = Carbon::createFromFormat("d/m/Y", $customField);
            }

            $customFieldsData[$name] = $customField;
        }

        StudentProfile::query()->where('user_id', $studentId)->update([
            'extra_information' => json_encode($customFieldsData)
        ]);
    }
}
