<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\Committee;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

		$committees = Committee::query()
			->withCount('organizationUsers')
			->when($search, function ($query) use ($search) {
				$query->where(function ($q) use ($search) {
					$q->where('name', 'like', "%{$search}%")
					->orWhere('description', 'like', "%{$search}%");
				});
			})
			->orderBy('name')
			->paginate(10)
			->withQueryString();

		return view('admin::committees.index', [
			'committees' => $committees,
			'filters' => [
				'search' => $search,
			],
		]);
    }

	public function create(): View
	{
		Gate::authorize('create', Committee::class);

		return view('admin::committees.create', [
			'committee' => new Committee(),
		]);
	}


	public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Committee::class);

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:committees,name'],
                'description' => ['nullable', 'string', 'max:1000'],
                'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('committees/logos', 'public');
                $validated['logo'] = $logoPath;
            }

            Committee::create($validated);

            return redirect()
                ->route('admin.committees.index')
                ->with('success', 'Committee created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create committee. Please try again.');
        }
    }

	public function edit(Committee $committee): View
    {
        Gate::authorize('update', $committee);

        return view('admin::committees.edit', [
            'committee' => $committee,
        ]);
    }

	public function update(Request $request, Committee $committee): RedirectResponse
    {
        Gate::authorize('update', $committee);

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:committees,name,' . $committee->id],
                'description' => ['nullable', 'string', 'max:1000'],
                'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if it exists
                if ($committee->logo && Storage::disk('public')->exists($committee->logo)) {
                    Storage::disk('public')->delete($committee->logo);
                }

                $logoPath = $request->file('logo')->store('committees/logos', 'public');
                $validated['logo'] = $logoPath;
            }

            $committee->update($validated);

            return redirect()
                ->route('admin.committees.index')
                ->with('success', 'Committee updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update committee. Please try again.');
        }
    }

	public function destroy(Committee $committee): RedirectResponse
    {
        Gate::authorize('delete', $committee);

        try {
            // Delete logo if it exists
            if ($committee->logo && Storage::disk('public')->exists($committee->logo)) {
                Storage::disk('public')->delete($committee->logo);
            }

            $committee->delete();

            return redirect()
                ->route('admin.committees.index')
                ->with('success', 'Committee deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete committee. Please try again.');
        }
    }

}