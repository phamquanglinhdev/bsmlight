@php use App\Helper\Filter; @endphp
@php
    /**
     * @var Filter $filter
     */
@endphp
<div class="form-floating form-floating-outline mb-4">
    <input type="text"
           class="form-control"
           name="{{$filter->getName()}}"
           value="{{old($filter->getName()) ?? $filter->getValue()}}"
    />
    <label for="basic-default-name">{{$filter->getLabel()}}</label>
    @error($filter->getName())
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
