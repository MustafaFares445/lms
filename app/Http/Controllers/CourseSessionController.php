<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Http\Resources\QuestionResource;

class CourseSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseSession $courseSession)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/courses/sessions/{courseSession}/quiz-questions",
     *     summary="Get quiz questions for a specific course session",
     *     description="Retrieve all quiz questions associated with a specific course session, including media and answers.",
     *     operationId="getQuizQuestions",
     *     tags={"Course Sessions"},
     *     @OA\Parameter(
     *         name="courseSession",
     *         in="path",
     *         description="ID of the course session",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/QuestionResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course session not found"
     *     )
     * )
     */
    public function getQuizQuestions(CourseSession $courseSession)
    {
        $questions = $courseSession->questions()
            ->with(['media' , 'answers'])
            ->get();

        return QuestionResource::collection($questions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseSession $courseSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSession $courseSession)
    {
        //
    }
}
