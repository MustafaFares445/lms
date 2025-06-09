<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserProgressResource",
 *     type="object",
 *     title="User Progress Resource",
 *     description="User progress resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the user progress record"
 *     ),
 *     @OA\Property(
 *         property="complete",
 *         type="boolean",
 *         description="Indicates if the user has completed the progress"
 *     ),
 *     @OA\Property(
 *         property="lastTime",
 *         type="string",
 *         format="date-time",
 *         description="The last time the user updated the progress"
 *     )
 * )
 */
class UserProgressResource extends JsonResource
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
            'complete' => $this->complete,
            'lastTime' => $this->last_time
        ];
    }
}
