<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Resources\UniversityResource;


class UniversityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/universities",
     *     summary="Get a list of universities",
     *     tags={"Universities"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UniversityResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return UniversityResource::collection(
            University::query()->get()
        );
    }


    public function store(Request $request)
    {
        //
    }


    public function show(University $university)
    {
        //
    }

    public function update(Request $request, University $university)
    {
        //
    }

    public function destroy(University $university)
    {
        //
    }
}
