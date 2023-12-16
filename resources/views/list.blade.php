@php
    use App\Helper\CrudBag;use App\Helper\ListViewModel;
@endphp
@php
    /**
     * @var ListViewModel $listViewModel
     * @var CrudBag $crudBag
     */
@endphp
@extends("layouts.app")
@section("content")
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="">
            <span class="text-muted fw-light">{{$crudBag->getLabel()}} /</span> Danh sách
        </h4>
        @include("components.statistics")
        <div class="d-flex justify-content-between mt-4">
            <a href="{{url($crudBag->getEntity()."/create")}}" class="btn btn-primary waves-effect waves-light mb-2">
                Thêm mới {{$crudBag->getLabel()}}</a>
           <div class="col-md-3">
               <input type="search" class="form-control" placeholder="Tìm kiem">
           </div>
        </div>
        @include("components.filter",['filters' => $crudBag->getFilters()])
        <div class="table-responsive text-nowrap shadow-lg" style="height: 70vh">
            <table class="table shadow" id="myTable">
                <thead>
                <tr class="text-nowrap" style="position: sticky;top: 0; z-index: 50">
                    @foreach($crudBag->getColumns() as $column)
                        @if($column->getFixed() == 'first')
                            <th class="border fw-bold bg-primary fixed-left"
                                style="position: sticky;top: 0!important; z-index: 1">{{$column->getLabel()}}</th>
                        @else
                            <th class="border fw-bold bg-primary">{{$column->getLabel()}}</th>
                        @endif
                    @endforeach
                    <th class="border fw-bold bg-primary">Hành động</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($listViewModel->getCollectionItem() as $item)
                    <tr>
                        @foreach($crudBag->getColumns() as $column)
                            @include("columns.".$column->getType(),['item' => $item,'column' => $column])
                        @endforeach
                        <th class="border text-center">
{{--                            <a href="{{url($crudBag->getEntity()."/edit/".$item['id'])}}">--}}
{{--                                <span class="mdi mdi-square-edit-outline"></span>--}}
{{--                            </a>--}}
                            <a href="{{url($crudBag->getEntity()."/delete/".$item['id'])}}">
                                <span class="mdi mdi-delete"></span>
                            </a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            @include("components.pagination",['paginator' => $listViewModel->getOriginCollection()])
        </div>
    </div>
@endsection
@push('after_scripts')
    <style>
        .fixed-left {
            position: sticky;
            left: 0;
        }
    </style>
    @if(session('success'))
        <script>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 2000 // Thời gian hiển thị thông báo (5 giây)
            };
            toastr.success('{{session('success')}}', 'Thành công');
        </script>
    @endif
@endpush
