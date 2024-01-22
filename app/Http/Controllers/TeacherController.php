<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\CustomFields;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request): View
    {
        if (!check_permission('list teacher')) {
            abort(403);
        }
        $perPage = $request->get('perPage') ?? 10;
        $crudBag = new CrudBag();
        $crudBag->setEntity('teacher');
        $crudBag->setLabel('Giáo viên');
        $crudBag->setSearchValue($request->get('search'));
        $crudBag = $this->handleFiltering($crudBag, $request);
        $crudBag = $this->handleStatistic($crudBag, $request);
        $crudBag = $this->handleColumn($crudBag, $request);

        /**
         * @var LengthAwarePaginator $students
         */
        $builder = Teacher::query();

        $this->handleBuilder($builder, $crudBag);

        $teacher = $builder->paginate($perPage);

        return \view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => new ListViewModel($teacher)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $crudBag = new CrudBag();

        $crudBag->setAction('teacher.store');
        $crudBag->setLabel('Giáo viên');
        $crudBag->addFields([
            'name' => 'avatar',
            'type' => 'avatar-select',
            'required' => false,
            'label' => 'Chọn avatar',
            'options' => [
                0 => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS0Oi53Y0SYUnNZ6FDFALWjbzr2siFFZqRAI_ygcnbVunsa0Ywsn1u1xGx7FisdgzGdcQ&usqp=CAU',
                1 => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFrh7xFLdXWAgC4xrL9rtaOMMI1W_ifWqbMzlvWwjSiNg1QRSpe6XwNEalJXfoNUaVHt8&usqp=CAU',
                3 => 'https://png.pngtree.com/png-clipart/20231002/original/pngtree-santa-smiling-face-with-red-hat-say-hohoho-png-image_13063768.png',
                4 => 'https://dthezntil550i.cloudfront.net/9m/latest/9m2306211009227300024981607/1280_960/7e11d8f6-5a3f-4121-8a4f-57653520ae98.png',
                5 => 'https://i.pinimg.com/originals/4a/5f/a7/4a5fa77ce26719459ecaab07353ef645.png',
                6 => 'https://static-cdn.jtvnw.net/jtv_user_pictures/f275797c-e631-4a89-b7d2-952c3a79c789-profile_image-300x300.png',
            ],
            'class' => 'col-10 mb-3'
        ]);
        $crudBag->addFields([
            'name' => 'name',
            'label' => 'Tên giáo viên',
            'required' => true,
        ]);

        $crudBag->addFields([
            'name' => 'email',
            'label' => 'Email của giáo viên',
        ]);

        $crudBag->addFields([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại giáo viên'
        ]);

        $crudBag->addFields([
            'name' => 'teacher_source',
            'type' => 'select',
            'label' => 'Phân loại giáo viên',
            'required' => true,
            'options' => [
                Teacher::INTERNAL_SOURCE => 'Giáo viên Việt Nam',
                Teacher::EXTERNAL_SOURCE => 'Giáo viên nước ngoài',
            ],
//            'value' => Teacher::INTERNAL_SOURCE
        ]);

        /**
         * @var CustomFields[] $customFields
         */
        $customFields = CustomFields::query()->where('entity_type', CustomFields::ENTITY_TEACHER)->where('branch', Auth::user()->{'branch'})->get();

        foreach ($customFields as $customField) {
            $fieldData = [
                'name' => 'custom_fields[' . $customField->name . ']',
                'label' => $customField->label,
                'type' => CustomFields::convertedType()[$customField->type],
                'required' => $customField->required
            ];

            if ($customField->type == CustomFields::SELECT_TYPE) {
                $fieldData['options'] = $customField->convertInitValue();
                if ($customField->required == 0) {
                    $fieldData['nullable'] = 1;
                }
            }

            $crudBag->addFields($fieldData);
        }

        return \view('create', [
            'crudBag' => $crudBag
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'string|nullable',
            'email' => 'email|nullable',
            'teacher_source' => 'required|integer|in:' . Teacher::INTERNAL_SOURCE . ',' . Teacher::EXTERNAL_SOURCE
        ]);

        $dataToCreateTeacher = [
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'uuid' => User::newUuid(Auth::user()->{'branch'}, $request->get('teacher_source') === Teacher::INTERNAL_SOURCE ? "GVVN" : "GVNN"),
            'branch' => Auth::user()->{'branch'},
            'password' => Hash::make('bsm123456@'),
            'role' => User::TEACHER_ROLE,
            'avatar' => $request->get('avatar') ?? 'https://png.pngtree.com/png-clipart/20190117/ourlarge/pngtree-teachers-day-teacher-portrait-teachers-day-png-image_428203.jpg',
        ];

        $dataToCreateTeacherProfile = [
            'teacher_source' => $request->get('teacher_source'),
        ];

        $customFields = $request->get('custom_fields') ?? [];
        DB::transaction(function () use ($dataToCreateTeacher, $dataToCreateTeacherProfile, $customFields) {
            $teacher = Teacher::query()->create($dataToCreateTeacher);

            TeacherProfile::query()->create([
                'user_id' => $teacher['id'],
                'teacher_source' => $dataToCreateTeacherProfile['teacher_source']
            ]);

            $this->saveCustomFields($customFields, $teacher->id);
        });

        return redirect()->to('/teacher/list')->with('success', 'Thêm giáo viên');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */

    public function edit(int $id): View
    {
        /**
         * @var Teacher $teacher
         */
        $teacher = Teacher::query()->where('id', $id)->firstOrFail();

        $crudBag = new CrudBag();

        $crudBag->setAction('teacher.update');
        $crudBag->setId($id);
        $crudBag->setLabel('Giáo viên');

        $crudBag->addFields([
            'name' => 'avatar',
            'type' => 'avatar-select',
            'required' => false,
            'label' => 'Chọn avatar',
            'options' => [
                0 => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS0Oi53Y0SYUnNZ6FDFALWjbzr2siFFZqRAI_ygcnbVunsa0Ywsn1u1xGx7FisdgzGdcQ&usqp=CAU',
                1 => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFrh7xFLdXWAgC4xrL9rtaOMMI1W_ifWqbMzlvWwjSiNg1QRSpe6XwNEalJXfoNUaVHt8&usqp=CAU',
                3 => 'https://png.pngtree.com/png-clipart/20231002/original/pngtree-santa-smiling-face-with-red-hat-say-hohoho-png-image_13063768.png',
                4 => 'https://dthezntil550i.cloudfront.net/9m/latest/9m2306211009227300024981607/1280_960/7e11d8f6-5a3f-4121-8a4f-57653520ae98.png',
                5 => 'https://i.pinimg.com/originals/4a/5f/a7/4a5fa77ce26719459ecaab07353ef645.png',
                6 => 'https://static-cdn.jtvnw.net/jtv_user_pictures/f275797c-e631-4a89-b7d2-952c3a79c789-profile_image-300x300.png',
            ],
            'value' => $teacher['avatar'],
            'class' => 'col-10 mb-3'
        ]);
        $crudBag->addFields([
            'name' => 'name',
            'label' => 'Tên giáo viên',
            'value' => $teacher['name'],
            'required' => true,
        ]);

        $crudBag->addFields([
            'name' => 'email',
            'label' => 'Email của giáo viên',
            'value' => $teacher['email'],
        ]);

        $crudBag->addFields([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại giáo viên',
            'value' => $teacher['phone'],
        ]);

        /**
         * @var CustomFields[] $customFields
         */
        $customFields = CustomFields::query()->where('entity_type', CustomFields::ENTITY_TEACHER)->where('branch', Auth::user()->{'branch'})->get();

        foreach ($customFields as $customField) {
            $fieldData = [
                'name' => 'custom_fields[' . $customField->name . ']',
                'label' => $customField->label,
                'type' => CustomFields::convertedType()[$customField->type],
                'required' => $customField->required,
                'value' => $teacher->getCustomField($customField->name),
            ];

            if ($customField->type == CustomFields::SELECT_TYPE) {
                $fieldData['options'] = $customField->convertInitValue();
                if ($customField->required == 0) {
                    $fieldData['nullable'] = 1;
                }
            }

            $crudBag->addFields($fieldData);
        }

        return \view('create', ['crudBag' => $crudBag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'email|nullable',
            'avatar' => 'string|nullable'
        ]);

        $teacher = Teacher::query()->where('id', $id)->firstOrFail();

        $dataUpdate = $request->only([
            'name',
            'phone',
            'email',
            'avatar'
        ]);

        $customFields = $request->get('custom_fields') ?? [];

        DB::transaction(function () use ($dataUpdate, $teacher, $id, $customFields) {
            $teacher->update($dataUpdate);
            $this->saveCustomFields($customFields, $id);
        });

        return redirect()->to('/teacher/list')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $teacher = Teacher::query()->where('id', $id)->firstOrFail();

        $teacher->delete();

        return redirect()->to('/teacher/list')->with('success', 'Xoá thành công');
    }

    private function handleFiltering(CrudBag $crudBag, Request $request)
    {
        $crudBag->addFilter([
            'name' => 'name:contain',
            'label' => 'Tên giáo viên',
            'type' => 'text'
        ]);

        return $crudBag;
    }

    private function handleStatistic(CrudBag $crudBag, Request $request)
    {
//        $crudBag->addStatistic([
//            'name' => 'total_teacher',
//            'label' => 'Tổng số giáo viên',
//            'value' => Teacher::query()->count(),
//            'badge' => '',
//            'image' => ''
//        ]);

        return $crudBag;
    }

    private function handleColumn(CrudBag $crudBag, Request $request): CrudBag
    {
        $crudBag->addColumn([
            'name' => 'uuid',
            'label' => 'Mã giáo viên',
            'fixed' => 'first'
        ]);
        $crudBag->addColumn([
            'name' => 'teacher_source',
            'label' => 'Phân loại',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    Teacher::INTERNAL_SOURCE => 'Giáo viên Việt Nam',
                    Teacher::EXTERNAL_SOURCE => 'Giáo viên nước ngoài',
                ],
                'bg' => [
                    Teacher::INTERNAL_SOURCE => 'bg-success',
                    Teacher::EXTERNAL_SOURCE => 'bg-danger',
                ]
            ],
        ]);
        $crudBag->addColumn([
            'name' => 'name',
            'label' => 'Tên giáo viên',
            'type' => 'profile',
            'attributes' => [
                'avatar' => 'avatar',
                'address' => 'address',
                'identity' => 'id'
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'phone',
            'label' => 'Số điện thoại',
            'type' => 'text',
        ]);

        $crudBag->addColumn([
            'name' => 'email',
            'label' => 'Email giáo viên',
            'type' => 'text',
        ]);

        return $crudBag;
    }

    private function handleBuilder(Builder $builder, CrudBag $crudBag)
    {
        $builder->orderBy('created_at', 'desc');
    }

    private function saveCustomFields(array $customFields, int $id): void
    {
        $data = [];
        foreach ($customFields as $name => $customField) {
            if (! $customField) {
                continue;
            }
            $customFieldRecord = CustomFields::query()->where('name', $name)->where('branch', Auth::user()->{'branch'})->first();
            if (!$customFieldRecord) {
                continue;
            }

            $data[$name] = $customField;
        }

        TeacherProfile::query()->where('user_id', $id)->update([
            'extra_information' => json_encode($data)
        ]);
    }
}
