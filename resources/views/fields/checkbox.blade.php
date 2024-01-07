@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="form-check form-check-success">
    <input class="form-check-input" name="{{$field->getName()}}" type="checkbox" value="1" id="{{$field->getName()}}" {{$field->getValue() == 1 ? 'checked' : ''}} />
    <label class="form-check-label" for="{{$field->getName()}}">{{$field->getLabel()}}</label>
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
