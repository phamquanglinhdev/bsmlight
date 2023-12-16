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
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">{{$crudBag->getLabel()}} /</span> Danh sách
        </h4>
        <div class="table-responsive text-nowrap">
            <table class="table shadow">
                <thead>
                <tr class="text-nowrap">
                    @foreach($crudBag->getColumns() as $column)
                        <th class="border fw-bold">{{$column->getLabel()}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($listViewModel->getCollectionItem() as $item)
                    <tr>
                        @foreach($crudBag->getColumns() as $column)
                            @include("columns.".$column->getType(),['item' => $item,'column' => $column])
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
