@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */

    $value = $field->getValue();
    if(! is_array($value)){
        $value = json_decode($value,true);
    }
    $arrayValue = old($field->getName())  ?? $value ?? [];

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
