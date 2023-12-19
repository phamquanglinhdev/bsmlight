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
        @include("components.statistics",['statistics'=>$crudBag->getStatistics()])
        <div class="d-flex justify-content-between mt-4">
            @if(force_permission("list ".$crudBag->getEntity()))
                <a href="{{url($crudBag->getEntity()."/create")}}"
                   class="btn btn-primary waves-effect waves-light mb-2">
                    Thêm mới {{$crudBag->getLabel()}}</a>
            @endif
            <div class="col-md-3">
                <form class="form replace_form" id="search_form">
                    <input name="search" value="{{old('search') ?? $crudBag->getSearchValue()}}" type="search"
                           class="form-control" placeholder="Tìm kiếm">
                </form>
            </div>
        </div>
        @include("components.filter",['filters' => $crudBag->getFilters()])
        <div class="table-responsive text-nowrap shadow-lg" style="height: 70vh;scroll-behavior: smooth;">
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
                            @if(check_permission("delete ".$crudBag->getEntity()))
                                <a class="delete-action" href="{{url($crudBag->getEntity()."/delete/".$item['id'])}}">
                                    <span class="mdi mdi-delete"></span>
                                </a>
                            @endif
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
    <script>
        $(".delete-action").click((e) => {
            e.preventDefault();
            const result = confirm("Bạn có chắc chắn muốn xóa {{$crudBag->getLabel()}}");

            if (result) {
                window.location.href = e.currentTarget.href;
            }
        })
    </script>
@endpush
