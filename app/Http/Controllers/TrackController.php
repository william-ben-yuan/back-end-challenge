<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tracks\StoreTrackRequest;
use App\Http\Requests\Tracks\UpdateTrackRequest;
use App\Models\Track;
use App\Services\Tracks\TrackServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackController extends Controller
{
    protected $trackService;

    public function __construct(TrackServiceInterface $trackService)
    {
        $this->trackService = $trackService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json([
            'tracks' => $this->trackService->find($request->all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrackRequest $request)
    {
        $track = $this->trackService->create($request->validated());
        return response()->json($track, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        return response()->json($track);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateTrackRequest $request, Track $track)
    // {
    //     $this->trackService->update($track, $request->validated());
    //     return response()->json($track);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Track $track)
    // {
    //     $this->trackService->delete($track);
    //     return response()->json(null, Response::HTTP_NO_CONTENT);
    // }
}
