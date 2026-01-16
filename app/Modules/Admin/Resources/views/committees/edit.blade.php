@extends('admin::layouts.app')

@section('title', 'Edit Committee')
@section('header', 'Edit Committee')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-[#e3e3e0] p-6 md:p-8 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-[#1b1b18]">Edit committee</h2>
                <p class="text-sm text-[#706f6c] mt-1">
                    Update details for <span class="font-semibold">{{ $committee->name }}</span>.
                </p>
            </div>
            <a href="{{ route('admin.committees.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-3 py-2 text-xs font-medium text-[#4b4a47] hover:bg-[#f4f4f0] transition-colors">
                Back to list
            </a>
        </div>

        <form method="POST" action="{{ route('admin.committees.update', $committee) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            @include('admin::committees._form')

            <div class="flex items-center justify-between pt-2">
                @can('delete', $committee)
                    <button type="button" @click="$dispatch('open-confirmation-modal', {
                                title: 'Delete committee',
                                message: 'This will permanently delete the committee. Members assigned to this committee will be unassigned. Continue?',
                                confirmText: 'Delete',
                                actionUrl: '{{ route('admin.committees.destroy', $committee) }}',
                                actionMethod: 'DELETE'
                            })"
                        class="inline-flex items-center justify-center rounded-lg border border-transparent px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                        Delete committee
                    </button>
                @else
                    <div></div>
                @endcan

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.committees.index') }}"
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
