<?php

namespace App\Http\Controllers;

use App\Traits\HandlesMedia;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="LMS Software Api ",
 *     version="1.0.0",
 *     description="API Description"
 * )
 *
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    type="http",
 *    scheme="bearer"
 * )
 */
abstract class Controller
{
    use HandlesMedia;
}
