<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of profiles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all profiles from the database
        $profiles = Profile::all();

        // Render the profile.index view with the retrieved profiles
        return view('profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new profile.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Render the profile.create view to create a new profile
        return view('profile.create');
    }

    /**
     * Store a newly created profile in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate required fields
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date',
            'gender' => 'required',
        ]);

        // Create a new profile with request data
        Profile::create($request->all());

        // Redirect to profile listing with success message
        return redirect()->route('profile.index')->with('success', 'Profile created successfully.');
    }

    /**
     * Display the specified profile.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\View\View
     */
    public function show(Profile $profile)
    {
        // Render the profile.show view with the specific profile passed as a parameter
        return view('profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified profile.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\View\View
     */
    public function edit(Profile $profile)
    {
        // Render the profile.edit view with the specific profile passed as a parameter for editing
        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified profile in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Profile $profile)
    {
        // Validate required fields
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date',
            'gender' => 'required',
        ]);

        // Update the profile with the request data
        $profile->update($request->all());

        // Redirect to profile listing with success message
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified profile from the database.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Profile $profile)
    {
        // Remove the profile
        $profile->delete();

        // Redirect to profile listing with success message
        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully.');
    }
}
