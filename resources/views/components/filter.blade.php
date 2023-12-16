@php use App\Helper\Filter; @endphp
@php
    /**
     * @var Filter[] $filters
     */
@endphp
<div class="my-2 mt-4">
    <div class="col-md">
        <div id="accordionCustomIcon" class="accordion mt-3 accordion-custom-button">
            <div class="accordion-item active">
                <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionCustomIconOne">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionCustomIcon-1" aria-controls="accordionCustomIcon-1" aria-expanded="true">
                        <i class="mdi mdi-filter-menu me-2"></i>
                        Bo loc
                    </button>
                </h2>

                <div id="accordionCustomIcon-1" class="accordion-collapse collapse show" data-bs-parent="#accordionCustomIcon" style="">
                    <div class="accordion-body p-2">
                        <form class="mt-3">
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
                </div>
            </div>
        </div>
    </div>
</div>
