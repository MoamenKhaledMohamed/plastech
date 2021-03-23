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
}
