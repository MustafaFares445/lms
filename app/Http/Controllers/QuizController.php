<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\QuizResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\QuestionResource;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/quizzes",
     *     summary="Get a list of quizzes",
     *     tags={"Quizzes"},
     *     @OA\Parameter(
     *         name="subjectId",
     *         in="query",
     *         description="The ID of the subject to filter quizzes by",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="userSaved",
     *         in="query",
     *         description="Filter quizzes saved by the authenticated user",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of quizzes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/QuizResource"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $quizzes = Quiz::query()
            ->where('subject_id' , $request->get('subjectId'))
            ->when($request->has('userSaved') , fn($q) => $q->wherRelation('userSaved' , 'user_id' , Auth::id()))
            ->get();

        return QuizResource::collection($quizzes);
    }

    /**
     * Get quiz subjects.
     *
     * @OA\Get(
     *     path="/api/quizzes/subjects",
     *     summary="Get a list of quiz subjects",
     *     tags={"Quizzes"},
     *     @OA\Parameter(
     *         name="text",
     *         in="query",
     *         description="Filter subjects by name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of quiz subjects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SubjectResource"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getQuizSubjects(Request $request)
    {
        $subjects = Subject::with('media')
            ->when($request->has('text'), fn($q) => $q->where('name', 'like', '%' . $request->get('text') . '%'))
            ->whereHas('quizzes')
            ->withCount('quizzes')
            ->addSelect([
                'questions_count' => DB::table('questions')
                    ->where('questions.quizable_type' , Quiz::class)
                    ->join('quizzes', 'questions.quizable_id', '=', 'quizzes.id')
                    ->whereColumn('quizzes.subject_id', 'subjects.id')
                    ->selectRaw('COUNT(*)')
            ])
            ->get();

        return SubjectResource::collection($subjects);
    }

    /**
     * Get quiz questions.
     *
     * @OA\Get(
     *     path="/api/quizzes/{quiz}/questions",
     *     summary="Get a list of questions for a quiz",
     *     tags={"Quizzes"},
     *     @OA\Parameter(
     *         name="quiz",
     *         in="path",
     *         description="The ID of the quiz",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of quiz questions",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/QuestionResource"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Quiz not found"
     *     )
     * )
     */
    public function getQuizQuestions(Quiz $quiz)
    {
        $questions = $quiz->questions()
            ->with(['media' , 'answers'])
            ->get();

        return QuestionResource::collection($questions);
    }

    /**
     * Add a course to the authenticated user's saved list.
     *
     * @OA\Post(
     *     path="/api/quizzes/{quiz}/save",
     *     summary="Add a course to the user's saved list",
     *     tags={"Quizzes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="quiz",
     *         in="path",
     *         description="The ID of the quiz to save",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Quiz successfully added to saved list"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Quiz not found"
     *     )
     * )
     */
    public function addToSaved(Quiz $quiz)
    {
        $quiz->userSaved()->create(['user_id' => Auth::id()]);

        return response()->noContent();
    }

    /**
     * Remove a course from the authenticated user's saved list.
     *
     * @OA\Delete(
     *     path="/api/quizzes/{quiz}/unsave",
     *     summary="Remove a course from the user's saved list",
     *     tags={"Quizzes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="quiz",
     *         in="path",
     *         description="The ID of the quiz to unsave",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Quiz successfully removed from saved list"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Quiz not found"
     *     )
     * )
     */
    public function removeFromSaved(Quiz $quiz)
    {
        $quiz->userSaved()->where(['user_id' => Auth::id()])->delete();

        return response()->noContent();
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
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
