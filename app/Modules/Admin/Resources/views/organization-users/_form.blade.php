@php
    /** @var \App\Models\OrganizationUser $organizationUser */
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $organizationUser->name) }}"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                required>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $organizationUser->email) }}"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                required>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position / Role</label>
            <input type="text" name="position" id="position" value="{{ old('position', $organizationUser->position) }}"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                required>
        </div>

        <div>
            <label for="committee_id" class="block text-sm font-medium text-gray-700 mb-1">Committee</label>
            <select name="committee_id" id="committee_id"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent">
                <option value="">No committee</option>
                @foreach ($committees as $committee)
                    <option value="{{ $committee->id }}" @selected(old('committee_id', $organizationUser->committee_id) == $committee->id)>
                        {{ $committee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="permission" class="block text-sm font-medium text-gray-700 mb-1">Permission</label>
            <select name="permission" id="permission"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                required>
                <option value="viewer" @selected(old('permission', $organizationUser->permission ?? 'viewer') === 'viewer')>
                    Viewer (can only view posts)
                </option>
                <option value="editor" @selected(old('permission', $organizationUser->permission ?? 'viewer') === 'editor')>
                    Editor (can manage posts)
                </option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                Password
                @if ($organizationUser->exists)
                    <span class="text-xs text-gray-500 font-normal">(leave blank to keep current password)</span>
                @endif
            </label>
            <input type="password" name="password" id="password"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                @if (!$organizationUser->exists) required @endif>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Confirm Password
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="block w-full rounded-lg border border-[#e3e3e0] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                @if (!$organizationUser->exists) required @endif>
        </div>
    </div>
</div>