<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Return a list of all profiles.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $profiles = Profile::all();
        return response()->json(['data' => $profiles]);
    }

    /**
     * Return a specific profile by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $profile = Profile::with('report')->findOrFail($id);

        if ($profile) {
            return response()->json(['data' => $profile]);
        } else {
            return response()->json(['message' => 'Profile not found.'], 404);
        }
    }

    /**
     * Create a new profile with the data from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $profile = new Profile;
        $profile->first_name = $request->input('first_name');
        $profile->last_name = $request->input('last_name');
        $profile->dob = $request->input('dob');
        $profile->gender = $request->input('gender');
        $profile->save();

        return response()->json(['data' => $profile], 201);
    }

    /**
     * Update an existing profile with the data from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);

        if ($profile) {
            $profile->first_name = $request->input('first_name');
            $profile->last_name = $request->input('last_name');
            $profile->dob = $request->input('dob');
            $profile->gender = $request->input('gender');
            $profile->save();

            return response()->json(['data' => $profile]);
        } else {
            return response()->json(['message' => 'Profile not found.'], 404);
        }
    }

    /**
     * Delete a profile by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);

        if ($profile) {
            $profile->delete();
            return response()->json([], 204);
        } else {
            return response()->json(['message' => 'Profile not found.'], 404);
        }
    }
}
