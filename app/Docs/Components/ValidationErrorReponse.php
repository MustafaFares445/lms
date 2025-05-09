<?php

namespace App\Docs\Components;

/**
 * @OA\Schema(
 *     schema="ValidationErrorResponse",
 *     type="object",
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="The given data was invalid."
 *     ),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         @OA\AdditionalProperties(
 *             type="array",
 *             @OA\Items(type="string")
 *         ),
 *         example={
 *             "email": {"The email field is required."},
 *             "password": {"The password field is required."}
 *         }
 *     )
 * )
 */
class ValidationErrorReponse {}