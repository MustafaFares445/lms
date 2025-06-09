<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     title="UpdateUserRequest",
 *     description="Request schema for updating user details",
 *     type="object",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the user",
 *         minLength=1,
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="The email of the user",
 *         format="email",
 *         minLength=1,
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="The phone number of the user",
 *         minLength=1,
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="student",
 *         type="object",
 *         description="Student details",
 *         @OA\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the student",
 *             minLength=1,
 *             maxLength=255
 *         ),
 *         @OA\Property(
 *             property="studentNumber",
 *             type="string",
 *             description="The student number",
 *             minLength=1,
 *             maxLength=255
 *         ),
 *         @OA\Property(
 *             property="universityId",
 *             type="integer",
 *             description="The ID of the university",
 *             format="int64"
 *         ),
 *         @OA\Property(
 *             property="gender",
 *             type="string",
 *             description="The gender of the student",
 *             enum={"male", "female", "other"}
 *         ),
 *         @OA\Property(
 *             property="birth",
 *             type="string",
 *             description="The birth date of the student",
 *             format="date"
 *         )
 *     )
 * )
 */
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // User fields
            'name' => ['sometimes', 'string', 'min:1', 'max:255'],
            'email' => [
                'sometimes',
                'string',
                'email',
                'min:1',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id)
            ],
            'phone' => ['sometimes', 'string', 'min:1', 'max:255'],

            // Student nested fields
            'student' => ['sometimes', 'array'],
            'student.name' => ['sometimes', 'string', 'min:1', 'max:255'],
            'student.studentNumber' => ['sometimes', 'string', 'min:1', 'max:255'],
            'student.universityId' => ['sometimes', 'integer', 'exists:universities,id'],
            'student.gender' => ['sometimes', 'string', 'in:male,female,other'],
            'student.birth' => ['sometimes', 'date'],
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'student.universityId.exists' => 'The selected university does not exist.',
            'student.gender.in' => 'Gender must be one of: male, female, other.',
            'student.birth.date' => 'Birth date must be a valid date.',
        ];
    }

    /**
     * Get custom attribute names for validation errors
     */
    public function attributes(): array
    {
        return [
            'student.studentNumber' => 'student number',
            'student.universityId' => 'university',
            'student.gender' => 'gender',
            'student.birth' => 'birth date',
        ];
    }
}