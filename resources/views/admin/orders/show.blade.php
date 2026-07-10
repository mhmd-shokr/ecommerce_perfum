@extends('layouts.admin.app')
@section('title', __('Order Details'))

@section('content')
<div style="padding:32px;max-width:1100px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
        <a href="{{ route('admin.orders.index') }}"
           style="padding:8px 16px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:12px;font-family:Arial,sans-serif;text-decoration:none;">
            ← {{ __('Back') }}
        </a>
        <div>
            <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
                {{ $order->order_number }}
            </h1>
            <p style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;">
                {{ $order->created_at->format('d M Y, h:i A') }}
            </p>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div style="background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:#7ab87a;font-family:Arial,sans-serif;margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start;">

        {{-- Left --}}
        <div>

            {{-- Items --}}
            <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
                    {{ __('Items Ordered') }}
                </div>
                <div style="padding:20px 24px;">
                    @foreach($order->items as $item)
                        <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid rgba(200,169,106,0.08);">
                            @if($item->product?->images)
                                <img src="{{ asset('storage/' . $item->product->images) }}"
                                     style="width:52px;height:52px;border-radius:8px;object-fit:cover;border:1px solid rgba(200,169,106,0.15);">
                            @else
                                <div style="width:52px;height:52px;border-radius:8px;background:rgba(200,169,106,0.06);border:1px solid rgba(200,169,106,0.15);display:flex;align-items:center;justify-content:center;font-size:22px;">
                                    🧴
                                </div>
                            @endif
                            <div style="flex:1;">
                                <div style="font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;margin-bottom:3px;">
                                    {{ $item->product_name }}
                                </div>
                                <div style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;">
                                    {{ __('Qty') }}: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}
                                </div>
                            </div>
                            <div style="font-size:14px;color:#C8A96A;font-family:Arial,sans-serif;font-weight:600;">
                                ${{ number_format($item->total, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Address --}}
            <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">
                <div style="padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
                    {{ __('Delivery Address') }}
                </div>
                <div style="padding:20px 24px;font-size:13px;color:#9a8870;font-family:Arial,sans-serif;line-height:1.8;">
                    <strong style="color:#f0e6d0;">{{ $order->address->full_name }}</strong><br>
                    {{ $order->address->phone }}<br>
                    {{ $order->address->street }},
                    @if($order->address->building) {{ __('Building') }} {{ $order->address->building }}, @endif
                    @if($order->address->floor) {{ __('Floor') }} {{ $order->address->floor }}, @endif
                    <br>
                    {{ $order->address->city }}, {{ $order->address->governorate }}
                </div>
            </div>

        </div>

        {{-- Right --}}
        <div>

            {{-- Summary --}}
            <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
                    {{ __('Order Summary') }}
                </div>
                <div style="padding:20px 24px;">
                    @foreach([
                        __('Customer')       => $order->user?->name ?? __('Deleted'),
                        __('Subtotal')       => '$'.number_format($order->sub_total, 2),
                        __('Shipping')       => '$'.number_format($order->shipping_cost, 2),
                        __('Total')          => '$'.number_format($order->total, 2),
                        __('Payment Method') => ucfirst($order->payment_method),
                        __('Payment Status') => ucfirst($order->payment_status),
                    ] as $label => $val)
                        <div style="display:flex;justify-content:space-between;font-size:13px;font-family:Arial,sans-serif;margin-bottom:10px;">
                            <span style="color:#5a5040;">{{ $label }}</span>
                            <span style="color:#f0e6d0;">{{ $val }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Update Status --}}
            <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">
                <div style="padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
                    {{ __('Update Status') }}
                </div>
                <div style="padding:20px 24px;">
                    <form method="POST" action="{{ route('admin.order.update', $order->id) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                            style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;margin-bottom:12px;">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                                <option value="{{ $status }}"
                                    style="background:#121212;"
                                    {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            style="width:100%;padding:12px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                            {{ __('Update Status') }}
                        </button>
                    </form>
                </div>
            </div>

             {{-- Update payment-Status --}}
             @if($order->payment_method === 'cash')
             <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;margin-top:20px;">
                 <div style="padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
                     {{ __('Update Payment Status') }}
                 </div>
                 <div style="padding:20px 24px;">
                     <form method="POST" action="{{ route('admin.order.updatePaymentStatus', $order->id) }}">
                         @csrf
                         @method('PATCH')
                         <select name="payment_status"
                             style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;margin-bottom:12px;">
                             @foreach(['pending','paid','failed','refunded'] as $ps)
                                 <option value="{{ $ps }}" style="background:#121212;"
                                     {{ $order->payment_status === $ps ? 'selected' : '' }}>
                                     {{ ucfirst($ps) }}
                                 </option>
                             @endforeach
                         </select>
                         <button type="submit"
                             style="width:100%;padding:12px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                             {{ __('Update Payment Status') }}
                         </button>
                     </form>
                 </div>
             </div>
         @endif


        </div>
    </div>
</div>
@endsection