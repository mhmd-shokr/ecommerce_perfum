@extends('layouts.admin.app')
@section('title', __('Shipping Zones'))

@section('content')
    <div style="padding:32px;max-width:900px;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
            <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
                {{ __('Shipping Zones') }}
            </h1>
            <a href="{{ route('admin.shipping-zones.create') }}"
                style="padding:10px 20px;background:#C8A96A;border-radius:8px;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;text-decoration:none;">
                + {{ __('Add Zone') }}
            </a>
        </div>

        @if(session('success'))
            <div style="padding:12px 18px;margin-bottom:20px;background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.25);border-left:3px solid #7ab87a;border-radius:8px;color:#f0e6d0;font-size:12px;font-family:Arial,sans-serif;">
                {{ session('success') }}
            </div>
        @endif

        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid rgba(200,169,106,0.15);">
                        <th style="text-align:left;padding:14px 24px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;font-weight:400;">
                            {{ __('Governorate') }}
                        </th>
                        <th style="text-align:left;padding:14px 24px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;font-weight:400;">
                            {{ __('Shipping Cost') }}
                        </th>
                        <th style="text-align:right;padding:14px 24px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;font-weight:400;">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shippingZones as $zone)
                        <tr style="border-bottom:1px solid rgba(200,169,106,0.06);">
                            <td style="padding:14px 24px;font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;">
                                {{ __($zone->governorate) }}
                            </td>
                            <td style="padding:14px 24px;font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;">
                                {{ number_format($zone->cost, 2) }}
                            </td>
                            <td style="padding:14px 24px;text-align:right;">
                                <a href="{{ route('admin.shipping-zones.edit', $zone) }}"
                                    style="font-size:11px;color:#8a7248;font-family:Arial,sans-serif;text-decoration:none;margin-right:16px;">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ route('admin.shipping-zones.destroy', $zone) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('{{ __('Delete this shipping zone?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background:none;border:none;padding:0;font-size:11px;color:#c45040;font-family:Arial,sans-serif;cursor:pointer;">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding:28px;text-align:center;color:#5a5040;font-size:13px;font-family:Arial,sans-serif;">
                                {{ __('No shipping zones yet.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($shippingZones->hasPages())
            <div style="margin-top:20px;">
                {{ $shippingZones->links() }}
            </div>
        @endif

    </div>
@endsection