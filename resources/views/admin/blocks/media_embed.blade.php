@twillBlockTitle('Media embed')
@twillBlockIcon('text')

@formField('input', [
    'name' => 'embed_code',
    'label' => 'Media embed code',
    'type' => 'textarea'
])

@formField('input', [
    'name' => 'embed_height',
    'label' => 'Height override',
    'note' => 'Optional. Use CSS units, e.g. "400px"',
])

@formField('checkbox', [
    'name' => 'disable_placeholder',
    'label' => 'Disable placeholder element',
])
