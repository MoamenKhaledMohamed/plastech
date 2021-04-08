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
     * Store a newly created resource in storage.
     *
     * @param ProblemRequest $request
     * @return JsonResponse
     */
    public function store(ProblemRequest $request): JsonResponse
    {
        $problemData  = $request->validated();
        $user = auth('user-api')->user();
        $problem = $user->problems()->create($problemData);

        //return data encoded in json
        return response()->json([
            'problem' => new ProblemResource($problem),
        ], 201);

    }
}
