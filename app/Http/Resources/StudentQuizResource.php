<?php

namespace App\Http\Resources;

use App\Models\CourseSession;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="StudentQuizResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the student quiz"
 *     ),
 *     @OA\Property(
 *         property="quiz",
 *         ref="#/components/schemas/QuizResource",
 *         description="The quiz associated with the student quiz"
 *     ),
 *     @OA\Property(
 *         property="courseQuiz",
 *         ref="#/components/schemas/CourseSessionResource",
 *         description="The course session quiz associated with the student quiz"
 *     ),
 *     @OA\Property(
 *         property="solvedQuestions",
 *         type="integer",
 *         description="The number of questions solved by the student"
 *     ),
 *     @OA\Property(
 *         property="totalQuestions",
 *         type="integer",
 *         description="The total number of questions in the quiz"
 *     ),
 *     @OA\Property(
 *         property="timeTaked",
 *         type="string",
 *         format="date-time",
 *         description="The time taken by the student to complete the quiz"
 *     )
 * )
 */
class StudentQuizResource extends JsonResource
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
            'quiz' => $this->quizable_type == Quiz::class ? QuizResource::make($this->whenLoaded('quiz')) : null,
            'courseQuiz' => $this->quizable_type == CourseSession::class  ? CourseSessionResource::make($this->quiz->load('course')) : null,
            'solvedQuestions' => $this->solved_questions,
            'totalQuestions' => $this->total_questions,
            'timeTaked' => $this->time_taked,
        ];
    }
}
