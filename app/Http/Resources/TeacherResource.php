<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TeacherResource",
 *     type="object",
 *     title="Teacher Resource",
 *     description="Teacher resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the teacher"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the teacher"
 *     ),
 *     @OA\Property(
 *         property="rate",
 *         type="number",
 *         format="float",
 *         description="The rating of the teacher"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="object",
 *         description="The image of the teacher",
 *         ref="#/components/schemas/MediaResource"
 *     ),
 *     @OA\Property(
 *         property="createdAt",
 *         type="string",
 *         format="date",
 *         description="The date when the teacher was created"
 *     ),
 *     @OA\Property(
 *         property="reviewsCount",
 *         type="integer",
 *         description="The number of reviews for the teacher"
 *     ),
 *     @OA\Property(
 *         property="studentsCount",
 *         type="integer",
 *         description="The number of students for the teacher"
 *     ),
 *     @OA\Property(
 *         property="coursesCount",
 *         type="integer",
 *         description="The number of courses for the teacher"
 *     )
 * )
 */
class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->when($this->name , $this->name),
            'rate' => $this->rate,
            'image' => MediaResource::make($this->relationLoaded('media') ? $this->getFirstMedia('images') : null),
            'createdAt' => $this->when($this->created_at , $this->created_at->toDateString()),
            'reviewsCount' => $this->when($this->reviewsCount || $this->reviewsCount == 0 , $this->reviewsCount),
            'studentsCount' => $this->when($this->studentsCount || $this->studentsCount == 0, $this->studentsCount),
            'coursesCount' => $this->when($this->coursesCount  || $this->coursesCount  == 0, $this->coursesCount),
        ];
    }
}
