@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <div class="select2-primary">
        <select id="{{$field->getName()}}" name="{{$field->getName()}}" class="select2 form-select" multiple>
            @foreach($field->getOptions() as $key => $value)
                <option value="1" @if($key == $field->getValue()) selected @endif>{{ $value}}</option>
            @endforeach
        </select>
    </div>
    <label for="select2Primary">{{$field->getLabel()}}</label>
</div>
