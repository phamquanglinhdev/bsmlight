@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <input
        name="{{$field->getName()}}"
        value="{{old($field->getName()) ?? $field->getValue()}}"
        class="form-control" type="date"
        {{$field->isRequired()?"required":""}}
    >
    <label for="html5-date-input">{{$field->getLabel()}}</label>
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
