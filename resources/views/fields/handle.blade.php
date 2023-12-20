@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <input
        type="text"
        disabled
        id="{{trim($field->getAttributes()['identity'])}}" class="form-control numeral-mask"
        name="{{$field->getName()}}"
        value="{{old($field->getName()) ?? $field->getValue()}}"
        placeholder="John Doe" {{$field->isRequired()?"required":""}}/>
    <label for="basic-default-name">{{$field->getLabel()}}</label>
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
@push("after_scripts")
    <script src="{{asset('demo/assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{$field->getAttributes()['js']}}"></script>
@endpush
