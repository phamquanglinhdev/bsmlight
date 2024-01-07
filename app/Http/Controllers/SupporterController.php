<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\CustomFields;
use App\Models\Student;
use App\Models\Supporter;
use App\Models\SupporterProfile;
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

class SupporterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request): View
    {
        if (!check_permission('list supporter')) {
            abort(403);
        }
        $perPage = $request->get('perPage') ?? 10;
        $crudBag = new CrudBag();
        $crudBag->setEntity('supporter');
        $crudBag->setLabel('Trợ giảng');
        $crudBag->setSearchValue($request->get('search'));
        $crudBag = $this->handleFiltering($crudBag, $request);
        $crudBag = $this->handleStatistic($crudBag, $request);
        $crudBag = $this->handleColumn($crudBag, $request);

        /**
         * @var LengthAwarePaginator $students
         */
        $builder = Supporter::query();

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

        $crudBag->setAction('supporter.store');
        $crudBag->setLabel('Trợ giảng');
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
            'label' => 'Tên trợ giảng',
            'required' => true,
        ]);

        $crudBag->addFields([
            'name' => 'email',
            'label' => 'Email của trợ giảng',
        ]);

        $crudBag->addFields([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại trợ giảng'
        ]);
        /**
         * @var CustomFields[] $customFields
         */
        $customFields = CustomFields::query()->where('branch', Auth::user()->{'branch'})->where('entity_type', CustomFields::ENTITY_SUPPORTER)->get();

        foreach ($customFields as $customField) {
            $data = [
                'name' => 'custom_field[' . $customField->name . ']',
                'type' => CustomFields::convertedType()[$customField->type],
                'label' => $customField->label,
                'required' => $customField->required
            ];

            if ($customField->type == CustomFields::SELECT_TYPE) {
                $data['options'] = $customField->convertInitValue();
                if ($data['required'] == 0) {
                    $data['nullable'] = 1;
                }
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

        $dataToCreateSupporter = [
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'uuid' => User::newUuid(Auth::user()->{'branch'}, 'TG'),
            'branch' => Auth::user()->{'branch'},
            'password' => Hash::make('bsm123456@'),
            'role' => User::SUPPORTER_ROLE,
            'avatar' => $request->get('avatar') ?? 'https://png.pngtree.com/png-clipart/20190117/ourlarge/pngtree-teachers-day-teacher-portrait-teachers-day-png-image_428203.jpg',
        ];
        $customFields = $request->get('custom_field') ?? [];

        DB::transaction(function () use ($dataToCreateSupporter, $customFields) {
            $supporter = Supporter::query()->create($dataToCreateSupporter);

            SupporterProfile::query()->create([
                'user_id' => $supporter['id'],
            ]);

            $this->saveCustomFields($customFields, $supporter['id']);
        });

        return redirect()->to('/supporter/list')->with('success', 'Thêm trợ giảng thành công');
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
         * @var Supporter $supporter
         */
        $supporter = Supporter::query()->where('id', $id)->firstOrFail();

        $crudBag = new CrudBag();

        $crudBag->setAction('supporter.update');
        $crudBag->setId($id);
        $crudBag->setLabel('Trợ giảng');

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
            'value' => $supporter['avatar'],
            'class' => 'col-10 mb-3'
        ]);
        $crudBag->addFields([
            'name' => 'name',
            'label' => 'Tên trợ giảng',
            'value' => $supporter['name'],
            'required' => true,
        ]);

        $crudBag->addFields([
            'name' => 'email',
            'label' => 'Email của trợ giảng',
            'value' => $supporter['email'],
        ]);

        $crudBag->addFields([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại trợ giảng',
            'value' => $supporter['phone'],
        ]);

        /**
         * @var CustomFields[] $customFields
         */
        $customFields = CustomFields::query()->where('branch', Auth::user()->{'branch'})->where('entity_type', CustomFields::ENTITY_SUPPORTER)->get();

        foreach ($customFields as $customField) {
            $data = [
                'name' => 'custom_field[' . $customField->name . ']',
                'type' => CustomFields::convertedType()[$customField->type],
                'label' => $customField->label,
                'required' => $customField->required,
                'value' => $supporter->getCustomField($customField->name),
            ];

            if ($customField->type == CustomFields::SELECT_TYPE) {
                $data['options'] = $customField->convertInitValue();
                if ($data['required'] == 0) {
                    $data['nullable'] = 1;
                }
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
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'email|nullable',
            'avatar' => 'string|nullable'
        ]);

        $supporter = Supporter::query()->where('id', $id)->firstOrFail();

        $dataUpdate = $request->only([
            'name',
            'phone',
            'email',
            'avatar'
        ]);
        $customFields = $request->get('custom_field') ?? [];

        DB::transaction(function () use ($dataUpdate, $supporter, $customFields) {
            $supporter->update($dataUpdate);
            $this->saveCustomFields($customFields, $supporter['id']);
        });

        return redirect()->to('/supporter/list')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $supporter = Supporter::query()->where('id', $id)->firstOrFail();

        $supporter->delete();

        return redirect()->to('/supporter/list')->with('success', 'Xoá thành công');
    }

    private function handleFiltering(CrudBag $crudBag, Request $request): CrudBag
    {
        $crudBag->addFilter([
            'name' => 'name:contain',
            'label' => 'Tên trợ giảng',
            'type' => 'text'
        ]);

        return $crudBag;
    }

    private function handleStatistic(CrudBag $crudBag, Request $request)
    {
//        $crudBag->addStatistic([
//            'name' => 'total_teacher',
//            'label' => 'Tổng số trợ giảng',
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
            'label' => 'Mã trợ giảng',
            'fixed' => 'first'
        ]);
        $crudBag->addColumn([
            'name' => 'name',
            'label' => 'Tên trợ giảng',
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
            'label' => 'Email trợ giảng',
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
            if (!$customField) {
                continue;
            }

            $customFieldRecord = CustomFields::query()->where('name', $name)->where('branch', Auth::user()->{'branch'})->exists();

            if (!$customFieldRecord) {
                continue;
            }

            $data[$name] = $customField;
        }

        SupporterProfile::query()->where('user_id', $id)->update([
            'extra_information' => json_encode($data)
        ]);
    }
}
