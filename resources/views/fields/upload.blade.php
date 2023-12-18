@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp

<div class="mb-3">
    <label for="formFile" class="form-label">{{$field->getLabel()}}</label>
    <input class="form-control" type="file" name="{{$field->getName()}}" id="{{$field->getName()}}">
</div>

@push('after_scripts')

@endpush
