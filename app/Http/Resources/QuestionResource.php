<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="QuestionResource",
 *     type="object",
 *     title="Question Resource",
 *     description="Question resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the question"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the question"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="The type of the question"
 *     ),
 *     @OA\Property(
 *         property="media",
 *         ref="#/components/schemas/MediaResource",
 *         description="The media associated with the question"
 *     ),
 *     @OA\Property(
 *         property="answers",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/AnswerResource"),
 *         description="The answers associated with the question"
 *     ),
 *     @OA\Property(
 *         property="note",
 *         type="string",
 *         description="Additional notes or comments for the question"
 *     )
 * )
 */
class QuestionResource extends JsonResource
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
            'title' => $this->title,
            'type' => $this->type,
            'media' => MediaResource::make($this->relationLoaded('media') ? $this->media()->first() : null),
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),
            'note' => $this->note,
        ];
    }
}
