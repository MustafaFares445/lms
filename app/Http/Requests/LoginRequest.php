<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         description="Required when phone is not provided. Must be a valid email address.",
 *         example="user@example.com"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         maxLength=20,
 *         description="Required when email is not provided. Must be a valid phone number.",
 *         example="+1234567890"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         minLength=4,
 *         description="Must be at least 4 characters long.",
 *         example="password"
 *     )
 * )
 */
class LoginRequest extends FormRequest
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
            'email' => ['required_without:phone', 'string', 'email', 'max:255', Rule::exists('users', 'email')],
            'phone' => ['required_without:email', 'string', 'max:20', Rule::exists('users', 'phone')],
            'password' => ['required', 'string', 'min:4'],
        ];
    }
}
