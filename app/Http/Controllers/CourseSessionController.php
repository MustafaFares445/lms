<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseSession;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\CourseSessionResource;
use App\Http\Requests\UpdateUserProgressRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CourseSessionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/courses/sessions/{courseSession}/quiz-questions",
     *     summary="Get quiz questions for a specific course session",
     *     description="Retrieve all quiz questions associated with a specific course session, including media and answers.",
     *     operationId="getQuizQuestions",
     *     tags={"Course Sessions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="courseSession",
     *         in="path",
     *         description="ID of the course session",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/QuestionResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course session not found"
     *     )
     * )
     */
    public function getQuizQuestions(CourseSession $courseSession)
    {
        $questions = $courseSession->questions()
            ->with(['media' , 'answers'])
            ->get();

        return QuestionResource::collection($questions);
    }

    /**
     * Add a course to the authenticated user's saved list.
     *
     * @OA\Post(
     *     path="/api/courses/sessions/{courseSession}/save",
     *     summary="Add a course to the user's saved list",
     *     tags={"Course Sessions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="courseSession",
     *         in="path",
     *         description="The ID of the course to save",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Course successfully added to saved list"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found"
     *     )
     * )
     */
    public function addToSaved(CourseSession $courseSession)
    {
        $courseSession->userSaved()->create(['user_id' => Auth::id()]);

        return response()->noContent();
    }

    /**
     * Remove a course from the authenticated user's saved list.
     *
     * @OA\Delete(
     *     path="/api/courses/sessions/{courseSession}/unsave",
     *     summary="Remove a course from the user's saved list",
     *     tags={"Course Sessions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="courseSession",
     *         in="path",
     *         description="The ID of the course to unsave",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Course successfully removed from saved list"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found"
     *     )
     * )
     */
    public function removeFromSaved(CourseSession $courseSession)
    {
        $courseSession->userSaved()->where(['user_id' => Auth::id()])->delete();

        return response()->noContent();
    }

    /**
     * @OA\PUT(
     *     path="/api/courses/sessions/{courseSession}/update-progress",
     *     summary="Update user progress for a course session",
     *     description="Update the progress of the authenticated user for a specific course session.",
     *     operationId="updateUserProgress",
     *     tags={"Course Sessions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="courseSession",
     *         in="path",
     *         description="ID of the course session",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"complete", "lastTime"},
     *             @OA\Property(property="complete", type="boolean", example=true),
     *             @OA\Property(property="lastTime", type="integer", example=120),
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Progress successfully updated"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course session not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateUserProgress(CourseSession $courseSession , UpdateUserProgressRequest $request)
    {
        $courseSession->userProgress()
            ->updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'complete' => (bool) $request->input('complete'),
                    'last_time' => $request->input('lastTime')
                ]
            );

        return response()->noContent();
    }


    /**
     * @OA\Get(
     *     path="/api/courses/sessions/{courseSession}",
     *     summary="Get details of a specific course session",
     *     description="Retrieve details of a specific course session, including media and user progress if authenticated.",
     *     operationId="getCourseSession",
     *     tags={"Course Sessions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="courseSession",
     *         in="path",
     *         description="ID of the course session",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CourseSessionResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course session not found"
     *     )
     * )
     */
    public function show(CourseSession $courseSession)
    {
        return CourseSessionResource::make(
            $courseSession->load(['media' , 'currentUserProgress'])
        );
    }

    /**
     * @OA\Post(
     *     path="/api/courses/sessions/{courseSession}/download/{media}",
     *     summary="Download the video associated with a specific course session",
     *     description="Download the video file associated with a specific course session.",
     *     operationId="downloadCourseSessionVideo",
     *     tags={"Course Sessions"},
     *     @OA\Parameter(
     *         name="courseSession",
     *         in="path",
     *         description="ID of the course session",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="media",
     *         in="path",
     *         description="ID of the media file to download",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/octet-stream",
     *             @OA\Schema(
     *                 type="string",
     *                 format="binary"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course session or video not found"
     *     )
     * )
     */
    public function download(CourseSession $courseSession, Media $media)
    {
        // Check if the media is linked to the course session
        if ($courseSession->media->contains($media)) {
            return $media->download();
        }

        // If the media is not linked to the course session, return a 404 response
        return response()->json(['error' => 'Media not found for this course session'], 404);
    }
}
