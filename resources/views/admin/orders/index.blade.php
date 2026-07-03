@extends('layouts.admin.app')
@section('title', __('Orders'))

@section('content')
<div style="padding: 32px;">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
        <div>
            <h1 style="font-size:22px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;margin-bottom:4px;">
                {{ __('Orders Management') }}
            </h1>
            <p style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;">
                {{ $ordersCount }} {{ __('total orders') }}
            </p>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div style="background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:#7ab87a;font-family:Arial,sans-serif;margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">

        {{-- Table Header --}}
        <div style="display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr 1fr 100px;gap:16px;padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
            <span>{{ __('Order') }}</span>
            <span>{{ __('Customer') }}</span>
            <span>{{ __('Total') }}</span>
            <span>{{ __('Status') }}</span>
            <span>{{ __('Payment') }}</span>
            <span></span>
        </div>

        @forelse($orders as $order)
            <div style="display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr 1fr 100px;gap:16px;align-items:center;padding:16px 24px;border-bottom:1px solid rgba(200,169,106,0.08);transition:background 0.15s;"
                 onmouseover="this.style.background='rgba(200,169,106,0.02)'"
                 onmouseout="this.style.background='transparent'">

                {{-- Order --}}
                <div>
                    <div style="font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;">
                        {{ $order->order_number }}
                    </div>
                    <div style="font-size:11px;color:#5a5040;font-family:Arial,sans-serif;margin-top:2px;">
                        {{ $order->created_at->format('d M Y') }}
                    </div>
                </div>

                {{-- Customer --}}
                <div style="font-size:13px;color:#9a8870;font-family:Arial,sans-serif;">
                    {{ $order->user?->name ?? __('Deleted') }}
                </div>

                {{-- Total --}}
                <div style="font-size:14px;color:#C8A96A;font-family:Arial,sans-serif;">
                    ${{ number_format($order->total, 2) }}
                </div>

                {{-- Status --}}
                <div>
                    @php
                        $statusColors = [
                            'pending'    => 'rgba(200,169,106,0.1);color:#8a7248',
                            'processing' => 'rgba(100,150,255,0.1);color:#6496ff',
                            'shipped'    => 'rgba(100,200,255,0.1);color:#64c8ff',
                            'delivered'  => 'rgba(122,184,122,0.1);color:#7ab87a',
                            'cancelled'  => 'rgba(196,80,64,0.1);color:#c45040',
                        ];
                        $sc = $statusColors[$order->status] ?? 'rgba(200,169,106,0.1);color:#8a7248';
                    @endphp
                    <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-family:Arial,sans-serif;letter-spacing:1px;text-transform:uppercase;font-weight:600;background:{{ $sc }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                {{-- Payment --}}
                <div>
                    @php
                        $payColors = [
                            'pending'  => 'rgba(200,169,106,0.08);color:#5a5040',
                            'paid'     => 'rgba(122,184,122,0.1);color:#7ab87a',
                            'failed'   => 'rgba(196,80,64,0.1);color:#c45040',
                            'refunded' => 'rgba(150,100,200,0.1);color:#9664c8',
                        ];
                        $pc = $payColors[$order->payment_status] ?? 'rgba(200,169,106,0.08);color:#5a5040';
                    @endphp
                    <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-family:Arial,sans-serif;letter-spacing:1px;text-transform:uppercase;background:{{ $pc }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>

                {{-- Action --}}
                <div>
                    <a href="{{ route('admin.order.show', $order->id) }}"
                       style="padding:7px 14px;background:transparent;border:1px solid rgba(200,169,106,0.15);border-radius:6px;color:#8a7248;font-size:11px;font-family:Arial,sans-serif;text-decoration:none;transition:all 0.15s;"
                       onmouseover="this.style.borderColor='#8a7248';this.style.color='#C8A96A'"
                       onmouseout="this.style.borderColor='rgba(200,169,106,0.15)';this.style.color='#8a7248'">
                        {{ __('View') }}
                    </a>
                </div>

            </div>
        @empty
            <div style="text-align:center;padding:60px;color:#5a5040;font-family:Arial,sans-serif;font-size:14px;">
                {{ __('No orders yet') }}
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div style="margin-top:24px;">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>
@endsection