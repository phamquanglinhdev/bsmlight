@php use App\Helper\Fields; @endphp
@php
    /**
     * @var Fields $field
     */
@endphp
<label for="basic-default-name mb-2">{{$field->getLabel()}}</label>
<div>
    @include('fields.custom_fields.'.$field->getAttributes()['view'], ['field' => $field])
</div>

@error($field->getName())
<p style="color: red;">{{ $message }}</p>
@enderror
