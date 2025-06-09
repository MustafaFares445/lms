<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @OA\Put(
     *     path="/api/user",
     *     summary="Update the authenticated user",
     *     description="Update the details of the currently authenticated user.",
     *     operationId="updateUser",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User updated successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateUserRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $user->update($request->only(['name', 'email', 'phone']));

        if ($request->has('student') && $user->hasRole('student')) {
            $student = $user->student;
            $studentData = $request->input('student', []);

            $student->update([
                'name' => $studentData['name'] ?? $student->name,
                'university_id' => $studentData['universityId'] ?? $student->university_id,
                'student_number' => $studentData['studentNumber'] ?? $student->student_number,
                'gender' => $studentData['gender'] ?? $student->gender,
                'birth' => $studentData['birth'] ?? $student->birth,
            ]);
        }

        return response()->noContent();
    }
}
