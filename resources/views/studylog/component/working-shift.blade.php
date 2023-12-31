<div class="small">
    <div class="my-2 badge bg-label-google-plus mt-4">Ca học</div>
    @foreach([1,2] as $k)
        <div class="mb-2">
            <a class="w-100 p-2 bg-label-github me-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#ws-{{$k}}" aria-expanded="false" aria-controls="">
                Ca học 10:44 - 11:44
            </a>
            <div class="collapse multi-collapse" id="ws-{{$k}}">
                <div class="p-2 border">
                    <div>Thời gian : 10:44 - 11:44</div>
                    <div>Giáo viên : Nguên Anh</div>
                    <div>Trợ giảng : Nguên Anh</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
