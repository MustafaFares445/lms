<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreStudentQuizRequest",
 *     type="object",
 *     required={"quizId", "quizType", "solvedQuestions", "timeTaked"},
 *     @OA\Property(
 *         property="quizId",
 *         type="integer",
 *         description="The ID of the quiz"
 *     ),
 *     @OA\Property(
 *         property="quizType",
 *         type="string",
 *         enum={"quiz", "courseSession"},
 *         description="The type of the quiz"
 *     ),
 *     @OA\Property(
 *         property="solvedQuestions",
 *         type="integer",
 *         description="The number of questions solved"
 *     ),
 *     @OA\Property(
 *         property="timeTaked",
 *         type="string",
 *         format="date-time",
 *         description="The time taken to complete the quiz"
 *     )
 * )
 */
class StoreStudentQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change this to your authorization logic if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quizId' => 'required|integer',
            'quizType' => 'required|string|in:quiz,courseSession',
            'solvedQuestions' => 'required|integer',
            'timeTaked' => 'required|date',
        ];
    }

    public function validated($key = null, $default = null)
    {
        return [
            'solved_questions' => $this->input('solvedQuestions'),
            'time_taked' => $this->input('timeTaked'),
        ];
    }
}