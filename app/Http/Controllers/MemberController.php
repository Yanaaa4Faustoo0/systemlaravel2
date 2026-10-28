<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $category = $request->input('category');
        $level = $request->input('level');

        $members = Member::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('member_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($category, fn ($query, $category) => $query->where('category', $category))
            ->when($level, fn ($query, $level) => $query->where('level', $level))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('members.index', [
            'members' => $members,
            'search' => $search,
            'category' => $category,
            'level' => $level,
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('members.create', $this->catalog());
    }

    public function store(Request $request)
    {
        $validated = $this->validateMember($request);
        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Member registered successfully.');
    }

    public function show(Member $member)
    {
        return view('members.show', [
            'member' => $member,
            'levelDetails' => MembershipLevel::where('name', $member->level)->first(),
        ]);
    }

    public function edit(Member $member)
    {
        return view('members.edit', array_merge(['member' => $member], $this->catalog()));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $this->validateMember($request, $member);
        $member->update($validated);

        return redirect()->route('members.show', $member)->with('success', 'Member details updated.');
    }

    public function destroy(Member $member)
    {
        $member->update(['status' => 'inactive']);

        return redirect()->route('members.index')->with('success', 'Member deactivated.');
    }

    public function deleteMember(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member permanently deleted.');
    }

    private function validateMember(Request $request, ?Member $member = null): array
    {
        return $request->validate([
            'member_number' => ['required', 'string', 'max:50', Rule::unique('members', 'member_number')->ignore($member)],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('members', 'email')->ignore($member)],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'level' => ['required', 'string', 'max:100'],
            'joined_at' => ['required', 'date'],
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ]);
    }

    private function catalog(): array
    {
        return [
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('id')->get(),
        ];
    }
}
