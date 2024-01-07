<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\CustomFields;
use App\Models\Student;
use App\Models\Staff;
use App\Models\StaffProfile;
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

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request): View
    {
        if (!check_permission('list staff')) {
            abort(403);
        }
        $perPage = $request->get('perPage') ?? 10;
        $crudBag = new CrudBag();
        $crudBag->setEntity('staff');
        $crudBag->setLabel('Nhân viên');
        $crudBag->setSearchValue($request->get('search'));
        $crudBag = $this->handleFiltering($crudBag, $request);
        $crudBag = $this->handleStatistic($crudBag, $request);
        $crudBag = $this->handleColumn($crudBag, $request);

        /**
         * @var LengthAwarePaginator $students
         */
        $builder = Staff::query();

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

        $crudBag->setAction('staff.store');
        $crudBag->setLabel('Nhân viên');
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
            'label' => 'Tên nhân viên',
            'required' => true,
        ]);

        $crudBag->addFields([
            'name' => 'email',
            'label' => 'Email của nhân viên',
        ]);

        $crudBag->addFields([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại nhân viên'
        ]);
        /**
         * @var CustomFields[] $customFields
         */
        $customFields = CustomFields::query()->where('branch', Auth::user()->{'branch'})->where('entity_type', CustomFields::ENTITY_STAFF)->get();

        foreach ($customFields as $customField) {
            $data = [
                'name' => 'custom_field[' . $customField->name . ']',
                'label' => $customField->label,
                'type' => CustomFields::convertedType()[$customField->type],
                'required' => $customField->required,
            ];

            if ($customField->type == CustomFields::SELECT_TYPE) {
                $data['options'] = $customField->convertInitValue();
            }

            if ($customField->required == 0) {
                $data['nullable'] = 1;
            }


            $crudBag->addFields($data);
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'string|nullable',
            'email' => 'email|nullable',
        ]);

        $dataToCreateStaff = [
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'uuid' => User::newUuid(Auth::user()->{'branch'}, 'NV'),
            'branch' => Auth::user()->{'branch'},
            'password' => Hash::make('bsm123456@'),
            'role' => User::STAFF_ROLE,
            'avatar' => $request->get('avatar') ?? 'https://png.pngtree.com/png-clipart/20190117/ourlarge/pngtree-teachers-day-teacher-portrait-teachers-day-png-image_428203.jpg',
        ];

        $customFields = $request->get('custom_field') ?? [];

        DB::transaction(function () use ($dataToCreateStaff, $customFields) {
            $staff = Staff::query()->create($dataToCreateStaff);

            StaffProfile::query()->create([
                'user_id' => $staff['id'],
            ]);

            $this->saveCustomFields($customFields, $staff['id']);
        });

        return redirect()->to('/staff/list')->with('success', 'Thêm nhân viên thành công');
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
         * @var Staff $staff
         */
        $staff = Staff::query()->where('id', $id)->firstOrFail();

        $crudBag = new CrudBag();

        $crudBag->setAction('staff.update');
        $crudBag->setId($id);
        $crudBag->setLabel('Nhân viên');

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
            'value' => $staff['avatar'],
            'class' => 'col-10 mb-3'
        ]);
        $crudBag->addFields([
            'name' => 'name',
            'label' => 'Tên nhân viên',
            'value' => $staff['name'],
            'required' => true,
        ]);

        $crudBag->addFields([
            'name' => 'email',
            'label' => 'Email của nhân viên',
            'value' => $staff['email'],
        ]);

        $crudBag->addFields([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại nhân viên',
            'value' => $staff['phone'],
        ]);

        /**
         * @var CustomFields[] $customFields
         */
        $customFields = CustomFields::query()->where('branch', Auth::user()->{'branch'})->where('entity_type', CustomFields::ENTITY_STAFF)->get();

        foreach ($customFields as $customField) {
            $data = [
                'name' => 'custom_field[' . $customField->name . ']',
                'label' => $customField->label,
                'type' => CustomFields::convertedType()[$customField->type],
                'required' => $customField->required,
                'value' => $staff->getCustomField($customField->name),
            ];

            if ($customField->type == CustomFields::SELECT_TYPE) {
                $data['options'] = $customField->convertInitValue();
            }

            if ($customField->required == 0) {
                $data['nullable'] = 1;
            }


            $crudBag->addFields($data);
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
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'email|nullable',
            'avatar' => 'string|nullable'
        ]);

        $staff = Staff::query()->where('id', $id)->firstOrFail();

        $dataUpdate = $request->only([
            'name',
            'phone',
            'email',
            'avatar'
        ]);

        $customFields = $request->get('custom_field') ?? [];

        DB::transaction(function () use ($customFields, $dataUpdate, $staff) {
            $staff->update($dataUpdate);
            $this->saveCustomFields($customFields, $staff['id']);
        });

        return redirect()->to('/staff/list')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $staff = Staff::query()->where('id', $id)->firstOrFail();

        $staff->delete();

        return redirect()->to('/staff/list')->with('success', 'Xoá thành công');
    }

    private function handleFiltering(CrudBag $crudBag, Request $request): CrudBag
    {
        $crudBag->addFilter([
            'name' => 'name:contain',
            'label' => 'Tên nhân viên',
            'type' => 'text'
        ]);

        return $crudBag;
    }

    private function handleStatistic(CrudBag $crudBag, Request $request)
    {
//        $crudBag->addStatistic([
//            'name' => 'total_teacher',
//            'label' => 'Tổng số nhân viên',
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
            'label' => 'Mã nhân viên',
            'fixed' => 'first'
        ]);
        $crudBag->addColumn([
            'name' => 'name',
            'label' => 'Tên nhân viên',
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
            'label' => 'Email nhân viên',
            'type' => 'text',
        ]);

        return $crudBag;
    }

    private function handleBuilder(Builder $builder, CrudBag $crudBag)
    {
        $builder->orderBy('created_at', 'desc');
    }

    private function saveCustomFields(array $customFields, int $id)
    {
        $data = [];
        foreach ($customFields as $name => $customField) {
            if (!$customField) {
                continue;
            }
            $customFieldRecord = CustomFields::query()->where('name', $name)->where('branch', Auth::user()->{'branch'})->exists();

            if (!$customFieldRecord) {
                continue;
            }

            $data[$name] = $customField;
        }

        StaffProfile::query()->where('user_id', $id)->update([
            'extra_information' => json_encode($data)
        ]);
    }
}
