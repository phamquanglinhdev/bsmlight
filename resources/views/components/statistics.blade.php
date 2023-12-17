@php
    use App\Helper\Statistic;
        /**
    * @var Statistic[] $statistics
     */
@endphp
<div class="my-2 mt-4">
    <div class="col-md">
        <div id="accordionCustomIcon" class="accordion mt-3 accordion-custom-button">
            <div class="accordion-item">
                <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionCustomIconOne">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                            data-bs-target="#accordionCustomIcon-1" aria-controls="accordionCustomIcon-1"
                            aria-expanded="true">
                        <i class="mdi mdi-google-analytics me-2"></i>
                        Thống kê
                    </button>
                </h2>

                <div id="accordionCustomIcon-1" class="accordion-collapse collapse"
                     data-bs-parent="#accordionCustomIcon" style="">
                    <div class="accordion-body p-2">
                        <div class="my-3 row">
                            @foreach($statistics as $statistic)
                                <div class="col-xl-3 col-sm-6 mt-5">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card-body">
                                                    <div class="card-info">
                                                        <h6 class="mb-4 pb-1 text-nowrap">{{$statistic->getLabel()}}</h6>
                                                        <div class="d-flex align-items-end mb-3">
                                                            <h4 class="mb-0 me-2">{{$statistic->getValue()}}</h4>
                                                        </div>
                                                        <div class="badge bg-label-primary rounded-pill">{{$statistic->getBadge()}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="h-100 position-relative">
                                                    <img src="{{$statistic->getImage()}}"
                                                         alt="Ratings"
                                                         class="position-absolute card-img-position scaleX-n1-rtl bottom-0 w-auto end-0 me-3 me-xl-0 me-xxl-3 pe-1"
                                                         width="95">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
