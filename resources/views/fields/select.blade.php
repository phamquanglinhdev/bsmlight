@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <select name="{{$field->getName()}}" id="{{$field->getName()}}" class="selectpicker w-100" data-style="btn-default" data-live-search="true">
        @if($field->isNullable())
            <option value="">Chọn</option>
        @endif
        @foreach($field->getOptions() as $key => $value)
            <option data-tokens="ketchup mustard"
                    value="{{$key}}"
                    @if($key == $field->getValue()) selected @endif>{{$value}}</option>
        @endforeach
    </select>
    <label for="{{$field->getName()}}">{{$field->getLabel()}}</label>
</div>
