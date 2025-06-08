<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\TeacherResource;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use App\Models\Review;
use App\Models\Teacher;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/courses",
     *     summary="Get a list of courses",
     *     tags={"Courses"},
     *     @OA\Parameter(
     *         name="year",
     *         in="query",
     *         description="Filter courses by year",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Number of courses per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CourseResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer',
            'text' => 'nullable|string',
            'perPage' => 'nullable|integer|min:1|max:100',
        ]);

        $perPage = $request->get('perPage', 5);

        $courses = Course::with('media')
            ->withCount(['teachers', 'students'])
            ->when($request->has('year'), fn($q) => $q->where('year', $request->get('year')))
            ->when($request->has('text'), function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->get('text') . '%')
                  ->orWhereHas('teachers', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->get('text') . '%');
                  });
            })
            ->select(['id', 'name', 'slug' , 'summary', 'price', 'year', 'discount', 'rating', 'created_at'])
            ->latest()
            ->paginate($perPage);

        return CourseResource::collection($courses);
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
     *
     * @OA\Get(
     *     path="/api/courses/{course}",
     *     summary="Get a specific course by ID",
     *     tags={"Courses"},
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         description="slug of the course to retrieve",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found"
     *     )
     * )
     */
    public function show(Course $course)
    {
        $course->filesCount = Media::query()
            ->whereIn('model_id', CourseSession::query()->where('course_id', $course->id)->pluck('id')->toArray())
            ->where('model_type', CourseSession::class)
            ->count();

        $course
        ->load([
            'media',
            'reviews.user.media',
            'courseSessions' => fn($q) => $q->orderBy('order', 'asc')->limit(4),
        ])
        ->loadCount(['teachers', 'students', 'quizez']);

        return CourseResource::make($course);
    }

    /**
     * Get the teachers associated with a specific course.
     *
     * @OA\Get(
     *     path="/api/courses/{course}/teachers",
     *     summary="Get teachers for a specific course",
     *     tags={"Courses"},
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         description="slug of the course to retrieve teachers for",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TeacherResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found"
     *     )
     * )
     */
    public function getCourseTeachers(Course $course)
    {
        $teachers = Teacher::query()
            ->select(['id' , 'name' , 'rate' , 'summary' , 'created_at'])
            ->whereRelation( 'courses' , 'courses.id' , $course->id)
            ->with(['media'])
            ->get();

        foreach($teachers as $teacher){
            $coursesIds = Course::query()
                ->whereRelation( 'teachers' , 'teachers.id' , $teacher->id)
                ->pluck('id')
                ->toArray();

            $teacher->reviewsCount = Review::query()
                ->whereIn('model_id' , $coursesIds)
                ->where('model_type' , Course::class)
                ->count();

            $teacher->studentsCount = CourseStudent::query()
                ->whereIn('course_id' , $coursesIds)
                ->count();

            $teacher->coursesCount = count($coursesIds);
        }

        return TeacherResource::collection($teachers);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get courses grouped by year.
     *
     * @OA\Get(
     *     path="/api/courses/grouped-by-year",
     *     summary="Get courses grouped by year",
     *     tags={"Courses"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\AdditionalProperties(
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/CourseResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function groupedByYear(Request $request)
    {
        $courses = Course::with('media')
            ->withCount(['teachers', 'students'])
            ->select(['id', 'name', 'summary', 'price', 'year', 'discount', 'rating', 'created_at'])
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->groupBy('year');

        $groupedCourses = [];
        foreach ($courses as $year => $courseList) {
            $groupedCourses[$year] = $courseList->take(5);
        }

        return response()->json($groupedCourses);
    }
}
