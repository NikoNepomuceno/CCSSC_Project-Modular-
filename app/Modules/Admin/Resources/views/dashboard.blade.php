@extends('admin::layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-[#e3e3e0] p-8">
        <h2 class="text-xl font-semibold text-[#1b1b18] mb-4">
            Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
        </h2>
        <p class="text-[#706f6c] mb-6">This is your admin dashboard overview.</p>

        <!-- Notification Demo Buttons -->
        <div class="flex flex-wrap gap-4">
            <button
                @click="$dispatch('notify', { type: 'success', title: 'Operation Successful', message: 'The database has been updated successfully.' })"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Test Success
            </button>
            <button
                @click="$dispatch('notify', { type: 'error', title: 'Connection Failed', message: 'Could not connect to the remote server.' })"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Test Error
            </button>
            <button
                @click="$dispatch('notify', { type: 'info', title: 'New Update', message: 'Version 2.4.0 is now available for download.' })"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Test Info
            </button>
        </div>
    </div>
@endsection