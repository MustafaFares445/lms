<?php

namespace App\Http\Resources;

use App\Models\CourseSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CourseResource",
 *     type="object",
 *     title="Course Resource",
 *     description="Course resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the course",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the course",
 *         example="Introduction to Laravel"
 *     ),
 *     @OA\Property(
 *         property="summary",
 *         type="string",
 *         description="A brief summary of the course",
 *         example="Learn the basics of Laravel framework"
 *     ),
 *     @OA\Property(
 *         property="studentsCount",
 *         type="integer",
 *         description="The number of students enrolled in the course",
 *         example=25
 *     ),
 *     @OA\Property(
 *         property="createdAt",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the course was created",
 *         example="2023-10-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="teachers",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TeacherResource"),
 *         description="List of teachers associated with the course"
 *     ),
 *     @OA\Property(
 *         property="primaryImage",
 *         type="object",
 *         ref="#/components/schemas/MediaResource",
 *         description="The primary image for the course"
 *     ),
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/MediaResource"),
 *         description="List of images associated with the course"
 *     ),
 *     @OA\Property(
 *         property="quizezPercent",
 *         type="number",
 *         format="float",
 *         description="The percentage of quizzes completed by the student",
 *         example=75.5
 *     ),
 *     @OA\Property(
 *         property="lecturesPercent",
 *         type="number",
 *         format="float",
 *         description="The percentage of lectures completed by the student",
 *         example=60.0
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="The type of the course",
 *         example="online"
 *     ),
 *     @OA\Property(
 *         property="discount",
 *         type="number",
 *         format="float",
 *         description="The discount applied to the course",
 *         example=10.0
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="The price of the course",
 *         example=99.99
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="number",
 *         format="float",
 *         description="The rating of the course",
 *         example=4.5
 *     ),
 *     @OA\Property(
 *         property="teachersCount",
 *         type="integer",
 *         description="The number of teachers associated with the course",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="year",
 *         type="integer",
 *         description="The year the course was created",
 *         example=2023
 *     ),
 *     @OA\Property(
 *         property="time",
 *         type="integer",
 *         description="The duration of the course in hours",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="quizezCount",
 *         type="integer",
 *         description="The number of quizzes in the course",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="filesCount",
 *         type="integer",
 *         description="The number of files associated with the course",
 *         example=10
 *     )
 * )
 */
class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = Auth::user();
        $studentCondition = Auth::check() && $user->hasRole('student');

        return [
            'id' => $this->when($this->id , $this->id),
            'name' => $this->when($this->name,  $this->name),
            'slug' => $this->when($this->slug , $this->slug),
            'summary' =>  $this->when($this->summary,  $this->summary),
            'studentsCount' =>  $this->whenCounted('students'),
            'type' => $this->when($this->type , $this->type),
            'discount' => $this->when($this->discount , $this->discount),
            'price' => $this->when($this->price , $this->price),
            'rating' => $this->rating,
            'year' => $this->when($this->year , $this->year),
            'time' => $this->when($this->time || $this->time == 0 , $this->time),

            'quizezPercent' => $studentCondition ? $this->whenLoaded('students', function () {
                return $this->students->first()->pivot->quizez_percent;
            }) : null,
            'lecturesPercent' => $studentCondition ? $this->whenLoaded('students', function () {
                return $this->students->first()->pivot->lectures_percent;
            }) : null,

            'createdAt' => $this->when($this->created_at , $this->created_at->toDateTimeString()),
            'teachers' => TeacherResource::collection($this->whenLoaded('teachers')),

            'studentsCount' => $this->when($this->students_count , $this->students_count),
            'teachersCount' => $this->when($this->teachers_count , $this->teachers_count),

            'primaryImage' => MediaResource::make($this->RelationLoaded('media') ? $this->getFirstMedia('images') : null),
            'images' =>  MediaResource::collection($this->whenLoaded('media' , $this->getMedia('images') , [])),

            'courseSessions' => CourseSessionResource::collection($this->whenLoaded('courseSessions')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),

            'teachersCount' => $this->whenCounted('teachers'),
            'studentsCount' => $this->whenCounted('students'),
            'quizezCount'   => $this->whenCounted('quizez'),
            'filesCount'    => $this->when($this->filesCount || $this->filesCount == 0, $this->filesCount),
        ];
    }
}
