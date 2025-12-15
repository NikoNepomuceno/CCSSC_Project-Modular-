@extends('admin::layouts.app')

@section('title', 'Add Organization User')
@section('header', 'Add Organization User')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-[#e3e3e0] p-6 md:p-8 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-[#1b1b18]">Create member account</h2>
                <p class="text-sm text-[#706f6c] mt-1">
                    Fill in the details below to add a new organizational member.
                </p>
            </div>
            <a href="{{ route('admin.organization-users.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-3 py-2 text-xs font-medium text-[#4b4a47] hover:bg-[#f4f4f0] transition-colors">
                Back to list
            </a>
        </div>

        <form method="POST" action="{{ route('admin.organization-users.store') }}" class="space-y-8">
            @csrf

            @include('admin::organization-users._form')

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.organization-users.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] px-4 py-2.5 text-sm font-medium text-[#4b4a47] hover:bg-[#f4f4f0] transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-[#FF4400] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#e03c00] transition-colors">
                    Create member
                </button>
            </div>
        </form>
    </div>
@endsection