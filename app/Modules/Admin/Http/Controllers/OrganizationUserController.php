<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\Committee;
use App\Models\OrganizationUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrganizationUserController extends Controller
{
    /**
     * Display a listing of organization users.
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', OrganizationUser::class);

        $search = $request->string('search')->toString();
        $committeeId = $request->integer('committee_id') ?: null;

        $users = OrganizationUser::query()
            ->with('committee')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->when($committeeId, fn ($query) => $query->where('committee_id', $committeeId))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $committees = Committee::orderBy('name')->get();

        return view('admin::organization-users.index', [
            'users' => $users,
            'committees' => $committees,
            'filters' => [
                'search' => $search,
                'committee_id' => $committeeId,
            ],
        ]);
    }

    /**
     * Show the form for creating a new organization user.
     */
    public function create(): View
    {
        Gate::authorize('create', OrganizationUser::class);

        $committees = Committee::orderBy('name')->get();

        return view('admin::organization-users.create', [
            'organizationUser' => new OrganizationUser(),
            'committees' => $committees,
        ]);
    }

    /**
     * Store a newly created organization user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', OrganizationUser::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:organization_users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'position' => ['required', 'string', 'max:255'],
            'committee_id' => ['nullable', 'exists:committees,id'],
            'permission' => ['required', 'in:viewer,editor'],
        ]);

        OrganizationUser::create($validated);

        return redirect()
            ->route('admin.organization-users.index')
            ->with('success', 'Organization user created successfully.');
    }

    /**
     * Show the form for editing the specified organization user.
     */
    public function edit(OrganizationUser $organizationUser): View
    {
        Gate::authorize('update', $organizationUser);

        $committees = Committee::orderBy('name')->get();

        return view('admin::organization-users.edit', [
            'organizationUser' => $organizationUser,
            'committees' => $committees,
        ]);
    }

    /**
     * Update the specified organization user in storage.
     */
    public function update(Request $request, OrganizationUser $organizationUser): RedirectResponse
    {
        Gate::authorize('update', $organizationUser);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:organization_users,email,' . $organizationUser->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'position' => ['required', 'string', 'max:255'],
            'committee_id' => ['nullable', 'exists:committees,id'],
            'permission' => ['required', 'in:viewer,editor'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $organizationUser->update($validated);

        return redirect()
            ->route('admin.organization-users.index')
            ->with('success', 'Organization user updated successfully.');
    }

    /**
     * Archive (delete) the specified organization user.
     */
    public function destroy(OrganizationUser $organizationUser): RedirectResponse
    {
        Gate::authorize('delete', $organizationUser);

        $organizationUser->delete();

        return redirect()
            ->route('admin.organization-users.index')
            ->with('success', 'Organization user has been archived.');
    }
}

