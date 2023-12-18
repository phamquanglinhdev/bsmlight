@php
    /**
     * @var \App\Helper\CrudBag $crudBag
     */
@endphp
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route($crudBag->getAction())}}" method="POST"
                  @if($crudBag->isHasFile())enctype="multipart/form-data" @endif>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Thêm mới {{$crudBag->getLabel()}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        @foreach($crudBag->getFields() as $field)
                            @include('fields.'.$field->getType(),['field' => $field])
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
</div>
