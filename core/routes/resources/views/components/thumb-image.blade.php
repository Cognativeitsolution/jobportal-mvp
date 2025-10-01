@props([
    'shapeClass' => '',
    'fileName' => '',
])

<div class="{{ $shapeClass }}">
    <img src="{{ frontendImage('banner', $fileName, '100x100') }}" alt="thumb-image">
</div>
