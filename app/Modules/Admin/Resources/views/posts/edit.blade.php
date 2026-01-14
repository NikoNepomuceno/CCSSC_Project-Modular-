@extends('admin::layouts.app')

@section('title', 'Edit Post')
@section('header', 'Edit Post')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-[#e3e3e0] p-6 md:p-8 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-[#1b1b18]">Edit post</h2>
                <p class="text-sm text-[#706f6c] mt-1">
                    Update details for <span class="font-semibold">"{{ Str::limit($post->title, 40) }}"</span>.
                </p>
            </div>
            <a href="{{ route('admin.posts.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-3 py-2 text-xs font-medium text-[#4b4a47] hover:bg-[#f4f4f0] transition-colors">
                Back to list
            </a>
        </div>

        <form method="POST" action="{{ route('admin.posts.update', $post) }}" class="space-y-8">
            @csrf
            @method('PUT')

            @include('admin::posts._form')

            <div class="flex items-center justify-between pt-2">
                <button type="button" @click="$dispatch('open-confirmation-modal', {
                                title: 'Delete post',
                                message: 'Are you sure you want to delete this post? This action cannot be undone.',
                                confirmText: 'Delete',
                                actionUrl: '{{ route('admin.posts.destroy', $post) }}',
                                actionMethod: 'DELETE'
                            })"
                    class="inline-flex items-center justify-center rounded-lg border border-transparent px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                    Delete post
                </button>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.posts.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-4 py-2.5 text-sm font-medium text-[#4b4a47] hover:bg-[#f4f4f0] transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-[#FF4400] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#e03c00] transition-colors">
                        Save changes
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
