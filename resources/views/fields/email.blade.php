@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <input type="email" class="form-control"
           name="{{$field->getName()}}"
           value="{{old($field->getName()) ?? $field->getValue()}}"
           {{$field->isRequired()?"required":""}}
           placeholder="name@example.com">
    <label for="exampleFormControlInput1">{{$field->getLabel()}}</label>
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
