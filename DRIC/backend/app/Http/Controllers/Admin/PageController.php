<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::query()
            ->with(['parent', 'creator', 'updater'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        $parentPages = Page::query()
            ->orderBy('sort_order')
            ->orderBy('slug')
            ->get(['id', 'slug']);

        return view('admin.pages.create', compact('parentPages'));
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['created_by'] = 1;
        $data['updated_by'] = 1;

        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        } elseif (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Page::create($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page): RedirectResponse
    {
        return redirect()->route('admin.pages.edit', $page);
    }

    public function edit(Page $page): View
    {
        $parentPages = Page::query()
            ->where('id', '!=', $page->id)
            ->orderBy('sort_order')
            ->orderBy('slug')
            ->get(['id', 'slug']);

        return view('admin.pages.edit', compact('page', 'parentPages'));
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $data = $request->validated();

        $data['updated_by'] = 1;

        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        } elseif (empty($data['published_at']) && empty($page->published_at)) {
            $data['published_at'] = now();
        }

        $page->update($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Delete is not enabled yet.');
    }
}