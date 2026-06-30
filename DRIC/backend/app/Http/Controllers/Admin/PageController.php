<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::query()
            ->with(['parent', 'creator', 'updater'])
            ->tap(fn ($query) => PagePermissionMap::scopeVisibleToUser($query, auth()->user()))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.pages.index', [
            'pages' => $pages,
            'isAdmin' => auth()->user()->hasRole('Admin'),
        ]);
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        $parentPages = Page::query()
            ->orderBy('sort_order')
            ->orderBy('slug')
            ->get(['id', 'slug']);

        return view('admin.pages.create', compact('parentPages'));
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $data = $request->validated();

        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        } elseif (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Page::create($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Página creada correctamente.');
    }

    public function show(Page $page): RedirectResponse
    {
        return redirect()->route('admin.pages.edit', $page);
    }

    public function edit(Page $page): View
    {
        $this->authorizePageAccess($page);

        $parentPages = Page::query()
            ->where('id', '!=', $page->id)
            ->orderBy('sort_order')
            ->orderBy('slug')
            ->get(['id', 'slug']);

        return view('admin.pages.edit', compact('page', 'parentPages'));
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $this->authorizePageAccess($page);

        $data = $request->validated();

        $data['updated_by'] = $request->user()->id;

        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        } elseif (empty($data['published_at']) && empty($page->published_at)) {
            $data['published_at'] = now();
        }

        $page->update($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Página actualizada correctamente.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->authorizeAdmin();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'La eliminación todavía no está habilitada.');
    }

    private function authorizePageAccess(Page $page): void
    {
        abort_unless(
            PagePermissionMap::canEditPage(auth()->user(), $page),
            403,
            'No tienes permiso para editar esta página.'
        );
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->hasRole('Admin'), 403, 'Solo el administrador puede crear páginas.');
    }
}
