<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Card;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CardController extends Controller
{
    public function list(Request $request)
    {
        $crudBag = new CrudBag();
        $crudBag->setLabel('Thẻ học');
        $crudBag->setSearchValue($request->get('search'));
        $crudBag->setEntity('card');
        $this->handleColumn($request, $crudBag);

        $query = Card::query();

        $this->handleQuery($request, $query);

        $listViewModel = new ListViewModel($query->paginate($request->get('perPage') ?? 10));

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
            'label' => 'Ngày chốt điểm danh ở hệ thống cũ (VAN)',
            'type' => 'date'
        ]);

        $studentSelects = Student::query()->get(['name', 'id', 'uuid'])->mapWithKeys(function ($student) {
            return [$student->id => $student->uuid . "-" . $student->name];
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
            'name' => 'drive_link',
            'label' => 'Lên PDF đơn đăng ký',
            'type' => 'text',
        ]);

        $crudBag->addFields([
            'name' => 'commitment',
            'label' => 'Cam kết đầu ra nếu có',
            'type' => 'text',
        ]);

        $crudBag->addFields([
            'name' => 'original_days',
            'label' => 'Số buổi đăng ký gốc',
            'type' => 'number',
            'suffix' => 'buổi',
            'required' => true,
            'class' => 'col-4 mb-2'
        ]);

        $crudBag->addFields([
            'name' => 'bonus_days',
            'label' => 'Số buổi được tặng thêm',
            'type' => 'number',
            'suffix' => 'buổi',
            'class' => 'col-3 mb-2'
        ]);

        $crudBag->addFields([
            'name' => false,
            'label' => 'Số buổi thực tế đăng ký',
            'type' => 'handle',
            'suffix' => 'buổi',
            'class' => 'col-3 mb-2',
            'attributes' => [
                'js' => asset('/demo/js/handle-total-day.js'),
                'identity' => 'total_days'
            ]
        ]);

        $crudBag->addFields([
            'name' => 'bonus_reason',
            'label' => 'Lý do tặng',
            'type' => 'textarea',
            'class' => 'col-10 mb-2'
        ]);

        $crudBag->addFields([
            'name' => 'original_fee',
            'label' => 'Học phí gốc',
            'type' => 'number',
            'required' => true,
            'suffix' => 'đ',
        ]);


        $crudBag->addFields([
            'name' => 'promotion_fee',
            'label' => 'Học phí ưu đãi',
            'type' => 'number',
            'required' => true,
            'suffix' => 'đ',
            'class' => 'col-3 mb-2'
        ]);

        $crudBag->addFields([
            'name' => false,
            'label' => '% Ưu đãi',
            'type' => 'handle',
            'class' => 'col-2 mb-2',
            'attributes' => [
                'js' => asset('/demo/js/handle-promotion-percent.js'),
                'identity' => 'promotion-percent'
            ]
        ]);

        $crudBag->addFields([
            'name' => 'fee_reason',
            'label' => 'Lý do ưu đãi',
            'type' => 'textarea',
            'class' => 'col-10 mb-2'
        ]);

        $crudBag->addFields([
            'name' => false,
            'label' => 'Học phí thực tế cần đóng',
            'type' => 'handle',
            'attributes' => [
                'js' => asset('/demo/js/handle-total-fee.js'),
                'identity' => 'total_fee'
            ],
        ]);

        $crudBag->addFields([
            'name' => false,
            'label' => 'Đơn giá buổi học',
            'type' => 'handle',
            'attributes' => [
                'js' => asset('/demo/js/handle-daily-fee.js'),
                'identity' => 'daily_fee'
            ],
        ]);

        $crudBag->addFields([
            'name' => 'payment_plant',
            'label' => 'Kế hoạch thanh toán (nếu có)',
            'type' => 'textarea',
            'class' => 'col-10 mb-2'
        ]);

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
            'van' => 'integer|nullable',
            'van_date' => 'date|nullable',
            'student_id' => 'integer|nullable|not_in:0',
            'classroom_id' => 'integer|nullable|not_in:0',
            'original_days' => 'string|required|min:1',
            'bonus_days' => 'string|nullable',
            'bonus_reason' => 'string|nullable',
            'original_fee' => 'string|required|min:1',
            'promotion_fee' => 'string|nullable|min:1',
            'fee_reason' => 'string|nullable',
            'payment_plant' => 'string|nullable',
            'drive_link' => 'string|nullable',
            'commitment' => 'string|nullable',
        ]);
        $dataToCreate = [
            'uuid' => Card::genarateUUID(Auth::user()->{'branch'}),
            'branch' => Auth::user()->{'branch'},
            'van' => $request->{'van'} ?? 0,
            'van_date' => $request->{'van_date'},
            'student_id' => $request->{'student_id'},
            'classroom_id' => $request->{'classroom_id'},
            'original_days' => str_replace('.', '', $request->{'original_days'}),
            'bonus_days' => str_replace(',', '', $request->{'bonus_days'} ?? 0),
            'bonus_reason' => $request->{'bonus_reason'},
            'original_fee' => str_replace(',', '', $request->{'original_fee'}),
            'promotion_fee' => str_replace(',', '', $request->{'promotion_fee'} ?? 0),
            'fee_reason' => $request->{'fee_reason'},
            'payment_plant' => $request->{'payment_plant'},
            'drive_link' => $request->{'drive_link'},
            'commitment' => $request->{'commitment'},
        ];

        Card::query()->create($dataToCreate);

        return redirect('/card/list')->with('success', 'Thêm mới thành công');
    }

    public function update(Request $request, int $id)
    {
    }

    public function delete(int $id)
    {
    }

    public function show(int $id)
    {
    }

    public function edit(int $id)
    {
    }

    private function handleQuery(Request $request, Builder $query)
    {
    }

    private function handleColumn(Request $request, CrudBag $crudBag)
    {
        /**
         * Mã thẻ học + Trạng thái thẻ học $uuid + $card_status
         * Học sinh được thụ hưởng (mã, ảnh , tên, tên tiếng anh) $student_id
         * Lớp đang được xếp (mã , ảnh, tên ) $classroom_id
         * Tổng số buổi đăng ký $total_days
         * Tổng số tiền cần thanh toán $total_fee
         * Đơn giá một buổi $daily_fee
         * Tổng số tiền đã thanh toán $paid_fee
         * Số buổi được sử dụng theo thanh toán $can_use_day_by_paid
         * Số tiền chưa thanh toán $unpaid_fee
         * Van và số buổi bị trừ khi điểm danh $van + $attended_days
         * Số buổi còn lại có thể sử dụng $can_use_day
         *  Phân loại renew $renew_type
         * Số học phí còn lại có thể sử dụng $can_use_fee
         * Điểm feedback $feedback_score
         *  Ngày tháng năm lấy feedback $latest_feedback_date
         * Trạng thái tiến độ sale $sale_status
         * Ngày tháng năm cập nhật sale  $sale_updated_at
         */
        $crudBag->addColumn([
            'name' => 'uuid',
            'label' => 'Mã thẻ học',
            'type' => 'text',
            'fixed' => 'first'
        ]);

        $crudBag->addColumn([
            'name' => 'student_id',
            'label' => 'Học sinh',
            'type' => 'entity',
            'attributes' => [
                'entity' => 'student_entity',
                'model' => 'student',
                'id' => 'id',
                'avatar' => 'avatar',
                'name' => 'name',
                'uuid' => 'uuid',
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'classroom_id',
            'label' => 'Lớp đang được xếp',
            'type' => 'entity',
            'attributes' => [
                'entity' => 'classroom_entity',
                'model' => 'classroom',
                'id' => 'id',
                'name' => 'name',
                'uuid' => 'uuid',
                'avatar' => 'avatar',
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'total_days',
            'label' => 'Tổng số buổi đăng ký',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'total_fee',
            'label' => 'Tổng số tiền cần thanh toán',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'daily_fee',
            'label' => 'Đơn giá một buổi',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'paid_fee',
            'label' => 'Tổng số đã thanh toán',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'can_use_day_by_paid',
            'label' => 'Số buổi được sử dụng theo thanh toán',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'unpaid_fee',
            'label' => 'Số tiền chưa thanh toán',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'van_and_attended_days',
            'label' => 'Van và số buổi bị trừ khi điểm danh',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'can_use_day',
            'label' => 'Số buổi còn lại có thể sử dụng',
            'type' => 'number'
        ]);
        /**
         * <0 buổi = SOS: màu đỏ
         * =0 buổi = X: màu nâu
         *
         * 0-6 buổi = A: màu tím
         *
         * 7-12 buổi = B: màu xanh lá
         *
         * 13-24 buổi = C: màu xanh lá nhạt
         *
         * 25-48 buổi = D: màu xám
         *
         * >48 buổi = E: màu trắng
         */
        $crudBag->addColumn([
            'name' => 'renew_type',
            'label' => 'Phân loại renew',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    'SOS' => 'SOS',
                    'X' => 'X',
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                ],
                'bg' => [
                    'SOS' => 'bg-danger',
                    'X' => 'bg-info',
                    'A' => 'bg-warning',
                    'B' => 'bg-success',
                    'C' => 'bg-orange',
                    'D' => 'bg-purple',
                    'E' => 'bg-secondary',
                ]
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'can_use_fee',
            'label' => 'Số học phí còn lại có thể sử dụng',
            'type' => 'number'
        ]);

        $crudBag->addColumn([
            'name' => 'feedback_score',
            'label' => 'Điểm feedback',
            'type' => 'text'
        ]);

        $crudBag->addColumn([
            'name' => 'latest_feedback_date',
            'label' => 'Ngày tháng năm lấy feedback',
            'type' => 'text'
        ]);

        $crudBag->addColumn([
            'name' => 'sale_status',
            'label' => 'Trạng thái tiến độ sale',
            'type' => 'text'
        ]);

        $crudBag->addColumn([
            'name' => 'sale_updated_at',
            'label' => 'Ngày tháng năm cập nhật sale',
            'type' => 'text'
        ]);

        return $crudBag;
    }

}
