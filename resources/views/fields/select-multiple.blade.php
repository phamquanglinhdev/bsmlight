@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */


    $arrayValue = old($field->getName())  ?? json_decode($field->getValue(), true) ?? [];

    if(empty($arrayValue)){
        $arrayValue = [-1];
    }


@endphp
<div class="form-floating form-floating-outline mb-4">
    <div class="select2-primary">
        <select id="{{$field->getName()}}" name="{{$field->getName()}}[]" class="select2 form-select" multiple>
            @foreach($field->getOptions() as $key => $value)
                <option value="{{$key}}"
                        @if(in_array($key,$arrayValue)) selected @endif >{{ $value}}</option>
            @endforeach
        </select>
    </div>
    <label for="select2Primary">{{$field->getLabel()}}</label>
</div>
