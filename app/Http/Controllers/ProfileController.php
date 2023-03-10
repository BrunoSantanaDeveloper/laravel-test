<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();

        return view('profile.index', compact('profiles'));
    }

    public function create()
    {
        return view('profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date',
            'gender' => 'required',
        ]);

        Profile::create($request->all());

        return redirect()->route('profile.index')->with('success', 'Profile created successfully.');
    }

    public function show(Profile $profile)
    {
        return view('profile.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date',
            'gender' => 'required',
        ]);

        $profile->update($request->all());

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully.');
    }
}
