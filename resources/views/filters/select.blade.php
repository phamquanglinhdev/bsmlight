@php use App\Helper\Fields;use App\Helper\Filter; @endphp
@php
    /**
     * @var Filter $filter
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <select name="{{$filter->getName()}}" class="form-select">
        <option value="-1">Chọn</option>
        @foreach($filter->getAttributes()['options'] as $optionValue => $optionLabel)
            <option
                value="{{$optionValue}}" {{$optionValue == (old($filter->getName())??$filter->getValue()) ? 'selected':''}}>{{$optionLabel}}</option>
        @endforeach
    </select>
    <label for="basic-default-country">{{$filter->getLabel()}}</label>
    @error($filter->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
