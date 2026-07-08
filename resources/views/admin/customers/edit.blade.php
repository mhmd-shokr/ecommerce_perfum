@extends('layouts.admin.app')
@section('title', __('Manage Customer'))

@section('content')
    <div style="padding:32px;max-width:700px;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
            <a href="{{ route('admin.customers.index') }}"
                style="padding:8px 16px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:12px;font-family:Arial,sans-serif;text-decoration:none;">
                ← {{ __('Back') }}
            </a>
            <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
                {{ $customer->name }}
            </h1>
            @if($customer->is_active)
                <span style="padding:3px 10px;border-radius:20px;font-size:10px;background:rgba(122,184,122,0.12);color:#7ab87a;font-family:Arial,sans-serif;">{{ __('Active') }}</span>
            @else
                <span style="padding:3px 10px;border-radius:20px;font-size:10px;background:rgba(196,80,64,0.12);color:#c45040;font-family:Arial,sans-serif;">{{ __('Blocked') }}</span>
            @endif
        </div>

        @if(session('success'))
            <div style="padding:12px 18px;margin-bottom:20px;background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.25);border-left:3px solid #7ab87a;border-radius:8px;color:#f0e6d0;font-size:12px;font-family:Arial,sans-serif;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile --}}
        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;padding:28px;margin-bottom:20px;">
            <div style="font-size:13px;text-transform:uppercase;letter-spacing:1px;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:20px;">
                {{ __('Profile') }}
            </div>

            <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">{{ __('Name') }} *</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    @error('name')<p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">{{ __('Email') }} *</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    @error('email')<p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:24px;">
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Phone') }} <span style="color:#5a5040;text-transform:none;letter-spacing:0;">({{ __('optional') }})</span>
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    @error('phone')<p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                    style="padding:12px 28px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                    {{ __('Save Changes') }}
                </button>
            </form>
        </div>

        {{-- Permissions --}}
        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;padding:28px;margin-bottom:20px;">
            <div style="font-size:13px;text-transform:uppercase;letter-spacing:1px;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:6px;">
                {{ __('Direct Permissions') }}
            </div>
            <div style="font-size:11px;color:#5a5040;font-family:Arial,sans-serif;margin-bottom:20px;">
                {{ __('These are granted in addition to whatever the "customer" role already allows.') }}
            </div>

            <form method="POST" action="{{ route('admin.customers.permissions.update', $customer) }}">
                @csrf
                @method('PUT')

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:24px;">
                    @forelse($permissions as $permission)
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;cursor:pointer;">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                @checked($customer->hasDirectPermission($permission->name))
                                style="accent-color:#C8A96A;width:15px;height:15px;">
                            {{ $permission->name }}
                        </label>
                    @empty
                        <p style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;">{{ __('No permissions defined yet.') }}</p>
                    @endforelse
                </div>

                <button type="submit"
                    style="padding:12px 28px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                    {{ __('Update Permissions') }}
                </button>
            </form>
        </div>

        {{-- Block / Unblock --}}
        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;padding:28px;">
            <div style="font-size:13px;text-transform:uppercase;letter-spacing:1px;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:6px;">
                {{ __('Account Status') }}
            </div>
            <div style="font-size:11px;color:#5a5040;font-family:Arial,sans-serif;margin-bottom:16px;">
                {{ $customer->is_active
                    ? __('This customer can currently log in and use the store.')
                    : __('This customer is blocked and cannot log in.') }}
            </div>

            <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST"
                onsubmit="return confirm('{{ $customer->is_active ? __('Block this customer?') : __('Unblock this customer?') }}');">
                @csrf
                @method('PATCH')
                <button type="submit"
                    style="padding:12px 28px;border-radius:8px;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;border:1px solid {{ $customer->is_active ? 'rgba(196,80,64,0.4)' : 'rgba(122,184,122,0.4)' }};background:transparent;color:{{ $customer->is_active ? '#c45040' : '#7ab87a' }};">
                    {{ $customer->is_active ? __('Block Customer') : __('Unblock Customer') }}
                </button>
            </form>
        </div>

    </div>
@endsection