@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <input type="text"
           class="form-control"
           name="{{$field->getName()}}"
           value="{{old($field->getName()) ?? $field->getValue()}}"
           placeholder="John Doe" {{$field->isRequired()?"required":""}}/>
    <label for="basic-default-name">{{$field->getLabel()}}</label>
    @error($field->getName())
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
