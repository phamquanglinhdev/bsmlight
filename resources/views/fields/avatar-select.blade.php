@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<div class="row gy-3 mt-0">
    @foreach($field->getOptions() as $key => $optionValue)
        <div class="col-md-2 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
            <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="{{$field->getName().$key}}">
                  <span class="custom-option-body">
                   <img src="{{$optionValue}}" class="w-100 rounded-circle p-3" alt="">
                  </span>
                    <input id="{{$field->getName().$key}}" name="{{$field->getName()}}" class="form-check-input"
                           type="radio" value="{{$optionValue}}"
                        {{$optionValue == (old($field->getName())??$field->getValue()) ? "checked":""}} >
                </label>
            </div>
        </div>
    @endforeach
    @error($field->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
