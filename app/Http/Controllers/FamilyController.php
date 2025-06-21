<?php
// app/Http/Controllers/FamilyController.php

namespace App\Http\Controllers;
use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of families
     */
    public function index()
    {
        $families = Family::paginate(10);
        return view('families.index', compact('families'));
    }

    /**
     * Show the form for creating a new family
     */
    public function create()
    {
        return view('families.create');
    }

    /**
     * Store a newly created family
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'generation' => 'nullable|integer|min:1'
        ]);

        Family::create($request->all());

        return redirect()->route('families.index')
                        ->with('success', 'Family created successfully');
    }

    /**
     * Display the specified family
     */
    public function show(Family $family)
    {
        $family->load(['members' => function ($query) {
            $query->with(['socialLinks', 'children'])
                  ->orderBy('birth_date');
        }]);
        
        // Untuk pagination, ambil members secara terpisah dengan paginate()
        $members = Member::where('family_id', $family->id)
                        ->with(['socialLinks', 'children'])
                        ->orderBy('birth_date')
                        ->paginate(15);
        
        return view('families.show', compact('family', 'members'));
    }

    /**
     * Show the form for editing the specified family
     */
    public function edit(Family $family)
    {
        return view('families.edit', compact('family'));
    }

    /**
     * Update the specified family
     */
    public function update(Request $request, Family $family)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'generation' => 'nullable|integer|min:1'
        ]);

        $family->update($request->all());

        return redirect()->route('families.index')
                        ->with('success', 'Family updated successfully');
    }

    /**
     * Remove the specified family
     */
    public function destroy(Family $family)
    {
        // Check if family has members
        if ($family->members()->count() > 0) {
            return redirect()->route('families.index')
                           ->with('error', 'Cannot delete family with existing members');
        }

        $family->delete();

        return redirect()->route('families.index')
                        ->with('success', 'Family deleted successfully');
    }

    /**
     * Display family tree page
     */
    public function tree()
    {
        $families = Family::with(['rootMembers' => function ($query) {
                           $query->with(['children' => function ($childQuery) {
                               $childQuery->with('children.children.children')
                                         ->orderBy('birth_date');
                           }])
                           ->orderBy('birth_date');
                       }])
                       ->orderBy('generation')
                       ->orderBy('name')
                       ->get();

        return view('families.tree', compact('families'));
    }

    /**
     * Show specific family tree
     */
    public function showTree(Family $family)
    {
        $family->load(['rootMembers' => function ($query) {
            $query->with(['children' => function ($childQuery) {
                $childQuery->with('children.children.children')
                          ->orderBy('birth_date');
            }])
            ->orderBy('birth_date');
        }]);

        return view('families.tree-detail', compact('family'));
    }

    /**
     * API endpoint for web (untuk AJAX calls dari web)
     */
    public function apiIndex()
    {
        $families = Family::withCount(['members', 'activeMembers'])
                         ->orderBy('generation')
                         ->orderBy('name')
                         ->get();

        return response()->json([
            'success' => true,
            'data' => $families
        ]);
    }
}