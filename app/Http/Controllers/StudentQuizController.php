<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\StudentQuiz;
use App\Models\CourseSession;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StudentQuizResource;
use App\Http\Requests\StoreStudentQuizRequest;

class StudentQuizController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/students/quizzes",
     *     summary="Get a list of student quizzes",
     *     tags={"Student Quizzes"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/StudentQuizResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $studentQuizez = StudentQuiz::with('quizable')
            ->where('student_id' , $user->student->id)
            ->get();

        return StudentQuizResource::collection($studentQuizez);
    }

    /**
     * @OA\Post(
     *     path="/api/students/quizzes",
     *     summary="Store a new student quiz",
     *     tags={"Student Quizzes"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreStudentQuizRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Quiz stored successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StudentQuizResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreStudentQuizRequest $request)
    {
        $quiz = null;
        if($request->input('quizType') == 'quiz'){
            $quiz = Quiz::query()->find($request->input('quizId'));
        }

        if($request->input('quizType') == 'courseSession'){
            $quiz = CourseSession::query()->find($request->input('quizId'));
        }

        /** @var User $user */
        $user = Auth::user();

        $studentQuizez = StudentQuiz::query()->create(array_merge(
            $request->validated(),[
                'total_questions' =>  $quiz->questions()->count(),
                'quizable_type' => get_class($quiz),
                'quizable_id' =>  $quiz->id,
                'student_id' => $user->student->id
            ]
        ));

        return StudentQuizResource::make($studentQuizez->load('quizable'));
    }
}
