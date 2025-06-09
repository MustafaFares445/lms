<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserProgressRequest",
 *     title="UpdateUserProgressRequest",
 *     description="Request schema for updating user progress",
 *     required={"complete"},
 *     @OA\Property(
 *         property="complete",
 *         type="boolean",
 *         description="Indicates if the task is complete",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="lastTime",
 *         type="string",
 *         description="The last recorded time in HH:MM format",
 *         example="12:30",
 *         nullable=true
 *     )
 * )
 */
class UpdateUserProgressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'complete' => ['required' , 'boolean'],
            // 'lastTime' => ['nullable' , 'regex:/^\d{1,2}:\d{2}$/']
        ];
    }
}
