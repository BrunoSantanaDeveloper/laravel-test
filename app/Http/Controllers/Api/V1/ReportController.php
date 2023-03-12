<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Return a list of all reports.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $reports = Report::with('profiles')->get();
        return response()->json(['data' => $reports]);
    }

    /**
     * Return a specific report by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $report = Report::find($id);

        if ($report) {
            return response()->json(['data' => $report]);
        } else {
            return response()->json(['message' => 'Report not found.'], 404);
        }
    }

    /**
     * Create a new report with the data from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $report = new Report;
        $report->title = $request->input('title');
        $report->description = $request->input('description');
        $report->save();

        return response()->json(['data' => $report], 201);
    }

    /**
     * Update an existing report with the data from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $report = Report::find($id);

        if ($report) {
            $report->title = $request->input('title');
            $report->description = $request->input('description');
            $report->save();

            return response()->json(['data' => $report]);
        } else {
            return response()->json(['message' => 'Report not found.'], 404);
        }
    }

    /**
     * Delete a report by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $report = Report::find($id);

        if ($report) {
            $report->delete();
            return response()->json([], 204);
        } else {
            return response()->json(['message' => 'Report not found.'], 404);
        }
    }

    public function createProfile(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $profile = new Profile();
        $profile->fill($request->all());
        $report->profiles()->save($profile);

        return response()->json($profile, 201);
    }
}
