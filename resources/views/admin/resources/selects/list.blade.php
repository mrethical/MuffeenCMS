
@foreach($resources as $resource)
<option data-img-src="{{ $locations['upload_images_small'] . '/' . $resource->name }}"
        data-main-img-src="{{ $locations['upload'] . '/' . $resource->name }}"
        value="{{ $resource->id }}">{{ $resource->title }}</option>
@endforeach