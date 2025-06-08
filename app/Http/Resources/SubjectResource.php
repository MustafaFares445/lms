<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SubjectResource",
 *     type="object",
 *     title="Subject Resource",
 *     description="Subject resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the subject"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the subject"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the subject"
 *     ),
 *     @OA\Property(
 *         property="year",
 *         type="integer",
 *         description="The academic year of the subject"
 *     ),
 *     @OA\Property(
 *         property="semester",
 *         type="integer",
 *         description="The semester in which the subject is taught"
 *     ),
 *     @OA\Property(
 *         property="university",
 *         type="object",
 *         description="The university associated with the subject",
 *         nullable=true
 *     )
 * )
 */
class SubjectResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'year' => $this->year,
            'semester' => $this->semester,
            'university' => $this->whenLoaded('university'),
        ];
    }
}
