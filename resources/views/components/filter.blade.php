@php use App\Helper\Filter; @endphp
@php
    /**
     * @var Filter[] $filters
     */
@endphp
<div class="my-2 mt-4">
    <form>
        <div class="row align-items-center">
            @foreach($filters as $filter)
                <div class="col-md-2">
                    @include("filters.".$filter->getType(),['filter' => $filter])
                </div>
            @endforeach
            <div class="col-md-2 mb-4">
                <button class="d-block btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>
</div>
