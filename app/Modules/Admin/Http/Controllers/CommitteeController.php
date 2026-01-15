<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\Committee;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
		return view('admin::committees.create', [
			'committee' => new Committee(),
		]);
	}


	public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:committees,name'],
                'description' => ['nullable', 'string', 'max:1000'],
            ]);

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
        return view('admin::committees.edit', [
            'committee' => $committee,
        ]);
    }

	public function update(Request $request, Committee $committee): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:committees,name,' . $committee->id],
                'description' => ['nullable', 'string', 'max:1000'],
            ]);

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
        try {
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