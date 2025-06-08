<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\TeacherResource;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Home Page",
 *     description="Endpoints related to the home page"
 * )
 */
class HomePageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/home/recently-added",
     *     summary="Get recently added courses",
     *     description="Returns a list of the 5 most recently added courses",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CourseResource")
     *         )
     *     ),
     *     tags={"Home Page"}
     * )
     */
    public function recentlyAdded()
    {
        return CourseResource::collection(
            Course::with('media')
            ->select(['id', 'name', 'summary', 'type' , 'slug' ,'created_at'])
            ->withCount(['students'])
            ->latest()
            ->take(5)
            ->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/home/my-courses",
     *     summary="Get user's enrolled courses",
     *     description="Returns a list of the 5 most recently enrolled courses for the authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CourseResource")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}},
     *     tags={"Home Page"}
     * )
     */
    public function myCourses()
    {
        $user = Auth::user();

        return CourseResource::collection(
           Course::with('media', 'teachers.media' , 'students')
            ->whereHas('students' , fn($q) => $q->where('student_id' , $user->student->id))
            ->select(['id', 'name', 'summary', 'slug' , 'created_at'])
            ->latest()
            ->take(5)
            ->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/home/top-teachers",
     *     summary="Get top rated teachers",
     *     description="Returns a list of the top 5 rated teachers",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TeacherResource")
     *         )
     *     ),
     *     tags={"Home Page"}
     * )
     */
    public function topTeachers()
    {
        return TeacherResource::collection(
            Teacher::with('media')
                ->withCount(['courses' , 'reviews'])
                ->orderBy('rate')
                ->take(5)
                ->get()
        );
    }
}
