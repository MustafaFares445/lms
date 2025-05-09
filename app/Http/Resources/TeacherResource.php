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
 *         description="The ID of the teacher",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the teacher",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="rate",
 *         type="number",
 *         description="The rate of the teacher",
 *         example=4.5
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="object",
 *         description="The image of the teacher",
 *         @OA\Property(
 *             property="url",
 *             type="string",
 *             description="The URL of the image",
 *             example="https://example.com/images/john-doe.jpg"
 *         )
 *     ),
 *     @OA\Property(
 *         property="createdAt",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the teacher was created",
 *         example="2023-01-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="reviewsCount",
 *         type="integer",
 *         description="The number of reviews the teacher has received",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="coursesCount",
 *         type="integer",
 *         description="The number of courses the teacher has created",
 *         example=5
 *     )
 * )
 */
class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstMedia = $this->whenLoaded('media' , $this->getFirstMedia('courses-images'));

        return [
            'id' => $this->when($this->id , $this->id),
            'name' => $this->when($this->name , $this->name),
            'rate' => $this->rate,
            'image' => MediaResource::make($firstMedia),
            'createdAt' => $this->when($this->created_at , $this->created_at->toDateTimeString()),
            'reviewsCount' =>  $this->whenCounted('reviews'),
            'coursesCount' =>  $this->whenCounted('courses'),
        ];
    }
}
