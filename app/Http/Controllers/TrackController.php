<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Services\Tracks\TrackServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackController extends Controller
{
    protected TrackServiceInterface $trackService;

    public function __construct(TrackServiceInterface $trackService)
    {
        $this->trackService = $trackService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);
        $filters = $request->only(['isrc', 'title']);

        return response()->json([
            'tracks' => $this->trackService->paginate($filters, $perPage, $page),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function import(string $isrc): JsonResponse
    {
        $track = $this->trackService->import($isrc);
        return response()->json($track, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track): JsonResponse
    {
        return response()->json($track);
    }
}
