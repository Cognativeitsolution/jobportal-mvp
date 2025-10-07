@props([
    'shapeClass' => '',
    'fileName' => '',
])

<div class="{{ $shapeClass }}">
    <img src="{{ asset($activeTemplateTrue . 'images/shapes/' . $fileName . '.png') }}" alt="shape-image">
</div>
