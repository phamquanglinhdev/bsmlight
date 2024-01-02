@php
    /**
     * @var \App\Models\Card $card
 * @var \App\Helper\Object\CommentObject[] $comments
 * @var \App\Helper\Object\TransactionObject[] $transactions
* @var int $newTransactionCount
     */

@endphp
@extends("layouts.app")
@section('content')
    <div class="container-fluid">
        <div>
            <button class="btn bg-label-primary my-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasEnd"
                    aria-controls="offcanvasEnd">Duyệt giao dịch
                @if($newTransactionCount > 0)
                    <span
                        class="ms-2 rounded-circle badge bg-danger">{{$newTransactionCount}}</span>
                @endif
            </button>
            <a href="{{url("transaction/create/card?card_id={$card['id']}")}}" class="btn bg-label-primary my-2">
                Thêm mới giao dịch
            </a>
            <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Giao dịch của thẻ học</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0">
                    <div class="overflow-auto">
                       @foreach($transactions as $transaction)
                            @include("cards.transaction",['transaction' =>$transaction])
                       @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-6 ">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Thẻ học : XXX-XXXXXX.0001</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                                {{--                                                <img src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/icons/unicons/paypal.svg" alt="paypal" class="img-fluid">--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Tổng số buổi đăng ký</h6>
                                        <small>Số buổi đăng ký gốc ({{$card->getOriginal('original_days')}}) + Số buổi
                                            tặng thêm ({{$card->getOriginal('bonus_days')}})</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{$card->getTotalDaysAttribute()}}</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Tổng số tiền cần thanh toán</h6>
                                        <small>Học phí gốc({{number_format($card->getOriginal('original_fee'))}}) - Ưu
                                            đãi({{number_format($card->getOriginal('bonus_fee'))}})</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{number_format($card->getTotalFeeAttribute())}} đ</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                                {{--                                                <img src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/icons/unicons/paypal.svg" alt="paypal" class="img-fluid">--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Đơn giá hiện tại</h6>
                                        <small>Tổng số buổi / Tổng số tiền phải thanh toán</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{number_format($card->getDailyFeeAttribute())}} đ</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                                {{--                                                <img src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/icons/unicons/paypal.svg" alt="paypal" class="img-fluid">--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Tổng số tiền đã thanh toán</h6>
                                        <small>Dựa theo tất cả các giao dịch trên thẻ học</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{number_format($card->paid_fee)}} đ</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                                {{--                                                <img src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/icons/unicons/paypal.svg" alt="paypal" class="img-fluid">--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Tổng số tiền chưa thanh toán</h6>
                                        <small></small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{number_format($card->getUnpaidFeeAttribute())}} đ</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                                {{--                                                <img src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/icons/unicons/paypal.svg" alt="paypal" class="img-fluid">--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Số buổi đã trừ</h6>
                                        <small>Van + Số buổi bị trừ theo điểm danh</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{$card->getVanAndAttendedDaysAttribute()}}</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                                {{--                                                <img src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/icons/unicons/paypal.svg" alt="paypal" class="img-fluid">--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Số buổi còn lại có thể sử dụng</h6>
                                        <small>Theo thanh toán hiện tại</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{$card->getCanUseDayByPaidAttribute()}}</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-2">
                                <div class="me-2 pe-1">
                                    <div class="avatar flex-shrink-0">
                                        <div class="avatar-initial bg-label-danger rounded">
                                            <div>
                                                {{--                                                <img src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/icons/unicons/paypal.svg" alt="paypal" class="img-fluid">--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Học phí còn lại có thể sử dụng</h6>
                                        <small></small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <h6 class="mb-0">{{number_format($card->getCanUseFeeAttribute())}} đ</h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @include('cards.comments',['comments' => $comments,'card' => $card])
            </div>
        </div>
    </div>
@endsection
@push('after_scripts')

@endpush
