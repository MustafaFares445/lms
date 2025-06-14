<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserProgressResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CourseSessionResource",
 *     type="object",
 *     title="Course Session Resource",
 *     description="Course Session resource representation",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the course session"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the course session"
 *     ),
 *     @OA\Property(
 *         property="note",
 *         type="string",
 *         description="Additional notes for the course session"
 *     ),
 *     @OA\Property(
 *         property="time",
 *         type="string",
 *         description="The time of the course session"
 *     ),
 *     @OA\Property(
 *         property="like",
 *         type="integer",
 *         description="The number of likes for the course session"
 *     ),
 *     @OA\Property(
 *         property="dislike",
 *         type="integer",
 *         description="The number of dislikes for the course session"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="The type of the course session"
 *     ),
 *     @OA\Property(
 *         property="isFree",
 *         type="boolean",
 *         description="Indicates if the course session is free"
 *     ),
 *     @OA\Property(
 *         property="teacher",
 *         ref="#/components/schemas/TeacherResource",
 *         description="The teacher associated with the course session"
 *     ),
 *     @OA\Property(
 *         property="course",
 *         ref="#/components/schemas/CourseResource",
 *         description="The course associated with the course session"
 *     ),
 *     @OA\Property(
 *         property="video",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/MediaResource"),
 *         description="The video media associated with the course session"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         ref="#/components/schemas/MediaResource",
 *         description="The image media associated with the course session"
 *     ),
 *     @OA\Property(
 *         property="currentUserProgress",
 *         ref="#/components/schemas/UserProgressResource",
 *         description="The progress of the current user in the course session"
 *     )
 * )
 */
class CourseSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = Auth::user();

        return [
            'id' => $this->when($this->id , $this->id),
            'title' => $this->when($this->title , $this->title),
            'note' => $this->when($this->note , $this->note),
            'time' => $this->when($this->time , $this->time),
            'like' => $this->when($this->like , $this->like),
            'type' => $this->when($this->type , $this->type),
            'isFree'=> $this->isFree,
            'dislike' => $this->when(Auth::check() && !$user->hasRole('student') , $this->dislike),
            'teacher' => TeacherResource::make($this->whenLoaded('teacher')),
            'course'  => CourseResource::make($this->whenLoaded('course')),
            'currentUserProgress' => UserProgressResource::make($this->whenLoaded('currentUserProgress')),

            'video' =>  MediaResource::make($this->relationLoaded('media') ? $this->getFirstMedia('videos') : null),
            'image' =>  MediaResource::make($this->relationLoaded('media') ? $this->getFirstMedia('images') : null),
        ];
    }
}
