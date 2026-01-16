@extends('admin::layouts.app')

@section('title', 'Committees')
@section('header', 'Committees')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-[#e3e3e0] p-6 md:p-8 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-[#1b1b18]">Committees</h2>
                <p class="text-sm text-[#706f6c] mt-1">
                    Manage committees. You can add, edit, and delete committees.
                </p>
            </div>

            @can('create', App\Models\Committee::class)
                <a href="{{ route('admin.committees.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#FF4400] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#e03c00] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    <span>Add Committee</span>
                </a>
            @endcan
        </div>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-[minmax(0,2fr)_auto] gap-4 items-end">
            <div>
                <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Search</label>
                <div class="relative">
                    <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}"
                        placeholder="Search by name or description"
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

            <div class="flex gap-2 md:justify-end">
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-4 py-2.5 text-sm font-medium text-[#1b1b18] hover:bg-[#f4f4f0] transition-colors">
                    Apply
                </button>
                <a href="{{ route('admin.committees.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-transparent px-3 py-2.5 text-xs font-medium text-gray-500 hover:text-gray-700">
                    Reset
                </a>
            </div>
        </form>

        <div class="border border-[#e3e3e0] rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-[#ecebe7]">
                <thead class="bg-[#faf9f5]">
                    <tr>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Logo</th>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Name</th>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Description</th>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Members</th>
                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold text-gray-600">Created</th>
                        <th scope="col" class="px-4 py-3.5 text-right text-xs font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f1ec] bg-white">
                    @forelse ($committees as $committee)
                        <tr class="hover:bg-[#faf9f5]">
                            <td class="px-4 py-3">
                                @if ($committee->logo)
                                    <img src="{{ Storage::url($committee->logo) }}" alt="{{ $committee->name }}"
                                        class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M18 21a8 8 0 0 0-16 0" />
                                            <circle cx="10" cy="8" r="5" />
                                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-[#1b1b18] font-medium">{{ $committee->name }}</td>
                            <td class="px-4 py-3 text-sm text-[#4b4a47]">
                                {{ $committee->description ? Str::limit($committee->description, 50) : '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-[#4b4a47]">
                                <span
                                    class="inline-flex items-center rounded-full bg-[#f4f4f0] px-2.5 py-1 text-xs font-medium text-[#4b4a47]">
                                    {{ $committee->organization_users_count }} member{{ $committee->organization_users_count !== 1 ? 's' : '' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-[#4b4a47]">
                                {{ $committee->created_at?->format('M d, Y') ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-right">
                                <div class="inline-flex items-center gap-2">
                                    @can('update', $committee)
                                        <a href="{{ route('admin.committees.edit', $committee) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-3 py-1.5 text-xs font-medium text-[#1b1b18] hover:bg-[#f4f4f0] transition-colors">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete', $committee)
                                        <button type="button" @click="$dispatch('open-confirmation-modal', {
                                                                    title: 'Delete committee',
                                                                    message: 'This will permanently delete the committee. Members assigned to this committee will be unassigned. Continue?',
                                                                    confirmText: 'Delete',
                                                                    actionUrl: '{{ route('admin.committees.destroy', $committee) }}',
                                                                    actionMethod: 'DELETE'
                                                                })"
                                            class="inline-flex items-center justify-center rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                                            Delete
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">
                                No committees found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($committees->hasPages())
            <div class="flex items-center justify-between text-xs text-gray-500">
                <div>
                    Showing
                    <span class="font-semibold text-gray-700">{{ $committees->firstItem() }}</span>
                    to
                    <span class="font-semibold text-gray-700">{{ $committees->lastItem() }}</span>
                    of
                    <span class="font-semibold text-gray-700">{{ $committees->total() }}</span>
                    results
                </div>
                <div class="flex items-center gap-2">
                    {{ $committees->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
