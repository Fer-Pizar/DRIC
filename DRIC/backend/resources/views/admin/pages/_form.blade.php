@php
    $isEdit = isset($page);
@endphp

<div style="display: grid; gap: 18px;">
    <div>
        <label for="parent_id" style="display:block; margin-bottom:6px; font-weight:bold;">Página superior</label>
        <select name="parent_id" id="parent_id" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
            <option value="">Sin página superior</option>
            @foreach ($parentPages as $parentPage)
                <option value="{{ $parentPage->id }}"
                    {{ old('parent_id', $page->parent_id ?? '') == $parentPage->id ? 'selected' : '' }}>
                    {{ $parentPage->slug }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
            <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="slug" style="display:block; margin-bottom:6px; font-weight:bold;">Identificador de URL</label>
        <input
            type="text"
            name="slug"
            id="slug"
            value="{{ old('slug', $page->slug ?? '') }}"
            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
        >
        @error('slug')
            <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="page_type" style="display:block; margin-bottom:6px; font-weight:bold;">Tipo de página</label>
        <input
            type="text"
            name="page_type"
            id="page_type"
            value="{{ old('page_type', $page->page_type ?? '') }}"
            placeholder="Ejemplo: static, page, content"
            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
        >
        @error('page_type')
            <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="status" style="display:block; margin-bottom:6px; font-weight:bold;">Estado</label>
        <select name="status" id="status" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
            <option value="draft" {{ old('status', $page->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Borrador</option>
            <option value="published" {{ old('status', $page->status ?? '') === 'published' ? 'selected' : '' }}>Publicado</option>
            <option value="archived" {{ old('status', $page->status ?? '') === 'archived' ? 'selected' : '' }}>Archivado</option>
        </select>
        @error('status')
            <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="sort_order" style="display:block; margin-bottom:6px; font-weight:bold;">Orden</label>
        <input
            type="number"
            name="sort_order"
            id="sort_order"
            value="{{ old('sort_order', $page->sort_order ?? 0) }}"
            min="0"
            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
        >
        @error('sort_order')
            <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="published_at" style="display:block; margin-bottom:6px; font-weight:bold;">Fecha de publicación</label>
        <input
            type="datetime-local"
            name="published_at"
            id="published_at"
            value="{{ old('published_at', isset($page) && $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '') }}"
            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
        >
        @error('published_at')
            <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div>
        @enderror
    </div>
</div>
