<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ReviewResource",
 *     type="object",
 *     title="Review Resource",
 *     description="Review resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the review"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="The content of the review"
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="integer",
 *         description="The rating given in the review"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date",
 *         description="The date when the review was created"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/UserResource",
 *         description="The user who created the review"
 *     )
 * )
 */
class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->when($this->id , $this->id),
            'content' => $this->when($this->content , $this->content),
            'rating' => $this->when($this->rating , $this->rating),
            'created_at' => $this->when($this->created_at , $this->created_at->toDateString()),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}