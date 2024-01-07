@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <select name="{{$field->getName()}}" id="{{$field->getName()}}" class="selectpicker w-100 small"
            data-style="btn-default"
            data-live-search="true"
        {{$field->isRequired() ? 'required' : ''}}
    >
        @if($field->isNullable() == 1)
            <option value="">Chọn</option>
        @endif
        @foreach($field->getOptions() as $key => $value)
            <option
                value="{{$key}}"
                class="small"
                @if((old($field->getName()) == $field->getValue() && $field->getValue()!=null) || $key == $field->getValue()) selected @endif>{{$value}}</option>
        @endforeach
    </select>
    <label for="{{$field->getName()}}">{{$field->getLabel()}}</label>
</div>
<style>
    .filter-option-inner-inner {
        text-transform: none !important;
    }
</style>
