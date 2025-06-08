<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="QuizResource",
 *     type="object",
 *     title="Quiz Resource",
 *     description="Quiz resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the quiz"
 *     ),
 *     @OA\Property(
 *         property="subject",
 *         ref="#/components/schemas/SubjectResource",
 *         description="The subject associated with the quiz"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the quiz"
 *     ),
 *     @OA\Property(
 *         property="time",
 *         type="integer",
 *         description="The time allocated for the quiz in minutes"
 *     )
 * )
 */
class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => SubjectResource::make($this->whenLoaded('subject')),
            'title' => $this->title,
            'time' => $this->time,
        ];
    }
}
