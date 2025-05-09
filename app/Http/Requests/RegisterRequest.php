<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"role", "password", "passwordConfirmation"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="User name",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="User email (required if phone is not provided)",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="User phone number (required if email is not provided). Must be a valid phone number starting with '09' and followed by 8 digits.",
 *         maxLength=20,
 *         example="0912345678",
 *         pattern="/^09\d{8}$/"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="User password",
 *         minLength=4
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         description="User role (student or teacher)",
 *         enum={"student", "teacher"}
 *     ),
 *     @OA\Property(
 *         property="student",
 *         type="object",
 *         description="Student details (required if role is student)",
 *         @OA\Property(
 *             property="studentNumber",
 *             type="string",
 *             description="Student number",
 *             maxLength=255
 *         ),
 *         @OA\Property(
 *             property="universityId",
 *             type="integer",
 *             description="University ID (must exist in universities table)"
 *         ),
 *         @OA\Property(
 *             property="gender",
 *             type="string",
 *             description="Student gender",
 *             enum={"male", "female"}
 *         ),
 *         @OA\Property(
 *             property="birth",
 *             type="string",
 *             format="date",
 *             description="Student birth date"
 *         )
 *     ),
 *     @OA\Property(
 *         property="teacher",
 *         type="object",
 *         description="Teacher details (required if role is teacher)",
 *         @OA\Property(
 *             property="summary",
 *             type="string",
 *             description="Teacher summary",
 *             maxLength=1000
 *         ),
 *         @OA\Property(
 *             property="phone",
 *             type="string",
 *             description="Teacher phone number (must be a valid phone number starting with '09' and followed by 8 digits).",
 *             maxLength=20,
 *             example="0912345678",
 *             pattern="/^09\d{8}$/"
 *         ),
 *         @OA\Property(
 *             property="whatsappPhone",
 *             type="string",
 *             description="Teacher WhatsApp phone number",
 *             maxLength=20
 *         )
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         format="binary",
 *         description="User image (optional)",
 *         maxLength=2048
 *     )
 * )
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required_without:phone', 'string', 'email' , 'max:255', Rule::unique('users', 'email')],
            'phone' => ['required_without:email', 'string', 'max:20', 'regex:/^09\d{8}$/', Rule::unique('users', 'phone')],
            'password' => ['required', 'string', 'min:4'],
            'role' => ['required', 'string', Rule::in(['student', 'teacher'])],
            'student' => ['required_if:role,student', 'array'],
            'student.studentNumber' => ['required_if:role,student', 'string', 'max:255'],
            'student.universityId' => ['required_if:role,student', 'integer', Rule::exists('universities', 'id')],
            'student.gender' => ['required_if:role,student', 'string', Rule::in(['male', 'female'])],
            'student.birth' => ['required_if:role,student', 'date'],
            'teacher' => ['required_if:role,teacher', 'array'],
            'teacher.name' => ['required_if:role,teacher', 'string', 'max:100'],
            'teacher.summary' => ['required_if:role,teacher', 'string', 'max:1000'],
            'teacher.phone' => ['required_if:role,teacher', 'string', 'max:20' , 'regex:/^09\d{8}$/'],
            'teacher.whatsappPhone' => ['required_if:role,teacher', 'string', 'max:20'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ];
    }
}
