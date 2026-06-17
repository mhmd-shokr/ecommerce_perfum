@extends('layouts.admin.app')

@section('title', __('Edit Brand'))
@section('page-title', __('Brands'))
@section('breadcrumb', __('Brands') . ' → ' . __('Edit'))

@section('content')
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
    .page-title-wrap { display: flex; flex-direction: column; gap: 6px; }
    .page-title { font-family: 'Georgia', serif; font-size: 22px; color: var(--text-primary); font-weight: 400; }
    .page-sub { font-size: 12px; color: var(--text-muted); font-family: Arial, sans-serif; }
    .gold-rule { width: 32px; height: 1px; background: var(--gold); opacity: 0.5; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 9px 18px; background: transparent;
        border: 1px solid var(--border); border-radius: 6px;
        color: var(--text-secondary); font-family: Arial, sans-serif;
        font-size: 12px; letter-spacing: 0.5px; text-decoration: none; transition: all 0.2s;
    }
    .btn-back:hover { border-color: var(--gold-dim); color: var(--gold); }
    .btn-back svg { width: 14px; height: 14px; stroke: currentColor; fill: none; }

    .form-layout { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }

    .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .card-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; }
    .card-header-icon { width: 32px; height: 32px; background: rgba(200,169,106,0.08); border: 1px solid var(--border); border-radius: 7px; display: flex; align-items: center; justify-content: center; color: var(--gold); }
    .card-header-icon svg { width: 15px; height: 15px; stroke: currentColor; fill: none; }
    .card-title { font-size: 12px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-primary); font-family: Arial, sans-serif; }

    .edit-badge {
        margin-left: auto;
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px;
        background: rgba(200,169,106,0.08);
        border: 1px solid var(--border);
        border-radius: 20px;
        font-size: 11px; color: var(--gold-dim);
        font-family: Arial, sans-serif; letter-spacing: 1px;
    }
    .edit-badge-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--gold); }

    .card-body { padding: 24px; }

    .field { margin-bottom: 20px; }
    .field:last-child { margin-bottom: 0; }
    .field label { display: block; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); font-family: Arial, sans-serif; margin-bottom: 8px; }
    .field label span { color: var(--gold); margin-left: 3px; }

    .field input,
    .field textarea {
        width: 100%; background: #0f0f0f; border: 1px solid var(--border);
        border-radius: 6px; padding: 11px 14px;
        color: var(--text-primary); font-size: 13px; font-family: Arial, sans-serif;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .field input::placeholder, .field textarea::placeholder { color: var(--text-muted); }
    .field input:focus, .field textarea:focus { border-color: var(--gold-dim); box-shadow: 0 0 0 3px rgba(200,169,106,0.06); }
    .field input.is-error { border-color: var(--danger); }

    .field-hint { font-size: 11px; color: var(--text-muted); margin-top: 6px; font-family: Arial, sans-serif; line-height: 1.5; }
    .field-error { font-size: 11px; color: var(--danger); margin-top: 6px; font-family: Arial, sans-serif; }

    .slug-row { display: flex; gap: 8px; }
    .slug-prefix { padding: 11px 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 6px; font-size: 12px; color: var(--text-muted); font-family: 'Courier New', monospace; white-space: nowrap; display: flex; align-items: center; }
    .slug-row input { flex: 1; }

    .upload-area { border: 1px dashed var(--border); border-radius: 8px; padding: 32px 20px; text-align: center; cursor: pointer; transition: all 0.2s; position: relative; background: #0f0f0f; }
    .upload-area:hover { border-color: var(--gold-dim); background: rgba(200,169,106,0.02); }
    .upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .upload-icon { width: 40px; height: 40px; background: rgba(200,169,106,0.08); border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: var(--gold); }
    .upload-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; }
    .upload-title { font-size: 13px; color: var(--text-secondary); font-family: Arial, sans-serif; margin-bottom: 4px; }
    .upload-sub { font-size: 11px; color: var(--text-muted); font-family: Arial, sans-serif; }

    .meta-info { background: rgba(200,169,106,0.04); border: 1px solid var(--border); border-radius: 8px; padding: 14px 16px; }
    .meta-row { display: flex; align-items: center; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid rgba(200,169,106,0.06); }
    .meta-row:last-child { border-bottom: none; padding-bottom: 0; }
    .meta-key { font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-muted); font-family: Arial, sans-serif; }
    .meta-val { font-size: 12px; color: var(--text-secondary); font-family: Arial, sans-serif; }
    .meta-val.gold { color: var(--gold); }

    .form-footer { padding: 18px 24px; border-top: 1px solid var(--border); background: rgba(255,255,255,0.01); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .footer-left { display: flex; align-items: center; gap: 10px; }

    .btn-submit { padding: 10px 28px; background: var(--gold); border: none; border-radius: 6px; color: #0a0a0a; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-family: Arial, sans-serif; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-submit:hover { background: var(--gold-light); }
    .btn-submit svg { width: 14px; height: 14px; stroke: currentColor; fill: none; }

    .btn-cancel { font-size: 12px; color: var(--text-muted); text-decoration: none; font-family: Arial, sans-serif; transition: color 0.2s; }
    .btn-cancel:hover { color: var(--danger); }
</style>

{{-- Page header --}}
<div class="page-header">
    <div class="page-title-wrap">
        <div class="page-title">{{ __('Edit Brand') }}</div>
        <div class="gold-rule"></div>
        <div class="page-sub">{{ __('Update brand details') }}</div>
    </div>
    <a href="{{ route('admin.brands.index') }}" class="btn-back">
        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        {{ __('Back to Brands') }}
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-layout">

        {{-- Left: main fields --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5"/></svg>
                    </div>
                    <span class="card-title">{{ __('Brand Information') }}</span>
                    <span class="edit-badge"><span class="edit-badge-dot"></span>{{ __('Editing') }}</span>
                </div>
                <div class="card-body">

                    {{-- Name EN --}}
                    <div class="field">
                        <label for="name_en">{{ __('Brand Name / En') }} <span>*</span></label>
                        <input id="name_en" type="text" name="name[en]"
                            value="{{ old('name.en', $brand->getTranslation('name', 'en')) }}"
                            placeholder="{{ __('e.g. Chanel, Dior, Gucci...') }}"
                            class="{{ $errors->has('name.en') ? 'is-error' : '' }}" required>
                        @error('name.en') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Name AR --}}
                    <div class="field">
                        <label for="name_ar">{{ __('Brand Name / Ar') }} <span>*</span></label>
                        <input id="name_ar" type="text" name="name[ar]"
                            value="{{ old('name.ar', $brand->getTranslation('name', 'ar')) }}"
                            placeholder="{{ __('اسم البراند') }}"
                            class="{{ $errors->has('name.ar') ? 'is-error' : '' }}" required>
                        @error('name.ar') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="field">
                        <label for="slug">{{ __('Slug') }}</label>
                        <div class="slug-row">
                            <span class="slug-prefix">/brands/</span>
                            <input id="slug" type="text" name="slug" value="{{ old('slug', $brand->slug) }}"
                                placeholder="{{ __('auto-generated') }}"
                                class="{{ $errors->has('slug') ? 'is-error' : '' }}">
                        </div>
                        <div class="field-hint">{{ __('Leave empty to auto-generate from name') }}</div>
                        @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Right: logo + meta --}}
        <div>
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <span class="card-title">{{ __('Brand Logo') }}</span>
                </div>
                <div class="card-body">

                    {{-- Current logo --}}
                    @if($brand->logo)
                        <div id="currentImageWrap"
                            style="display:flex; align-items:center; gap:12px; padding:12px; background:rgba(200,169,106,0.04); border:1px solid var(--border); border-radius:8px; margin-bottom:14px;">
                            <img src="{{ asset('storage/' . $brand->logo) }}"
                                style="width:56px; height:56px; object-fit:cover; border-radius:6px; border:1px solid var(--border);">
                            <div style="flex:1;">
                                <div style="font-size:11px; color:var(--gold); letter-spacing:1px; text-transform:uppercase; font-family:Arial,sans-serif; margin-bottom:3px;">
                                    {{ __('Current Logo') }}
                                </div>
                                <div style="font-size:11px; color:var(--text-muted); font-family:Arial,sans-serif;">
                                    {{ basename($brand->logo) }}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Upload --}}
                    <div class="upload-area" id="uploadArea">
                        <input type="file" name="logo" accept="image/*" id="imageInput">
                        <div class="upload-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                        </div>
                        <div class="upload-title">
                            {{ $brand->logo ? __('Click to replace logo') : __('Click or drag logo here') }}
                        </div>
                        <div class="upload-sub">PNG, JPG, WEBP — {{ __('max') }} 2MB</div>
                    </div>

                    {{-- Preview --}}
                    <div id="imagePreview" style="display:none; margin-top:12px; position:relative;">
                        <img id="previewImg" style="width:100%; border-radius:6px; border:1px solid var(--border); display:block; max-height:200px; object-fit:cover;">
                        <button type="button" id="removeImg"
                            style="position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.75); border:1px solid var(--border); border-radius:4px; color:var(--danger); padding:4px 10px; font-size:11px; cursor:pointer; font-family:Arial,sans-serif;">
                            ✕ {{ __('Remove') }}
                        </button>
                    </div>

                    @error('logo') <div class="field-error" style="margin-top:8px">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Meta info --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <span class="card-title">{{ __('Meta') }}</span>
                </div>
                <div class="card-body">
                    <div class="meta-info">
                        <div class="meta-row">
                            <span class="meta-key">{{ __('Products') }}</span>
                            <span class="meta-val">{{ $brand->products()->count() }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-key">{{ __('Created') }}</span>
                            <span class="meta-val">{{ $brand->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-key">{{ __('Updated') }}</span>
                            <span class="meta-val">{{ $brand->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Form footer --}}
    <div class="card" style="margin-top:20px;">
        <div class="form-footer">
            <div class="footer-left">
                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ __('Save Changes') }}
                </button>
                <a href="{{ route('admin.brands.index') }}" class="btn-cancel">{{ __('Cancel') }}</a>
            </div>
        </div>
    </div>

</form>

@endsection

@push('scripts')
<script>
    // Auto-generate slug from English name
    document.getElementById('name_en').addEventListener('input', function () {
        const slugInput = document.getElementById('slug');
        if (slugInput.dataset.manual) return;
        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        slugInput.placeholder = slug || '{{ __("auto-generated") }}';
    });
    document.getElementById('slug').addEventListener('input', function () {
        this.dataset.manual = this.value ? '1' : '';
    });

    // Logo preview
    const imageInput       = document.getElementById('imageInput');
    const imagePreview     = document.getElementById('imagePreview');
    const previewImg        = document.getElementById('previewImg');
    const removeImg          = document.getElementById('removeImg');
    const uploadArea          = document.getElementById('uploadArea');
    const currentImageWrap = document.getElementById('currentImageWrap');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            imagePreview.style.display = 'block';
            uploadArea.style.display = 'none';
            if (currentImageWrap) currentImageWrap.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    removeImg.addEventListener('click', function () {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        uploadArea.style.display = 'block';
        if (currentImageWrap) currentImageWrap.style.display = 'flex';
    });
</script>
@endpush