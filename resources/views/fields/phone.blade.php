@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="input-group input-group-merge">
    <span class="input-group-text">VN (+84)</span>
    <div class="form-floating form-floating-outline">
        <input name="{{$field->getName()}}"
               value="{{old($field->getName()) ?? $field->getValue()}}"
               type="text" id="phone-number-mask"
               class="form-control phone-number-mask" placeholder="202 555 0111">
        <label for="phone-number-mask">{{$field->getLabel()}}</label>
    </div>
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
@push('after_scripts')
    <script src="{{asset('demo/assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('demo/assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
    <script src="{{asset('demo/assets/js/forms-extras.js')}}"></script>
@endpush
