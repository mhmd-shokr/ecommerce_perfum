@extends('layouts.admin.app')

@section('title', __('Create Category'))
@section('page-title', __('Categories'))
@section('breadcrumb', __('Categories') . ' → ' . __('Create'))

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
        }

        /* Layout */
        .form-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        /* Card */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
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

        .card-body {
            padding: 24px;
        }

        /* Fields */
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

        /* Slug row */
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

        /* Status toggle */
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

        /* Image upload */
        .upload-area {
            border: 1px dashed var(--border);
            border-radius: 8px;
            padding: 32px 20px;
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
            width: 40px;
            height: 40px;
            background: rgba(200, 169, 106, 0.08);
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: var(--gold);
        }

        .upload-icon svg {
            width: 18px;
            height: 18px;
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

        /* Order input */
        .order-input-wrap {
            position: relative;
        }

        .order-input-wrap input {
            padding-right: 40px;
        }

        .order-arrows {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            border-left: 1px solid var(--border);
        }

        .order-btn {
            flex: 1;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            transition: color 0.15s;
            font-size: 10px;
        }

        .order-btn:hover {
            color: var(--gold);
        }

        .order-btn:first-child {
            border-bottom: 1px solid var(--border);
        }

        /* Form footer */
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

        .btn-draft {
            padding: 10px 20px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-secondary);
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-draft:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
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
    </style>

    {{-- Page header --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <div class="page-title">{{ __('Create Category') }}</div>
            <div class="gold-rule"></div>
            <div class="page-sub">{{ __('Add a new category to organize your products') }}</div>
        </div>
        <a href="{{ route('admin.categories.index')}}" class="btn-back">
            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            {{ __('Back to Categories') }}
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-layout">

            {{-- Left: main fields --}}
            <div>

                {{-- Basic Info --}}
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Basic Information') }}</span>
                    </div>
                    <div class="card-body">

                        {{-- Name --}}
                        <div class="field">
                            <label for="name">{{ __('Category Name /En') }} <span>*</span></label>
                            <input id="name" type="text" name="name[en]" value="{{ old('name.en') }}"
                                placeholder="{{ __('e.g. Floral, Oud, Woody...') }}"
                                class="{{ $errors->has('name') ? 'is-error' : '' }}" required>
                            @error('name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label for="name">{{ __('Category Name /Ar') }} <span>*</span></label>
                            <input id="name" type="text" name="name[ar]" value="{{ old('name.ar') }}"
                                placeholder="{{ __('e.g. Floral, Oud, Woody...') }}"
                                class="{{ $errors->has('name') ? 'is-error' : '' }}" required>
                            @error('name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="field">
                            <label for="slug">{{ __('Slug') }}</label>
                            <div class="slug-row">
                                <span class="slug-prefix">/categories/</span>
                                <input id="slug" type="text" name="slug" value="{{ old('slug') }}"
                                    placeholder="{{ __('auto-generated') }}"
                                    class="{{ $errors->has('slug') ? 'is-error' : '' }}">
                            </div>
                            <div class="field-hint">{{ __('Leave empty to auto-generate from name') }}</div>
                            @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="field">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" name="description"
                                placeholder="{{ __('Describe this category...') }}"
                                class="{{ $errors->has('description') ? 'is-error' : '' }}">{{ old('description') }}</textarea>
                            @error('description') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        {{-- Parent Category --}}
                        <div class="field">
                            <label for="parent_id">{{ __('Parent Category') }}</label>
                            <select id="parent_id" name="parent_id">
                                <option value="">— {{ __('No parent (top level)') }} —</option>

                                @foreach ($parentCategories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->getTranslation('name', app()->getLocale()) }}
                                    </option>
                                @endforeach

                            </select>
                            <div class="field-hint">{{ __('Optional — make this a subcategory') }}</div>
                            @error('parent_id') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right: sidebar options --}}
            <div>

                {{-- Image --}}
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                        </div>
                        <span class="card-title">{{ __('Image') }}</span>
                    </div>
                    <div class="card-body">

                        
                    
                        {{-- Upload area --}}
                        <div class="upload-area" id="uploadArea">
                            <input type="file" name="images" accept="image/*" id="imageInput">
                            <div class="upload-icon">
                                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="16 16 12 12 8 16"/>
                                    <line x1="12" y1="12" x2="12" y2="21"/>
                                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                                </svg>
                            </div>
                            <div class="upload-title">{{ $category->images ? __('Click to replace image') : __('Click or drag image here') }}</div>
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
                    
                        @error('images') <div class="field-error" style="margin-top:8px">{{ $message }}</div> @enderror
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
                                <input type="checkbox" name="status" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
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
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        {{ __('Create Category') }}
                    </button>

                    <a href="{{ route('admin.brands.create') }}" class="btn-cancel">{{ __('Cancel') }}</a>
                </div>
            </div>

    </form>

    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function () {
            const slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\u0600-\u06FF\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').placeholder = slug || '{{ __("auto-generated") }}';
        });

        // Image preview
        document.getElementById('imageInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('uploadArea').style.display = 'none';
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('removeImg').addEventListener('click', function () {
            document.getElementById('imageInput').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('uploadArea').style.display = 'block';
        });
    </script>

@endsection