@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
@php

    /**
     * @var LengthAwarePaginator $paginator
     */
@endphp
{{-- resources/views/custom/pagination.blade.php --}}

<style>
    .pagination li span {
        width: 2rem !important;
        height: 2rem !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<nav class="mt-4 d-flex justify-content-between">
    <label>
            <span class="me-1">
                Hiển thị
            </span>
        <select id="perPage">
            <option {{$paginator->perPage() == 10 ?'selected':''}}>10</option>
            <option {{$paginator->perPage() == 20 ?'selected':''}} href="#">20</option>
            <option {{$paginator->perPage() == 50 ?'selected':''}}>50</option>
            <option {{$paginator->perPage() == 100 ?'selected':''}}>100</option>
        </select>
        <span>
                 bản ghi / trang
             </span>
    </label>
    @if ($paginator->hasPages())
        <ul class="pagination">
            @if (! $paginator->onFirstPage())
                <li class="mx-1">
                    <a href="{{ $paginator->url(1) }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <span class="mdi mdi-skip-previous"></span>
                    </a>
                </li>
                <li class="mx-1">
                    <a href="{{$paginator->previousPageUrl()}}" rel="prev" aria-label="@lang('pagination.previous')">
                        <span class="text-primary p-1 rounded-circle">{{$paginator->currentPage()-1}}</span>
                    </a>
                </li>
            @endif

            <li class="mx-1">
                <a href="" aria-label="@lang('pagination.previous')">
                    <span class="text-white bg-primary p-1 rounded-circle">{{$paginator->currentPage()}}</span>
                </a>
            </li>

            @if ($paginator->hasMorePages())
                <li class="mx-1">
                    <a href="{{$paginator->nextPageUrl()}}" rel="prev" aria-label="@lang('pagination.previous')">
                        <span class="text-primary p-1 rounded-circle">{{$paginator->currentPage()+1}}</span>
                    </a>
                </li>
                <li class="mx-1">
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" rel="prev"
                       aria-label="@lang('pagination.previous')">
                        <span class="mdi mdi-skip-next"></span>
                    </a>
                </li>
            @endif
        </ul>
    @endif
</nav>

@push("after_scripts")
    <script>
        $("#perPage").change((e) => {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('perPage', e.target.value);
            urlParams.set('page', 1);
            const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
            window.history.pushState({}, '', newUrl);
            window.reloadPageSmoothly()
        })

        $(".pagination a").click((e) => {
            e.preventDefault()
            const url = new URL(e.currentTarget.href);
            const searchParams = url.searchParams;
            const page = searchParams.get('page');
            //
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', page);
            const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
            window.history.pushState({}, '', newUrl);
            window.reloadPageSmoothly()
        })
    </script>
@endpush
