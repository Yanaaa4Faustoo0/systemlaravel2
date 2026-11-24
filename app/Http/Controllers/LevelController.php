<?php

namespace App\Http\Controllers;

use App\Models\MembershipLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LevelController extends Controller
{
    public function index() { return view('levels', ['levels' => MembershipLevel::orderBy('id')->get()]); }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:membership_levels,name'], 'fee' => ['required', 'numeric', 'min:0'], 'validity_months' => ['required', 'integer', 'min:1'], 'benefits' => ['nullable', 'string']]);
        MembershipLevel::create($data);
        return back()->with('success', 'Level added.');
    }

    public function update(Request $request, MembershipLevel $level)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', Rule::unique('membership_levels', 'name')->ignore($level)], 'fee' => ['required', 'numeric', 'min:0'], 'validity_months' => ['required', 'integer', 'min:1'], 'benefits' => ['nullable', 'string']]);
        $level->update($data);
        return back()->with('success', 'Level updated.');
    }

    public function destroy(MembershipLevel $level)
    {
        $level->delete();
        return back()->with('success', 'Level deleted.');
    }
}
