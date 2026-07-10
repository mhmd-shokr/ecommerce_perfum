<h2>{{ __('Order Status Updated') }}</h2>

<p>
{{ __('Hello') }} {{ $order->user->name }}
</p>

<p>
{{ __('Your order') }}

<strong>{{ $order->order_number }}</strong>

{{ __('status is now') }}

<strong>{{ ucfirst($order->status) }}</strong>
</p>