<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Card;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function list(Request $request)
    {
        $crudBag = new CrudBag();
        $crudBag->setLabel('Thẻ học');
        $crudBag->setSearchValue($request->get('search'));
        $crudBag->setEntity('card');
        $crudBag->addColumn([
            'name' => 'uuid',
            'label' => 'Mã thẻ',
            'type' => 'text',
        ]);

        $crudBag->addColumn([
            'name' => 'van',
            'label' => 'VAN',
            'type' => 'text',
        ]);

        $crudBag->addColumn([
            'name' => 'van_date',
            'label' => 'Ngày bắt đầu',
            'type' => 'date',
        ]);

        $query = Card::query();

        $this->handleQuery($request, $query);

        $listViewModel = new ListViewModel($query->paginate($request->get('page') ?? 1));

        return view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => $listViewModel
        ]);
    }

    public function create()
    {
        $crudBag = new CrudBag();
        $crudBag->setAction('card.store');
        $crudBag->setLabel('Thẻ học');
        $crudBag->setHasFile(true);
        $crudBag->addFields([
            'name' => 'van',
            'label' => 'Số buổi đã dùng trước khi sử dụng BSM',
            'type' => 'text'
        ]);
        $crudBag->addFields([
            'name' => 'van_date',
            'label' => 'Ngày bắt đầu sử dụng BSM',
            'type' => 'date'
        ]);

        $studentSelects = Student::query()->get(['name', 'id', 'uuid'])->mapWithKeys(function ($student) {
            return [$student->id => $student->uuid ."-". $student->name];
        })->all();

        $crudBag->addFields([
            'name' => 'student_id',
            'label' => 'Học sinh gắn với thẻ học',
            'type' => 'select',
            'nullable' => true,
            'options' => $studentSelects,
            'placeholder' => 'Học sinh gắn với thẻ học'
        ]);

        $crudBag->addFields([
            'name' => 'classroom_id',
            'label' => 'Lớp học gắn với thẻ học',
            'type' => 'select',
            'nullable' => true,
            'options' => [],
            'placeholder' => 'Học sinh gắn với thẻ học'
        ]);

        $crudBag->addFields([
            'name' => 'original_days',
            'label' => 'Số buổi thực tế đăng ký',
            'type' => 'number',
            'suffix' => 'buổi',
            'required' => true
        ]);

        $crudBag->addFields([
            'name' => 'bonus_days',
            'label' => 'Số buổi được tặng thêm',
            'type' => 'number',
            'suffix' => 'buổi',
        ]);

        $crudBag->addFields([
            'name' => 'bonus_reason',
            'label' => 'Lý do tặng',
            'type' => 'textarea',
            'class' => 'col-10 mb-4'
        ]);


        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    public function store(Request $request) {}

    public function update(Request $request, int $id) {}

    public function delete(int $id) {}

    public function show(int $id) {}

    public function edit(int $id) {}

    private function handleQuery(Request $request, Builder $query) {}

}
