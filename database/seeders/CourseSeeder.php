<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course1 = Course::create([
            'name' => 'Introduction to Programming',
            'slug' => 'introduction-to-programming',
            'summary' => 'Learn the basics of programming.',
            'description' => 'This course covers the fundamentals of programming using a popular language.',
            'duration' => 10.5,
            'likes' => 100,
            'dislikes' => 5,
            'end_date' => now()->addMonths(3),
            'year' => 1,
            'section' => 1,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'full',
            'price' => 500000,
            'discount' => 15,
            'rating' => 4.5,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the first course
        $course1->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course2 = Course::create([
            'name' => 'Advanced Web Development',
            'slug' => 'advanced-web-development',
            'summary' => 'Take your web development skills to the next level.',
            'description' => 'This course covers advanced topics in web development, including frameworks and best practices.',
            'duration' => 15.0,
            'likes' => 150,
            'dislikes' => 10,
            'end_date' => now()->addMonths(6),
            'year' => 2,
            'section' => 2,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'partial',
            'price' => 700000,
            'discount' => 20,
            'rating' => 4.8,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the second course
        $course2->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course3 = Course::create([
            'name' => 'Data Structures and Algorithms',
            'slug' => 'data-structures-and-algorithms',
            'summary' => 'Master the fundamentals of data structures and algorithms.',
            'description' => 'This course covers essential data structures and algorithms, with a focus on problem-solving.',
            'duration' => 20.0,
            'likes' => 200,
            'dislikes' => 15,
            'end_date' => now()->addMonths(4),
            'year' => 3,
            'section' => 3,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'full',
            'price' => 600000,
            'discount' => 10,
            'rating' => 4.7,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the third course
        $course3->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course4 = Course::create([
            'name' => 'Machine Learning Basics',
            'slug' => 'machine-learning-basics',
            'summary' => 'Get started with machine learning concepts and techniques.',
            'description' => 'This course introduces the basics of machine learning, including supervised and unsupervised learning.',
            'duration' => 25.0,
            'likes' => 250,
            'dislikes' => 20,
            'end_date' => now()->addMonths(5),
            'year' => 4,
            'section' => 4,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'partial',
            'price' => 800000,
            'discount' => 25,
            'rating' => 4.9,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the fourth course
        $course4->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course5 = Course::create([
            'name' => 'Introduction to Artificial Intelligence',
            'slug' => 'introduction-to-artificial-intelligence',
            'summary' => 'Learn the basics of AI and its applications.',
            'description' => 'This course covers the fundamentals of artificial intelligence, including machine learning, neural networks, and natural language processing.',
            'duration' => 30.0,
            'likes' => 300,
            'dislikes' => 25,
            'end_date' => now()->addMonths(7),
            'year' => 5,
            'section' => 5,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'full',
            'price' => 900000,
            'discount' => 30,
            'rating' => 4.95,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the fifth course
        $course5->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course6 = Course::create([
            'name' => 'Introduction to Cybersecurity',
            'slug' => 'introduction-to-cybersecurity',
            'summary' => 'Learn the basics of cybersecurity and how to protect systems.',
            'description' => 'This course covers fundamental cybersecurity concepts, including threat analysis, encryption, and network security.',
            'duration' => 12.0,
            'likes' => 120,
            'dislikes' => 8,
            'end_date' => now()->addMonths(2),
            'year' => 1,
            'section' => 6,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'full',
            'price' => 550000,
            'discount' => 10,
            'rating' => 4.6,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the sixth course
        $course6->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course7 = Course::create([
            'name' => 'Introduction to Cloud Computing',
            'slug' => 'introduction-to-cloud-computing',
            'summary' => 'Learn the basics of cloud computing and its services.',
            'description' => 'This course covers fundamental cloud computing concepts, including cloud models, services, and deployment strategies.',
            'duration' => 14.0,
            'likes' => 130,
            'dislikes' => 7,
            'end_date' => now()->addMonths(3),
            'year' => 2,
            'section' => 7,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'partial',
            'price' => 650000,
            'discount' => 12,
            'rating' => 4.65,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the seventh course
        $course7->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course8 = Course::create([
            'name' => 'Introduction to Blockchain',
            'slug' => 'introduction-to-blockchain',
            'summary' => 'Learn the basics of blockchain technology and its applications.',
            'description' => 'This course covers the fundamentals of blockchain, including decentralized systems, smart contracts, and cryptocurrencies.',
            'duration' => 18.0,
            'likes' => 180,
            'dislikes' => 12,
            'end_date' => now()->addMonths(4),
            'year' => 3,
            'section' => 8,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'full',
            'price' => 750000,
            'discount' => 18,
            'rating' => 4.75,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the eighth course
        $course8->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course9 = Course::create([
            'name' => 'Introduction to DevOps',
            'slug' => 'introduction-to-devops',
            'summary' => 'Learn the basics of DevOps practices and tools.',
            'description' => 'This course covers the fundamentals of DevOps, including continuous integration, continuous delivery, and infrastructure as code.',
            'duration' => 16.0,
            'likes' => 160,
            'dislikes' => 10,
            'end_date' => now()->addMonths(5),
            'year' => 4,
            'section' => 9,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'partial',
            'price' => 680000,
            'discount' => 14,
            'rating' => 4.7,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the ninth course
        $course9->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course10 = Course::create([
            'name' => 'Introduction to Quantum Computing',
            'slug' => 'introduction-to-quantum-computing',
            'summary' => 'Learn the basics of quantum computing and its potential applications.',
            'description' => 'This course covers the fundamentals of quantum computing, including qubits, quantum gates, and quantum algorithms.',
            'duration' => 22.0,
            'likes' => 220,
            'dislikes' => 18,
            'end_date' => now()->addMonths(8),
            'year' => 5,
            'section' => 10,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'full',
            'price' => 850000,
            'discount' => 20,
            'rating' => 4.85,
            'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59))
        ]);

        // Add a fake image to the tenth course
        $course10->addMediaFromUrl('https://picsum.photos/200/300')
                 ->toMediaCollection('courses-images');
    }
}