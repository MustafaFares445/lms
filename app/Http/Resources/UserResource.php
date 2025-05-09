<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     title="User Resource",
 *     description="User resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The user's unique identifier",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The user's name",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="The user's email address",
 *         example="john.doe@example.com"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="The user's phone number",
 *         example="+1234567890"
 *     ),
 *     @OA\Property(
 *         property="emailVerifiedAt",
 *         type="string",
 *         format="date-time",
 *         description="The timestamp when the email was verified",
 *         example="2023-01-01"
 *     ),
 *     @OA\Property(
 *         property="phoneVerifiedAt",
 *         type="string",
 *         format="date-time",
 *         description="The timestamp when the phone was verified",
 *         example="2023-01-01"
 *     ),
 *     @OA\Property(
 *         property="createdAt",
 *         type="string",
 *         format="date-time",
 *         description="The timestamp when the user was created",
 *         example="2023-01-01"
 *     ),
 *     @OA\Property(
 *         property="updatedAt",
 *         type="string",
 *         format="date-time",
 *         description="The timestamp when the user was last updated",
 *         example="2023-01-01"
 *     ),
 *     @OA\Property(
 *         property="isBanned",
 *                 property="student",
 *         type="object",
 *         description="The student details if the user is a student"
 *     ),
 *     @OA\Property(
 *         property="teacher",
 *         type="object",
 *         description="The teacher details if the user is a teacher"
 *     )
 * )
 */
class UserResource extends JsonResource
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
            'name' => $this->when($this->name , $this->name),
            'email' => $this->when($this->email , $this->email),
            'phone' => $this->when($this->phone , $this->phone),
            'emailVerifiedAt' => $this->when($this->email_verified_at , $this->email_verified_at),
            'phoneVerifiedAt' => $this->when($this->phone_verified_at , $this->phone_verified_at),
            'createdAt' => $this->when($this->created_at , $this->created_at->toDateTimeString()),
            'updatedAt' => $this->when($this->updated_at , $this->updated_at->toDateTimeString()),
            'isBanned' => $this->when($this->is_banned , $this->is_banned),
            'roles' => $this->whenLoaded('roles' , $this->getRoleNames()),
            'student' => $this->whenLoaded('student'),
            'teacher' => $this->whenLoaded('teacher'),
        ];
    }
}