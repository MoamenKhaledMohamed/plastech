<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ProblemRequest;
use App\Http\Resources\ProblemResource;
class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProblemRequest $request
     * @return JsonResponse
     */
    public function store(ProblemRequest $request): JsonResponse
    {
        //validate worker data
        $problemData  = $request->validated();
        //note:this line should replaced with auth user
        $user = User::find(2);
        //insert validated array data in database
        $problem = $user->problems()->create($problemData);
        //return data encoded in json
        return response()->json([
            'problem' => new ProblemResource($problem),
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param Problem $problem
     * @return Response
     */
    public function show(Problem $problem): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Problem $problem
     * @return Response
     */
    public function edit(Problem $problem): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Problem $problem
     * @return Response
     */
    public function update(Request $request, Problem $problem): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Problem $problem
     * @return Response
     */
    public function destroy(Problem $problem): Response
    {
        //
    }
}
