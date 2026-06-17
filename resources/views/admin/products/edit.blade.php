@extends('layouts.admin.app')

@section('title', __('Edit Product'))
@section('page-title', __('Products'))
@section('breadcrumb', __('Products') . ' → ' . __('Edit'))

@section('content')
    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-title-wrap {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .page-title {
            font-family: 'Georgia', serif;
            font-size: 22px;
            color: var(--text-primary);
            font-weight: 400;
        }

        .page-sub {
            font-size: 12px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .gold-rule {
            width: 32px;
            height: 1px;
            background: var(--gold);
            opacity: 0.5;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
        }

        .btn-back svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        .form-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card:last-child {
            margin-bottom: 0;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-icon {
            width: 32px;
            height: 32px;
            background: rgba(200, 169, 106, 0.08);
            border: 1px solid var(--border);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
        }

        .card-header-icon svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            fill: none;
        }

        .card-title {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
        }

        .edit-badge {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: rgba(200, 169, 106, 0.08);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 11px;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            letter-spacing: 1px;
        }

        .edit-badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--gold);
        }

        .card-body {
            padding: 24px;
        }

        .field {
            margin-bottom: 20px;
        }

        .field:last-child {
            margin-bottom: 0;
        }

        .field label {
            display: block;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            margin-bottom: 8px;
        }

        .field label span {
            color: var(--gold);
            margin-left: 3px;
        }

        .field input,
        .field textarea,
        .field select {
            width: 100%;
            background: #0f0f0f;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 11px 14px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: Arial, sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field input::placeholder,
        .field textarea::placeholder {
            color: var(--text-muted);
        }

        .field input:focus,
        .field textarea:focus,
        .field select:focus {
            border-color: var(--gold-dim);
            box-shadow: 0 0 0 3px rgba(200, 169, 106, 0.06);
        }

        .field input.is-error,
        .field textarea.is-error,
        .field select.is-error {
            border-color: var(--danger);
        }

        .field textarea {
            resize: vertical;
            min-height: 90px;
            line-height: 1.6;
        }

        .field select {
            appearance: none;
            cursor: pointer;
            background-image: url("data:images/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%235a5040' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        .field select option {
            background: #111;
            color: var(--text-primary);
        }

        .field-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 6px;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        .field-error {
            font-size: 11px;
            color: var(--danger);
            margin-top: 6px;
            font-family: Arial, sans-serif;
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .slug-row {
            display: flex;
            gap: 8px;
        }

        .slug-prefix {
            padding: 11px 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 12px;
            color: var(--text-muted);
            font-family: 'Courier New', monospace;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .slug-row input {
            flex: 1;
        }

        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(200, 169, 106, 0.06);
        }

        .toggle-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .toggle-label {
            font-size: 13px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
        }

        .toggle-desc {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
            font-family: Arial, sans-serif;
        }

        .toggle {
            position: relative;
            width: 40px;
            height: 22px;
            flex-shrink: 0;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border);
            border-radius: 22px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 14px;
            height: 14px;
            background: var(--text-muted);
            border-radius: 50%;
            top: 3px;
            left: 3px;
            transition: all 0.2s;
        }

        .toggle input:checked+.toggle-slider {
            background: rgba(200, 169, 106, 0.15);
            border-color: var(--gold-dim);
        }

        .toggle input:checked+.toggle-slider::before {
            background: var(--gold);
            transform: translateX(18px);
        }

        .upload-area {
            border: 1px dashed var(--border);
            border-radius: 8px;
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            background: #0f0f0f;
        }

        .upload-area:hover {
            border-color: var(--gold-dim);
            background: rgba(200, 169, 106, 0.02);
        }

        .upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon {
            width: 38px;
            height: 38px;
            background: rgba(200, 169, 106, 0.08);
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: var(--gold);
        }

        .upload-icon svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            fill: none;
        }

        .upload-title {
            font-size: 13px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            margin-bottom: 4px;
        }

        .upload-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .current-images-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 14px;
        }

        .current-image-item {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid var(--border);
            aspect-ratio: 1;
        }

        .current-image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .current-image-label {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            padding: 3px 6px;
            font-size: 9px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--gold);
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 12px;
        }

        .preview-item {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid var(--border);
            aspect-ratio: 1;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .preview-remove {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 20px;
            height: 20px;
            background: rgba(0, 0, 0, 0.75);
            border: 1px solid var(--border);
            border-radius: 4px;
            color: var(--danger);
            cursor: pointer;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .meta-info {
            background: rgba(200, 169, 106, 0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px 16px;
        }

        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(200, 169, 106, 0.06);
        }

        .meta-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .meta-key {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .meta-val {
            font-size: 12px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
        }

        .meta-val.gold {
            color: var(--gold);
        }

        .form-footer {
            padding: 18px 24px;
            border-top: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.01);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .footer-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-submit {
            padding: 10px 28px;
            background: var(--gold);
            border: none;
            border-radius: 6px;
            color: #0a0a0a;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--gold-light);
        }

        .btn-submit svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        .btn-cancel {
            font-size: 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-family: Arial, sans-serif;
            transition: color 0.2s;
        }

        .btn-cancel:hover {
            color: var(--danger);
        }

        .price-prefix-row {
            display: flex;
            gap: 8px;
        }

        .price-prefix {
            padding: 11px 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 12px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
        }

        .price-prefix-row input {
            flex: 1;
        }

        @media (max-width: 900px) {
            .form-layout {
                grid-template-columns: 1fr;
            }

            .row-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    {{-- Page header --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <div class="page-title">{{ __('Edit Product') }}</div>
            <div class="gold-rule"></div>
            <div class="page-sub">{{ __('Update product details') }}</div>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            {{ __('Back to Products') }}
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>@endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-layout">

            {{-- LEFT --}}
            <div>

                {{-- Basic info --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Basic Information') }}</span>
                        <span class="edit-badge"><span class="edit-badge-dot"></span>{{ __('Editing') }}</span>
                    </div>
                    <div class="card-body">

                        <div class="field">
                            <label for="name_en">{{ __('Product Name / En') }} <span>*</span></label>
                            <input id="name_en" type="text" name="name[en]"
                                value="{{ old('name.en', $product->getTranslation('name', 'en')) }}"
                                class="{{ $errors->has('name.en') ? 'is-error' : '' }}" required>
                            @error('name.en') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="name_ar">{{ __('Product Name / Ar') }} <span>*</span></label>
                            <input id="name_ar" type="text" name="name[ar]"
                                value="{{ old('name.ar', $product->getTranslation('name', 'ar')) }}"
                                class="{{ $errors->has('name.ar') ? 'is-error' : '' }}" required>
                            @error('name.ar') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="slug">{{ __('Slug') }}</label>
                            <div class="slug-row">
                                <span class="slug-prefix">/products/</span>
                                <input id="slug" type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                                    class="{{ $errors->has('slug') ? 'is-error' : '' }}">
                            </div>
                            @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="short_description_en">{{ __('Short Description / En') }}</label>
                            <input id="short_description_en" type="text" name="short_description[en]"
                                value="{{ old('short_description.en', $product->getTranslation('short_description', 'en')) }}">
                            @error('short_description.en') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="short_description_ar">{{ __('Short Description / Ar') }}</label>
                            <input id="short_description_ar" type="text" name="short_description[ar]"
                                value="{{ old('short_description.ar', $product->getTranslation('short_description', 'ar')) }}">
                            @error('short_description.ar') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="description_en">{{ __('Description / En') }}</label>
                            <textarea id="description_en"
                                name="description[en]">{{ old('description.en', $product->getTranslation('description', 'en')) }}</textarea>
                            @error('description.en') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="description_ar">{{ __('Description / Ar') }}</label>
                            <textarea id="description_ar"
                                name="description[ar]">{{ old('description.ar', $product->getTranslation('description', 'ar')) }}</textarea>
                            @error('description.ar') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="row-2">
                            <div class="field">
                                <label for="category_id">{{ __('Category') }} <span>*</span></label>
                                <select id="category_id" name="category_id" required>
                                    <option value="">— {{ __('Select category') }} —</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->getTranslation('name', app()->getLocale()) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <label for="brand_id">{{ __('Brand') }} <span>*</span></label>
                                <select id="brand_id" name="brand_id" required>
                                    <option value="">— {{ __('Select brand') }} —</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->getTranslation('name', app()->getLocale()) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Pricing & stock --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Pricing & Stock') }}</span>
                    </div>
                    <div class="card-body">

                        <div class="row-2">
                            <div class="field">
                                <label for="price">{{ __('Price') }} <span>*</span></label>
                                <div class="price-prefix-row">
                                    <span class="price-prefix">EGP</span>
                                    <input id="price" type="number" step="0.01" min="0" name="price"
                                        value="{{ old('price', $product->price) }}"
                                        class="{{ $errors->has('price') ? 'is-error' : '' }}" required>
                                </div>
                                @error('price') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <label for="sale_price">{{ __('Sale Price') }}</label>
                                <div class="price-prefix-row">
                                    <span class="price-prefix">EGP</span>
                                    <input id="sale_price" type="number" step="0.01" min="0" name="sale_price"
                                        value="{{ old('sale_price', $product->sale_price) }}"
                                        placeholder="{{ __('optional') }}">
                                </div>
                                @error('sale_price') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row-2">
                            <div class="field">
                                <label for="sku">{{ __('SKU') }} <span>*</span></label>
                                <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                    class="{{ $errors->has('sku') ? 'is-error' : '' }}" required>
                                @error('sku') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <label for="gender">{{ __('Gender') }}</label>
                                <select id="gender" name="gender">
                                    <option value="Men" {{ old('gender', $product->gender) == 'Men' ? 'selected' : '' }}>
                                        {{ __('Men') }}</option>
                                    <option value="Women" {{ old('gender', $product->gender) == 'Women' ? 'selected' : '' }}>
                                        {{ __('Women') }}</option>
                                    <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>
                                        {{ __('Unisex') }}</option>
                                    <option value="Kids" {{ old('gender', $product->gender) == 'Kids' ? 'selected' : '' }}>
                                        {{ __('Kids') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row-2">
                            <div class="field">
                                <label for="stock_quantity">{{ __('Stock Quantity') }} <span>*</span></label>
                                <input id="stock_quantity" type="number" min="0" name="stock_quantity"
                                    value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                    class="{{ $errors->has('stock_quantity') ? 'is-error' : '' }}" required>
                                @error('stock_quantity') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <label for="low_stock_threshold">{{ __('Low Stock Threshold') }}</label>
                                <input id="low_stock_threshold" type="number" min="0" name="low_stock_threshold"
                                    value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}">
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div>

                {{-- Images --}}
<div class="card">
    <div class="card-header">
        <div class="card-header-icon">
            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
            </svg>
        </div>
        <span class="card-title">{{ __('Product Image') }}</span>
    </div>
    <div class="card-body">

        {{-- Current image --}}
        @if($product->images)
            <div class="current-image-item" style="margin-bottom:14px;">
                <img src="{{ asset('storage/' . $product->images) }}"
                     alt="product image"
                     style="width:100%;border-radius:6px;border:1px solid var(--border);object-fit:cover;">
                <div class="current-image-label">{{ __('Current') }}</div>
            </div>
        @endif

        {{-- Upload new image --}}
        <div class="upload-area" id="uploadArea">
            <input type="file" name="images" accept="image/*" id="imageInput">
            <div class="upload-icon">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="16 16 12 12 8 16"/>
                    <line x1="12" y1="12" x2="12" y2="21"/>
                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                </svg>
            </div>
            <div class="upload-title">
                {{ $product->images ? __('Click to replace image') : __('Click or drag image here') }}
            </div>
            <div class="upload-sub">PNG, JPG, WEBP — {{ __('max') }} 2MB</div>
        </div>

        {{-- New image preview --}}
        <div id="previewGrid"></div>

        @error('image')
            <div class="field-error" style="margin-top:8px">{{ $message }}</div>
        @enderror

    </div>
</div>
                {{-- Flags --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Visibility & Flags') }}</span>
                    </div>
                    <div class="card-body">

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">{{ __('Active') }}</div>
                                <div class="toggle-desc">{{ __('Show this product on the store') }}</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">{{ __('Featured') }}</div>
                                <div class="toggle-desc">{{ __('Highlight on homepage') }}</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">{{ __('Bestseller') }}</div>
                                <div class="toggle-desc">{{ __('Mark as bestselling item') }}</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">{{ __('Out of Stock') }}</div>
                                <div class="toggle-desc">{{ __('Manually mark as unavailable') }}</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="is_out_of_stock" value="1" {{ old('is_out_of_stock', $product->is_out_of_stock) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>




                        </div>

                    </div>
                </div>

                {{-- Meta --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Meta') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="meta-info">
                            <div class="meta-row">
                                <span class="meta-key">{{ __('ID') }}</span>
                                <span class="meta-val gold">#{{ $product->id }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-key">{{ __('Created') }}</span>
                                <span class="meta-val">{{ $product->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-key">{{ __('Updated') }}</span>
                                <span class="meta-val">{{ $product->updated_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Footer --}}
        <div class="card" style="margin-top:20px;">
            <div class="form-footer">
                <div class="footer-left">
                    <button type="submit" class="btn-submit">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        {{ __('Save Changes') }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn-cancel">{{ __('Cancel') }}</a>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('scripts')
<script>
    // Auto slug from name
    document.getElementById('name_en').addEventListener('input', function () {
        const slugInput = document.getElementById('slug');
        if (slugInput.dataset.manual) return;
        const slug = this.value.toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        slugInput.placeholder = slug || '{{ __("auto-generated") }}';
    });

    document.getElementById('slug').addEventListener('input', function () {
        this.dataset.manual = this.value ? '1' : '';
    });

    // Single image preview
    document.getElementById('imageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewGrid').innerHTML = `
                <div class="preview-item" style="margin-top:12px;">
                    <img src="${e.target.result}"
                         style="width:100%;border-radius:6px;border:1px solid var(--border);object-fit:cover;">
                </div>`;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush