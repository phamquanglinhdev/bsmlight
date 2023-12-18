@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <textarea
        class="form-control h-px-100"
        name="{{$field->getName()}}"
        {{$field->isRequired()?"required":""}}
        placeholder="Nhập {{$field->getLabel()}}"
    >{{old($field->getName()) ?? $field->getValue()}}</textarea>
    <label for="basic-default-name">{{$field->getLabel()}}</label>
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
