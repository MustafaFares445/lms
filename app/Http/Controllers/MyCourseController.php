<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CourseResource;

class MyCourseController extends Controller
{
       /**
     * Get the list of courses for the authenticated user.
     *
     * @OA\Get(
     *     path="/api/courses/my-courses",
     *     summary="Get user courses",
     *     description="Returns a list of courses for the authenticated user",
     *     operationId="getUserCourses",
     *     tags={"Courses"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CourseResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=15
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
        $user = Auth::user();

        return CourseResource::collection(
           Course::with('media', 'teachers.media' , 'students')
            ->whereHas('students' , fn($q) => $q->where('student_id' , $user->student->id))
            ->select(['id', 'name', 'summary', 'created_at'])
            ->latest()
            ->pagiante(request()->get('perPage' , 5))
        );
    }
}
