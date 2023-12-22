<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Card;
use App\Models\Classroom;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClassroomController extends Controller
{
    public function list(Request $request)
    {
        $crudBag = new CrudBag();

        $crudBag->setLabel('Lớp học');
        $crudBag->setEntity('classroom');
        $crudBag->setSearchValue('search');
        $crudBag = $this->handleFiltering($crudBag, $request);
        $crudBag = $this->handleStatistic($crudBag, $request);
        $crudBag = $this->handleColumn($crudBag, $request);
        $query = Classroom::query();
        $listModelView = new ListViewModel($query->paginate($request->get('perPage') ?? 10));
        return view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => $listModelView
        ]);
    }

    private function handleColumn($crudBag, $request)
    {
        $crudBag->addColumn([
            'name' => 'name',
            'label' => 'Lớp học',
            'type' => 'profile',
            'attributes' => [
                'identity' => 'id',
                'entity' => 'classroom',
                'address' => 'uuid',
                'avatar' => 'avatar',
            ]
        ]);


        return $crudBag;
    }

    private function handleFiltering(CrudBag $crudBag, Request $request): CrudBag
    {

        return $crudBag;
    }

    private function handleStatistic($crudBag, Request $request)
    {

        return $crudBag;
    }

    public function create()
    {
        $crudBag = new CrudBag();

        $crudBag->addFields([
            'name' => 'avatar',
            'type' => 'avatar-select',
            'required' => false,
            'label' => 'Chọn ảnh lớp học',
            'options' => [
                'https://www.iconbunny.com/icons/media/catalog/product/4/0/4082.9-class-icon-iconbunny.jpg',
                'https://cdn-icons-png.flaticon.com/512/3352/3352938.png'
            ],
            'class' => 'col-10 mb-3'
        ]);

        $crudBag->addFields([
            'name' => 'name',
            'type' => 'text',
            'required' => true,
            'label' => 'Tên lớp học',
        ]);

        if (Auth::user()->{'role'} === User::HOST_ROLE) {
            $crudBag->addFields([
                'name' => 'staff_id',
                'type' => 'select',
                'label' => 'Nhân viên phụ trách',
                'nullable' => true,
                'options' => Staff::query()->get()->mapwithkeys(function ($staff) {
                    return [$staff->id => $staff->uuid . " - " . $staff->name];
                })->all(),
                'value' => null
            ]);
        }

        $crudBag->addFields([
            'name' => 'book',
            'type' => 'text',
            'label' => 'Tên giáo trình',
        ]);

        $crudBag->addFields([
            'name' => 'card_ids',
            'type' => 'select-multiple',
            'label' => 'Gắn thẻ học',
            'options' => Card::query()->get()->mapwithkeys(function (Card $card) {
                return [$card->id => $card->uuid . '-' . $card->student?->name ?? 'Chưa gắn học sinh'];
            })->all(),
            'class' => 'col-10 mb-3'
        ]);

        $crudBag->addFields([
            'name' => 'card_schedules',
            'type' => 'select-multiple',
        ]);

        $crudBag->setAction('classroom.store');
        $crudBag->setEntity('classroom');
        $crudBag->setLabel('Lớp học');

        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'avatar' => 'required'
        ]);

        $dataToCreate = [
            'name' => $request->get('name'),
            'avatar' => $request->get('avatar'),
            'uuid' => Classroom::generateUUID()
        ];


        DB::transaction(function () use ($dataToCreate) {
            Classroom::query()->create($dataToCreate);
        });

        return redirect()->to('/classroom/list')->with('success', 'Tạo lớp học thành công');
    }
}
