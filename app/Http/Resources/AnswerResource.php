<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AnswerResource",
 *     type="object",
 *     title="Answer Resource",
 *     description="Answer resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the answer"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="The content of the answer"
 *     ),
 *     @OA\Property(
 *         property="correct",
 *         type="boolean",
 *         description="Indicates if the answer is correct"
 *     )
 * )
 */
class AnswerResource extends JsonResource
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
            'content' => $this->content,
            'correct' => $this->correct,
        ];
    }
}
