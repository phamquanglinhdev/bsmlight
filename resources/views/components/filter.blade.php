@php use App\Helper\Filter; @endphp
@php
    /**
     * @var Filter[] $filters
     */
@endphp
<div class="my-2 mt-4">
    <div class="col-md">
        <div id="filteringTab" class="accordion mt-3 accordion-custom-button">
            <div class="accordion-item">
                <h2 class="accordion-header text-body d-flex justify-content-between" id="filteringTabOne">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                            data-bs-target="#filteringTabOne" aria-controls="accordionCustomIcon-1"
                            aria-expanded="true">
                        <i class="mdi mdi-filter-menu me-2"></i>
                        Bộ lọc
                    </button>
                </h2>

                <div id="filteringTabOne" class="accordion-collapse collapse" data-bs-parent="#filteringTab"
                     style="">
                    <div class="accordion-body p-2">
                        <form class="mt-3 replace_form" id="filtering_form">
                            <div class="row align-items-center">
                                @foreach($filters as $filter)
                                    <div class="col-md-2">
                                        @include("filters.".$filter->getType(),['filter' => $filter])
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-4 d-flex">
                                <button class="d-block btn btn-primary me-2">Lọc</button>
                                <button onclick="resetAndSubmitForm()" type="reset" class="d-block btn btn-danger">Reset
                                    bộ lọc
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('after_scripts')
    <script>
        function resetAndSubmitForm() {
            const form = document.getElementById("filtering_form");
            const formElements = form.elements;
            for (let i = 0; i < formElements.length; i++) {
                formElements[i].value = null;
            }
            form.submit();
        }

        $(document).ready(function () {
            const queryString = window.location.search;
            console.log('Filtering logic based on query string:', queryString);

            $('.replace_form').submit(function (e) {
                e.preventDefault();
                const queryString = window.location.search;
                let formData = $(this).serializeArray();
                const queryArray = queryString.substring(1).split('&');
                const queryObjects = queryArray.map(function (param) {
                    const pair = param.split('=');
                    return {
                        name: decodeURIComponent(pair[0]),
                        value: decodeURIComponent(pair[1] || '')
                    };
                });
                const formObject = mergeAndExcludeByName(queryObjects, formData)
                const finalQueryString = $.param(formObject)
                window.location.href = `${window.location.pathname}?${finalQueryString}`;
            });
        });
    </script>
    <script>
        function mergeAndExcludeByName(array1, array2) {
            const resultArray = [];
            array1.forEach(function (obj) {
                resultArray.push({...obj});
            });
            array2.forEach(function (obj2) {
                const existingObj = resultArray.find(obj1 => obj1.name === obj2.name);
                if (!existingObj) {
                    resultArray.push({...obj2});
                } else {
                    existingObj.value = obj2.value;
                }
            });
            return resultArray;
        }
    </script>
@endpush
