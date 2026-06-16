@extends('layouts.admin.app')

@section('title', __('Edit Category'))
@section('page-title', __('Categories'))
@section('breadcrumb', __('Categories') . ' → ' . __('Edit'))

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
            letter-spacing: 0.5px;
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
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .edit-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: rgba(200, 169, 106, 0.08);
            border: 1px solid rgba(200, 169, 106, 0.18);
            border-radius: 20px;
            font-size: 11px;
            color: var(--gold-dim);
            letter-spacing: 1px;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
        }

        .edit-badge svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
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
            margin-bottom: 16px;
        }

        .card:last-child {
            margin-bottom: 0;
        }

        .card-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-icon {
            width: 30px;
            height: 30px;
            background: rgba(200, 169, 106, 0.08);
            border: 1px solid var(--border);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
        }

        .card-header-icon svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .card-title {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
        }

        .card-body {
            padding: 22px;
        }

        .field {
            margin-bottom: 18px;
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
            margin-bottom: 7px;
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
            padding: 10px 13px;
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
            min-height: 100px;
            line-height: 1.6;
        }

        .field select {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%235a5040' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
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

        .slug-row {
            display: flex;
            gap: 8px;
        }

        .slug-prefix {
            padding: 10px 12px;
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

        .current-image-wrap {
            position: relative;
            margin-bottom: 10px;
        }

        .current-image-wrap img {
            width: 100%;
            border-radius: 7px;
            border: 1px solid var(--border);
            display: block;
            object-fit: cover;
            max-height: 180px;
        }

        .current-image-label {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(0, 0, 0, 0.75);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 3px 8px;
            font-size: 10px;
            color: var(--text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
        }

        .btn-change-img {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: none;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-muted);
            font-size: 11px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: all 0.15s;
            width: 100%;
            justify-content: center;
            margin-top: 8px;
        }

        .btn-change-img:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
        }

        .btn-change-img svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .upload-area {
            border: 1px dashed var(--border);
            border-radius: 8px;
            padding: 24px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #0f0f0f;
            position: relative;
            margin-top: 10px;
        }

        .upload-area:hover {
            border-color: var(--gold-dim);
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
            width: 36px;
            height: 36px;
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
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .upload-title {
            font-size: 12px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            margin-bottom: 3px;
        }

        .upload-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .meta-info {
            background: rgba(200, 169, 106, 0.04);
            border: 1px solid rgba(200, 169, 106, 0.1);
            border-radius: 8px;
            padding: 12px 14px;
        }

        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .meta-row:last-child {
            border-bottom: none;
        }

        .meta-key {
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            font-family: Arial, sans-serif;
        }

        .meta-val {
            font-size: 12px;
            color: var(--text-secondary);
            font-family: monospace;
        }

        .meta-val.success {
            color: var(--success);
        }

        .form-footer {
            padding: 16px 22px;
            border-top: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.15);
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
            padding: 10px 24px;
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
            transition: opacity 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-submit:hover {
            opacity: 0.85;
        }

        .btn-submit svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .btn-ghost {
            padding: 10px 18px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-muted);
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }

        .btn-ghost:hover {
            border-color: var(--border-strong);
            color: var(--text-secondary);
        }

        .btn-danger-link {
            font-size: 12px;
            color: var(--danger);
            opacity: 0.6;
            background: none;
            border: none;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: opacity 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-danger-link:hover {
            opacity: 1;
        }

        .btn-danger-link svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>

    {{-- Page header --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <div class="page-title">{{ __('Edit Category') }}</div>
            <div class="gold-rule"></div>
            <div class="page-sub">{{ __('Update category details and settings') }}</div>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            {{ __('Back to Categories') }}
        </a>
    </div>

    <div class="edit-badge">
        <svg viewBox="0 0 24 24">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
        {{ __('Editing') }}: {{ $category->getTranslation('name', 'en') }} &nbsp;·&nbsp; ID #{{ $category->id }}
    </div>


    <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-layout">

            {{-- Left: main fields --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Basic Information') }}</span>
                    </div>

                    <div class="card-body">

                        {{-- Name EN --}}
                        <div class="field">
                            <label for="name_en">{{ __('Category Name / EN') }} <span>*</span></label>
                            <input id="name_en" type="text" name="name[en]"
                                value="{{ old('name.en', $category->getTranslation('name', 'en')) }}"
                                placeholder="{{ __('e.g. Men\'s Watches') }}"
                                class="{{ $errors->has('name.en') ? 'is-error' : '' }}" oninput="syncSlug(this.value)"
                                required>
                            @error('name.en') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        {{-- Name AR --}}
                        <div class="field">
                            <label for="name_ar">{{ __('Category Name / AR') }} <span>*</span></label>
                            <input id="name_ar" type="text" name="name[ar]"
                                value="{{ old('name.ar', $category->getTranslation('name', 'ar')) }}"
                                placeholder="{{ __('اسم الفئة') }}" dir="rtl"
                                class="{{ $errors->has('name.ar') ? 'is-error' : '' }}" required>
                            @error('name.ar') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="field">
                            <label for="slug">{{ __('Slug') }}</label>
                            <div class="slug-row">
                                <span class="slug-prefix">/categories/</span>
                                <input id="slug" type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                                    placeholder="{{ __('auto-generated') }}"
                                    class="{{ $errors->has('slug') ? 'is-error' : '' }}" oninput="slugEdited=true">
                            </div>
                            <div class="field-hint">{{ __('Editing the slug may break existing links. Change with care.') }}
                            </div>
                            @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="field">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" name="description"
                                placeholder="{{ __('Describe this category...') }}"
                                class="{{ $errors->has('description') ? 'is-error' : '' }}">{{ old('description', $category->description ?? '') }}</textarea>
                            @error('description') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        {{-- Parent Category --}}
                        <div class="field">
                            <label for="parent_id">{{ __('Parent Category') }}</label>
                            <select id="parent_id" name="parent_id">
                                <option value="">— {{ __('No parent (top level)') }} —</option>
                                @foreach ($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->getTranslation('name', app()->getLocale()) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="field-hint">{{ __('Optional — nest this under another category.') }}</div>
                            @error('parent_id') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                    </div>

                    <div class="form-footer">
                        <div class="footer-left">
                            <button type="submit" class="btn-submit">
                                <svg viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                {{ __('Save Changes') }}
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn-ghost">{{ __('Cancel') }}</a>
                        </div>

                        <button type="button" class="btn-danger-link"
                            onclick="document.getElementById('delete-form').submit()">
                            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
                                <path d="M9 6V4h6v2" />
                            </svg>
                            {{ __('Delete Category') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Right: sidebar --}}
            <div>

                {{-- Image --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Category Image') }}</span>
                    </div>

                    <div class="card-body">
                        {{-- Current image --}}
                        @if($category->images)
                            <div id="currentImageWrap"
                                style="display:flex; align-items:center; gap:12px; padding:12px; background:rgba(200,169,106,0.04); border:1px solid var(--border); border-radius:8px; margin-bottom:14px;">
                                <img src="{{ asset('storage/' . $category->images) }}"
                                    style="width:56px; height:56px; object-fit:cover; border-radius:6px; border:1px solid var(--border);">
                                <div style="flex:1;">
                                    <div
                                        style="font-size:11px; color:var(--gold); letter-spacing:1px; text-transform:uppercase; font-family:Arial,sans-serif; margin-bottom:3px;">
                                        {{ __('Current Image') }}
                                    </div>
                                    <div style="font-size:11px; color:var(--text-muted); font-family:Arial,sans-serif;">
                                        {{ basename($category->images) }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Upload image --}}
                        <div class="upload-area" id="uploadArea">
                            <input type="file" name="images" accept="image/*" id="imageInput">
                            {{-- ↑ غيرنا images → image --}}
                            <div class="upload-icon">
                                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="16 16 12 12 8 16" />
                                    <line x1="12" y1="12" x2="12" y2="21" />
                                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3" />
                                </svg>
                            </div>
                            <div class="upload-title">
                                {{ $category->images ? __('Click to replace image') : __('Click or drag image here') }}
                            </div>
                            <div class="upload-sub">PNG, JPG, WEBP — {{ __('max') }} 2MB</div>
                        </div>

                        {{-- New image preview --}}
                        <div id="imagePreview" style="display:none; margin-top:12px;">
                            <div style="position:relative;">
                                <img id="previewImg" style="width:100%; border-radius:6px; border:1px solid var(--border); display:block; max-height:200px; object-fit:cover;">
                                <button type="button" id="removeImg"
                                    style="position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.75); border:1px solid var(--border); border-radius:4px; color:var(--danger); padding:4px 10px; font-size:11px; cursor:pointer; font-family:Arial,sans-serif; display:flex; align-items:center; gap:4px;">
                                    ✕ {{ __('Remove') }}
                                </button>
                                <span style="position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,0.7); border:1px solid var(--border); border-radius:4px; padding:3px 8px; font-size:10px; color:var(--gold); font-family:Arial,sans-serif; letter-spacing:1px; text-transform:uppercase;">
                                    {{ __('New') }}
                                </span>
                            </div>
                        </div>

                        @error('images') <div class="field-error" style="margin-top:8px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Visibility --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                                <path d="M19.07 4.93a10 10 0 0 1 0 14.14" />
                                <path d="M4.93 4.93a10 10 0 0 0 0 14.14" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Visibility') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">{{ __('Active') }}</div>
                                <div class="toggle-desc">{{ __('Show this category on the store') }}</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Record Info --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Record Info') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="meta-info">
                            <div class="meta-row">
                                <span class="meta-key">ID</span>
                                <span class="meta-val">#{{ $category->id }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-key">{{ __('Status') }}</span>
                                <span class="meta-val {{ $category->status ? 'success' : '' }}">
                                    {{ $category->status ? __('Active') : __('Inactive') }}
                                </span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-key">{{ __('Created') }}</span>
                                <span class="meta-val">{{ $category->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-key">{{ __('Updated') }}</span>
                                <span class="meta-val">{{ $category->updated_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- Separate delete form --}}
    <form id="delete-form" method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        document.getElementById('imageInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
        
            const reader = new FileReader();
        
            reader.onload = function (e) {
                // hide current image
                const current = document.getElementById('currentImageWrap');
                if (current) current.style.display = 'none';
        
                // show preview container
                const previewBox = document.getElementById('imagePreview');
                previewBox.style.display = 'block';
        
                // set image
                document.getElementById('previewImg').src = e.target.result;
            };
        
            reader.readAsDataURL(file);
        });
        
        // remove image preview
        document.getElementById('removeImg').addEventListener('click', function () {
            document.getElementById('imageInput').value = '';
        
            document.getElementById('imagePreview').style.display = 'none';
        
            const current = document.getElementById('currentImageWrap');
            if (current) current.style.display = 'flex';
        });
        </script>

@endsection