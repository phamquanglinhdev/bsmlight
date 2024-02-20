@php
    /**
     * @var \App\Helper\Object\TransactionObject $transaction
     */
@endphp
<div class="mb-3">
    <a class="bg-label-github w-100 p-2 d-block text-start" data-bs-toggle="collapse" href="#transaction-{{$transaction->getId()}}"
       role="button" aria-expanded="false" aria-controls="collapseExample">
        Giao dịch #{{$transaction->getUuid()}}
        @if(!$transaction->isNew())
            @if($transaction->getAccepted())
                <span class="badge bg-label-success ms-2">Đã duyệt</span>
            @else
                <span class="badge bg-label-danger ms-2">Từ chối</span>
            @endif
        @endif
    </a>
    <div class="collapse border p-2" id="transaction-{{$transaction->getId()}}">
        <div class="fw-bold h3 m-0 text-center my-2 mb-3">{{number_format($transaction->getAmount())}} đ</div>
        <div class="d-flex align-items-center mb-2">
            <div class="me-1">Người tạo :</div>
            <img alt="" class="avatar-xs me-1 rounded-circle"
                 src="{{$transaction->getCreatorAvatar()}}">
            <div class="me-1">{{$transaction->getCreatorName()}}</div>
        </div>
        <div class="mb-2">
            <div>Ghi chú:</div>
            <div><i>"{{$transaction->getNote()}}"</i></div>
        </div>
        <div class="my-2">
            <div>Ngày tạo: {{$transaction->getCreatedAt()}}</div>
        </div>
        <div>Ảnh giao dịch: <a target="_blank" href="{{url('/').'/'.$transaction->getImage()}}"><span class="mdi mdi-image-check"></span></a></div>
        @if(check_permission('accept transaction') && $transaction->isNew())
            <div class="my-4 small">
                <div class="row m-0 justify-content-between align-items-center">
                    <a href="{{url('transaction/accept/'.$transaction->getId())}}"
                       class="btn btn-success col-md-6 rounded-0">
                        <span class="mdi mdi-check-circle"></span>
                        <span class="small">Duyệt GD</span>
                    </a>
                    <a href="{{url('transaction/deny/'.$transaction->getId())}}"
                       class="btn btn-danger col-md-6 rounded-0">
                        <span class="mdi mdi-close-circle"></span>

                        <span class="small">Từ chối GD</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
