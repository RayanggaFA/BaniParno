<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberHistory;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Generation;


class MemberController extends Controller
{
    /**
     * Display a listing of members
     */
    public function index(Request $request)
    {
        $query = Member::with(['family', 'socialLinks', 'parent']);

        if ($request->has('family_id')) {
            $query->where('family_id', $request->family_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 15);
        $members = $query->paginate($perPage);

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $families = Family::all();
        $members = Member::all();

        return view('members.create', compact('families', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'job' => 'required|string|max:255',
            'address_ktp' => 'required|string',
            'domicile_city' => 'required|string|max:255',
            'domicile_province' => 'required|string|max:255',
            'current_address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'family_id' => 'required|exists:families,id',
            'parent_id' => 'nullable|exists:members,id',
            'gender' => 'required|in:male,female',
            'status' => 'required|in:active,inactive,deceased',
            'notes' => 'nullable|string'
        ]);

        $member = Member::create($request->all());
        $photo->storeAs('photos', $filename, 'public');

        MemberHistory::create([
            'member_id' => $member->id,
            'field_changed' => 'created',
            'old_value' => null,
            'new_value' => 'Member created',
            'changed_by' => $request->get('changed_by', 'System'),
            'reason' => 'New member registration'
        ]);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Member $member)
    {
        $member->load([
            'family',
            'socialLinks',
            'parent',
            'children' => fn($q) => $q->orderBy('birth_date'),
            'histories' => fn($q) => $q->orderBy('created_at', 'desc')->limit(10)
        ]);

        return view('members.show', compact('member'));
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $families = Family::all();
        $generations = Generation::all();

        return view('members.edit', compact('member', 'families', 'generations'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'birth_place' => 'sometimes|required|string|max:255',
            'birth_date' => 'sometimes|required|date',
            'job' => 'sometimes|required|string|max:255',
            'address_ktp' => 'sometimes|required|string',
            'domicile_city' => 'sometimes|required|string|max:255',
            'domicile_province' => 'sometimes|required|string|max:255',
            'current_address' => 'sometimes|required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'family_id' => 'sometimes|required|exists:families,id',
            'parent_id' => 'nullable|exists:members,id',
            'gender' => 'sometimes|required|in:male,female',
            'status' => 'sometimes|required|in:active,inactive,deceased',
            'notes' => 'nullable|string',
            'generation' => 'nullable|integer|min:1|max:10'
        ]);

        $oldValues = $member->toArray();
        $member->update($request->all());

        $changedBy = $request->get('changed_by', 'System');
        $reason = $request->get('reason', 'Data update');

        foreach ($request->all() as $field => $newValue) {
            if (isset($oldValues[$field]) && $oldValues[$field] != $newValue) {
                MemberHistory::create([
                    'member_id' => $member->id,
                    'field_changed' => $field,
                    'old_value' => $oldValues[$field],
                    'new_value' => $newValue,
                    'changed_by' => $changedBy,
                    'reason' => $reason,
                    'generation' => $request->generation
                ]);
            }
        }

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($member->children()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus anggota yang memiliki anak.');
        }

        if ($member->photo) {
            Storage::disk('public')->delete('photos/' . $member->photo);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function getChildren(Member $member)
    {
        $children = $member->children()
            ->with(['socialLinks'])
            ->orderBy('birth_date')
            ->get();

        return view('members.children', compact('member', 'children'));
    }

    public function getHistory(Member $member)
    {
        $history = $member->histories()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('members.history', compact('member', 'history'));
    }

    public function uploadPhoto(Request $request, Member $member)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($member->photo) {
            Storage::disk('public')->delete('photos/' . $member->photo);
        }

        $photo = $request->file('photo');
        $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
        $photo->storeAs('photos', $filename, 'public');

        $member->update(['photo' => $filename]);

        MemberHistory::create([
            'member_id' => $member->id,
            'field_changed' => 'photo',
            'old_value' => null,
            'new_value' => $filename,
            'changed_by' => $request->get('changed_by', 'System'),
            'reason' => 'Photo upload'
        ]);

        return redirect()->back()->with('success', 'Foto anggota berhasil diunggah!');
    }
}
