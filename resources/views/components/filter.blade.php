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
            <div class="col-md-2 mb-4 d-flex justify-content-around align-items-baseline">
                <button class="d-block btn btn-primary">Lọc</button>
                <button type="reset" class="d-block btn btn-danger">Xoa loc</button>
            </div>
        </div>
    </form>
</div>
