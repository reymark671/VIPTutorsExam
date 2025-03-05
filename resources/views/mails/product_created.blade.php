@component('mail::message')
# New Product Created

A new product **{{ $product->title }}** has been created.

@component('mail::button', ['url' => route('products.show', $product)])
View Product
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
