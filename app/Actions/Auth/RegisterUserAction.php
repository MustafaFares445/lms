<?php

namespace App\Actions\Auth;

use App\DTO\UserDTO;
use App\Models\User;
use App\DTO\StudentDTO;
use App\DTO\TeacherDTO;
use App\Traits\HandlesMedia;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Handles user registration with role-specific profile creation
 *
 * This action creates a base user record and then delegates to role-specific
 * handlers (student/teacher) to create associated profiles and media relationships.
 */
class RegisterUserAction
{
    use HandlesMedia;

    /**
     * Register a new user with role-specific profile
     *
     * @param array $data User data including role-specific sub-array
     * @param string $role User role (student/teacher)
     * @return User
     * @throws InvalidArgumentException When invalid role is provided
     */
    public function handle(array $data, $role): User
    {
        return DB::transaction(function() use ($data , $role){

            $user = User::create(
                UserDTO::fromArray(array_merge($data , [
                    'username' => $data['name'] . '_' . random_int(1000 , 9999)
                 ]))->toArray()
            );

            return match ($role) {
                'student' => $this->handleStudent($user, array_merge($data['student'] , [
                    'name' => $data['name']
                ])),
                'teacher' => $this->handleTeacher($user, array_merge($data['teacher'] , [
                    'name' => $data['name']
                ])),
                default => throw new InvalidArgumentException("Invalid role: $role")
            };
        });
    }

    /**
     * Create student profile and link media
     *
     * @param User $user Newly created user instance
     * @param array $studentData Student-specific profile data
     * @return User Updated user instance with student role
     */
    private function handleStudent(User $user, array $studentData): User
    {
        $student = $user->student()->create(StudentDTO::fromArray($studentData)->toArray());
        $user->assignRole('student');

        $media = $user->getFirstMedia('students-images');
        if($media)
            $this->linkExistingMedia($media, $student, 'students-images');

        return $user;
    }

    /**
     * Create teacher profile and link media
     *
     * @param User $user Newly created user instance
     * @param array $teacherData Teacher-specific profile data
     * @return User Updated user instance with teacher role
     */
    private function handleTeacher(User $user, array $teacherData): User
    {
        $teacher = $user->teacher()->create(TeacherDTO::fromArray($teacherData)->toArray());
        $user->assignRole('teacher');

        $media = $user->getFirstMedia('teachers-images');

        if($media)
            $this->linkExistingMedia($media, $teacher, 'teachers-images');

        return $user;
    }
}
