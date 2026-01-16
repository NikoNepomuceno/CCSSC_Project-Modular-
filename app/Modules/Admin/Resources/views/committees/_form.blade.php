@php
    /** @var \App\Models\Committee $committee */
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Committee Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $committee->name) }}"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                required>
            @error('name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Committee Logo</label>
            <input type="file" name="logo" id="logo" accept="image/*"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent">
            @error('logo')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            @if ($committee->exists && $committee->logo)
                <div class="mt-2">
                    <p class="text-xs text-gray-500 mb-1">Current logo:</p>
                    <img src="{{ Storage::url($committee->logo) }}" alt="{{ $committee->name }}"
                        class="w-24 h-24 rounded-lg object-cover border border-[#e3e3e0]">
                </div>
            @endif
            <p class="mt-1 text-xs text-gray-500">Upload an image (JPEG, PNG, JPG, GIF, SVG). Max size: 2MB.</p>
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" id="description" rows="4"
            class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent">{{ old('description', $committee->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">Optional. Brief description of the committee's purpose and responsibilities.</p>
    </div>
</div>
