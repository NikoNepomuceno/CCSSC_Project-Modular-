@extends('admin::layouts.app')

@section('title', 'Edit Organization User')
@section('header', 'Edit Organization User')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-[#e3e3e0] p-6 md:p-8 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-[#1b1b18]">Edit member account</h2>
                <p class="text-sm text-[#706f6c] mt-1">
                    Update details for <span class="font-semibold">{{ $organizationUser->name }}</span>.
                </p>
            </div>
            <a href="{{ route('admin.organization-users.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-3 py-2 text-xs font-medium text-[#4b4a47] hover:bg-[#f4f4f0] transition-colors">
                Back to list
            </a>
        </div>

        <form method="POST" action="{{ route('admin.organization-users.update', $organizationUser) }}" class="space-y-8">
            @csrf
            @method('PUT')

            @include('admin::organization-users._form')

            <div class="flex items-center justify-between pt-2">
                <button type="button" @click="$dispatch('open-confirmation-modal', {
                                title: 'Archive member',
                                message: 'This will archive the account and remove access. Posts they created may also be affected. Continue?',
                                confirmText: 'Archive',
                                actionUrl: '{{ route('admin.organization-users.destroy', $organizationUser) }}',
                                actionMethod: 'DELETE'
                            })"
                    class="inline-flex items-center justify-center rounded-lg border border-transparent px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                    Archive member
                </button>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.organization-users.index') }}"
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