@php use App\Helper\Column; @endphp
@php
    /**
    * @var array $item
    * @var Column $column
    */
    $avatar = $column->getAttributes()['avatar'];
    $address = $column->getAttributes()['address'];
    $identity = $column->getAttributes()['identity']
@endphp

<td class="border {{$column->getFixed() == 'first' ? 'fixed-left':''}}">
    <div class="d-flex align-items-center">
        <img style="width: 2rem;height: 2rem" class="rounded-circle d-block me-2"
             src="{{$item[$avatar]??"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS0Oi53Y0SYUnNZ6FDFALWjbzr2siFFZqRAI_ygcnbVunsa0Ywsn1u1xGx7FisdgzGdcQ&usqp=CAU"}}">
        <div>
            <div class="mb-1">
                {{$item[$column->getName()]}}
                @if(check_permission('edit '.$crudBag->getEntity()))
                    <a href="{{url($crudBag->getEntity()."/edit/".$item[$identity])}}">
                        <span class="mdi mdi-square-edit-outline"></span>
                    </a>
                @endif
            </div>
            <div class="small"><span class="small mdi mdi-map-marker"></span> {{$item[$address]??"--"}}</div>
        </div>
    </div>

</td>
