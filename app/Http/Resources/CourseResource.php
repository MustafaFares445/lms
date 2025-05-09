<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $firstMedia = $this->whenLoaded('media' , $this->getFirstMedia('courses-images'));

        $studentCondition = Auth::check() && Auth::user()->hasRole('student');

        return [
            'id' => $this->when($this->id , $this->id),
            'name' => $this->when($this->name,  $this->name),
            'summary' =>  $this->when($this->summary,  $this->summary),
            'studentsCount' =>  $this->whenCounted('students'),
            'type' => $this->when($this->type , $this->type),


            'quizezPercent' => $studentCondition ? $this->whenLoaded('students', function () {
                return $this->students->first()->pivot->quizez_percent;
            }) : 0,
            'lecturesPercent' => $studentCondition ? $this->whenLoaded('students', function () {
                return $this->students->first()->pivot->lectures_percent;
            }) : 0,

            'createdAt' => $this->when($this->created_at , $this->created_at->toDateTimeString()),
            'teachers' => TeacherResource::collection($this->whenLoaded('teachers')),
            'primaryImage' => MediaResource::make($firstMedia),
            'images' => $this->whenLoaded('media', function () use ($firstMedia) {
                $mediaCollection = $this->media;

                if ($firstMedia) {
                    $mediaCollection = $mediaCollection->reject(function ($media) use ($firstMedia) {
                        return $media->id === $firstMedia->id;
                    });
                }

                return MediaResource::collection($mediaCollection);
            }),
        ];
    }
}
