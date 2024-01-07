<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\CustomFields;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomFieldController extends Controller
{
    public function create()
    {
        $crudBag = new CrudBag();

        $crudBag->setLabel('Trường tự định nghĩa');
        $crudBag->setEntity('custom_field');
        $crudBag->setAction('custom_field.store');


        $crudBag = $this->handleFields($crudBag);

        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    private function handleFields(CrudBag $crudBag, CustomFields $customFields = null): CrudBag
    {
        $crudBag->addFields([
            'name' => 'label',
            'required' => true,
            'label' => 'Tên trường',
            'value' => $customFields?->label,
        ]);

        $crudBag->addFields([
            'name' => 'entity_type',
            'value' => $customFields?->entity_type,
            'required' => true,
            'label' => 'Sử dụng cho',
            'options' => CustomFields::listEntityType(),
            'type' => 'select',
        ]);

        $crudBag->addFields([
            'name' => 'type',
            'required' => true,
            'label' => 'Kiểu trường',
            'type' => 'select',
            'options' => CustomFields::listType(),
            'value' => $customFields?->type
        ]);

        $crudBag->addFields([
            'name' => 'initValue',
            'label' => 'Dữ liệu khởi tạo',
            'type' => 'select',
            'nullable' => 1,
            'options' => CustomFields::listSource(),
            'value' => isset($customFields?->initValue) ? json_decode($customFields?->initValue, true)['type'] : null
        ]);

        $crudBag->addFields([
            'name' => 'required',
            'label' => 'Bắt buộc',
            'type' => 'checkbox',
            'value' => $customFields?->required
        ]);

        return $crudBag;
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'string|required',
            'entity_type' => 'string|required',
            'type' => 'integer|required',
            'initValue' => 'string|nullable',
        ]);

        $name = Str::slug($request['label']);

        if (CustomFields::query()->where('name', $name)->where('branch', Auth::user()->{'branch'})->exists()) {
            return redirect()->back()->withErrors([
                'label' => 'Trường tự định nghĩa đã tồn tại, vui lòng đặt tên khác',
            ]);
        }
        $dataToCreate = [
            'label' => $request['label'],
            'name' => $name,
            'entity_type' => $request['entity_type'],
            'type' => $request['type'],
            'initValue' => $request['initValue'] ? json_encode([
                'type' => $request['initValue'],
            ]) : null,
            'required' => $request['required'] ?? '0',
            'branch' => Auth::user()->{'branch'},
        ];

        CustomFields::query()->create($dataToCreate);

        return redirect()->to('custom_field/list')->with('success', 'Thêm mới thành công');
    }

    public function list(Request $request)
    {
        $crudBag = new CrudBag();
        $crudBag->setLabel('Trường tự định nghĩa');
        $crudBag->setEntity('custom_field');

        $crudBag = $this->handleColumns($crudBag);

        $query = CustomFields::where('branch', Auth::user()->{'branch'})->orderBy('id', 'desc');

        $listViewModel = new ListViewModel($query->paginate($request->get('perPage') ?? 10));
        return view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => $listViewModel
        ]);
    }

    private function handleColumns(CrudBag $crudBag)
    {
        $crudBag->addColumn([
            'name' => 'label',
            'label' => 'Tên trường',
            'attributes' => [
                'edit' => true,
                'entity' => 'custom_field'
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'entity_type',
            'label' => 'Sử dụng cho',
            'type' => 'select',
            'attributes' => [
                'options' => CustomFields::listEntityType(),
                'bg' => CustomFields::backgroundEntityType()
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'type',
            'label' => 'Kiểu trường',
            'type' => 'select',
            'attributes' => [
                'options' => CustomFields::listType(),
                'bg' => CustomFields::backgroundType()
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'required',
            'label' => 'Bắt buộc',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    '0' => 'Không',
                    '1' => 'Bắt buộc'
                ],
                'bg' => [
                    '0' => 'bg-label-github',
                    '1' => 'bg-success'
                ]
            ]
        ]);

        return $crudBag;
    }

    public function edit(int $id)
    {
        /**
         * @var CustomFields $customFields
         */
        $customFields = CustomFields::query()->where('id', $id)->where('branch', Auth::user()->{'branch'})->firstOrFail();
        $crudBag = new CrudBag();
        $crudBag->setLabel('Trường tự định nghĩa');
        $crudBag->setEntity('custom_field');
        $crudBag->setId($id);
        $crudBag->setAction('custom_field.update');
        $crudBag = $this->handleFields($crudBag, $customFields);

        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    public function update(Request $request, int $id)
    {

        $this->validate($request, [
            'label' => 'string|required',
            'entity_type' => 'string|required',
            'type' => 'integer|required',
            'initValue' => 'string|nullable',
        ]);

        $customFields = CustomFields::query()->where('id', $id)->where('branch', Auth::user()->{'branch'})->firstOrFail();

        $dataToUpdate = [
            'label' => $request['label'],
            'entity_type' => $request['entity_type'],
            'type' => $request['type'],
            'initValue' => $request['initValue'] ? json_encode([
                'type' => $request['initValue'],
            ]) : null,
            'required' => $request['required'] ?? '0',
        ];

        $customFields->update($dataToUpdate);

        return redirect()->to('custom_field/list')->with('success', 'Cập nhật thành công');
    }

    public function delete(int $id): RedirectResponse
    {
        $customFields = CustomFields::query()->where('id', $id)->where('branch', Auth::user()->{'branch'})->firstOrFail();
        $customFields->delete();

        return redirect()->to('custom_field/list')->with('success', 'Xóa thành công');
    }
}
