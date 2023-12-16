@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <select name="{{$field->getName()}}" class="form-select" {{$field->isRequired()?"required":""}}>
        @if($field->isNullable())
            <option value="">Chọn</option>
        @endif

        @foreach($field->getOptions() as $optionValue => $optionLabel)
            <option value="{{$optionValue}}" {{$optionValue == (old($field->getName())??$field->getValue()) ? 'selected':''}}>{{$optionLabel}}</option>
        @endforeach
    </select>
    <label for="basic-default-country">{{$field->getLabel()}}</label>
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
