<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Get the list of saved subjects for the authenticated user.
     *
     * @OA\Get(
     *     path="/api/subjects/saved",
     *     summary="Get the list of saved subjects",
     *     tags={"Subjects"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="userSaved",
     *         in="query",
     *         description="Filter by user saved subjects",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of saved subjects",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SubjectResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getSavedSubjects(Request $request)
    {
        $subjects = Subject::with('meida')
            ->when($request->has('userSaved') , fn($q) => $q->whereRelation('userSaved' , 'user_id' , Auth::id()))
            ->get();

        return SubjectResource::collection($subjects);
    }

     /**
     * Add a course to the authenticated user's saved list.
     *
     * @OA\Post(
     *     path="/api/subject/{subject}/save",
     *     summary="Add a course to the user's saved list",
     *     tags={"Subjects"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="subject",
     *         in="path",
     *         description="The ID of the subject to save",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Subject successfully added to saved list"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subject not found"
     *     )
     * )
     */
    public function addToSaved(Subject $subject)
    {
        $subject->userSaved()->create(['user_id' => Auth::id()]);

        return response()->noContent();
    }

    /**
     * Remove a course from the authenticated user's saved list.
     *
     * @OA\Delete(
     *     path="/api/subject/{subject}/unsave",
     *     summary="Remove a course from the user's saved list",
     *     tags={"Subjects"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="subject",
     *         in="path",
     *         description="The ID of the subject to unsave",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Subject successfully removed from saved list"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subject not found"
     *     )
     * )
     */
    public function removeFromSaved(Subject $subject)
    {
        $subject->userSaved()->where(['user_id' => Auth::id()])->delete();

        return response()->noContent();
    }
}
