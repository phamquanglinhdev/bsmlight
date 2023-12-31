<div class="small">
    <div class="my-2 badge bg-label-google-plus">Học sinh - Thẻ học</div>

   <div class="row">
       @foreach([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] as $k)
           <div class="col-md-6 col-12 mb-2">
               <a class="small p-2 bg-label-github me-1 w-100 text-start" type="button" data-bs-toggle="collapse"
                  data-bs-target="#multiCollapseExample{{$k}}" aria-expanded="false" aria-controls="multiCollapseExample{{$k}}">
                   <div class="d-flex align-items-center">
                       <img src="https://i.pinimg.com/474x/01/0d/85/010d85a0b5b608e2c3e43b32e44897be.jpg" class="avatar-xs me-2 rounded-circle">
                       <span>Phạm Quang Linh [BSM-CN-0001-StudyCard.0001]</span>
                   </div>
               </a>
               <div class="collapse multi-collapse" id="multiCollapseExample{{$k}}">
                   <div class="p-3 border">
                       <div>Thẻ học: BSM-CN-0001-StudyCard.0001 </div>
                       <div>Tên học sinh: Phạm Quang Linh  </div>
                       <div>Mã học sinh: BSM-CN-0001-HS.0001 </div>
                       <div>Trạng thái:  Đi học, đúng giờ</div>
                       <div>Trừ buổi học:  <span class="text-success fw-bold">Có</span></div>
                       <div class="mt-2">Lời nhắn của giáo viên cho HS/PHHS:  </div>
                       <div class="p-1">
                           <i>
                               "Bạn linh học tốt lắm"
                           </i>
                       </div>
                       <div class="mt-2">Lời nhắn của trợ giảng cho HS/PHHS:  </div>
                       <div class="p-1">
                           <i>
                               "Bạn linh học tốt lắm"
                           </i>
                       </div>
                   </div>
               </div>
           </div>
       @endforeach
   </div>

</div>
