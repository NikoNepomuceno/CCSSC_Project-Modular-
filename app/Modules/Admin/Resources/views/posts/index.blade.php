@extends('admin::layouts.app')

@section('title', 'Posts')
@section('header', 'Posts')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-[#e3e3e0] p-6 md:p-8 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-[#1b1b18]">Manage Posts</h2>
                <p class="text-sm text-[#706f6c] mt-1">
                    View, create, edit, and delete posts. Posts are authored by organization members.
                </p>
            </div>

            <a href="{{ route('admin.posts.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#FF4400] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#e03c00] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                <span>New Post</span>
            </a>
        </div>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] gap-4 items-end">
            <div>
                <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Search</label>
                <div class="relative">
                    <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}"
                        placeholder="Search by title or content"
                        class="block w-full rounded-lg border border-[#e3e3e0] pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_auto] gap-3">
                <div>
                    <label for="author_id" class="block text-xs font-medium text-gray-600 mb-1">Author</label>
                    <select id="author_id" name="author_id"
                        class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent">
                        <option value="">All authors</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" @selected(($filters['author_id'] ?? null) == $author->id)>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 md:justify-end">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-4 py-2.5 text-sm font-medium text-[#1b1b18] hover:bg-[#f4f4f0] transition-colors">
                        Apply
                    </button>
                    <a href="{{ route('admin.posts.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-transparent px-3 py-2.5 text-xs font-medium text-gray-500 hover:text-gray-700">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="border border-[#e3e3e0] rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-[#ecebe7]">
                <thead class="bg-[#faf9f5]">
                    <tr>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Title</th>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Author</th>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Content Preview</th>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Created</th>
                        <th scope="col" class="px-4 py-3.5 text-right text-xs font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f1ec] bg-white">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-[#faf9f5]">
                            <td class="px-4 py-3 text-sm text-[#1b1b18] font-medium max-w-[200px]">
                                <span class="truncate block">{{ $post->title }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-[#4b4a47]">
                                @if ($post->organizationUser)
                                    <span class="inline-flex items-center rounded-full bg-[#f4f4f0] px-2.5 py-1 text-xs font-medium text-[#4b4a47]">
                                        {{ $post->organizationUser->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Unknown</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-[#706f6c] max-w-[300px]">
                                <span class="truncate block">{{ Str::limit(strip_tags($post->content), 80) }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-[#4b4a47]">
                                {{ $post->created_at?->format('M d, Y') ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-3 py-1.5 text-xs font-medium text-[#1b1b18] hover:bg-[#f4f4f0] transition-colors">
                                        Edit
                                    </a>
                                    <button type="button" @click="$dispatch('open-confirmation-modal', {
                                                                    title: 'Delete post',
                                                                    message: 'Are you sure you want to delete this post? This action cannot be undone.',
                                                                    confirmText: 'Delete',
                                                                    actionUrl: '{{ route('admin.posts.destroy', $post) }}',
                                                                    actionMethod: 'DELETE'
                                                                })"
                                        class="inline-flex items-center justify-center rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
                                No posts found. <a href="{{ route('admin.posts.create') }}" class="text-[#FF4400] hover:underline">Create your first post</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($posts->hasPages())
            <div class="flex items-center justify-between text-xs text-gray-500">
                <div>
                    Showing
                    <span class="font-semibold text-gray-700">{{ $posts->firstItem() }}</span>
                    to
                    <span class="font-semibold text-gray-700">{{ $posts->lastItem() }}</span>
                    of
                    <span class="font-semibold text-gray-700">{{ $posts->total() }}</span>
                    results
                </div>
                <div class="flex items-center gap-2">
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
