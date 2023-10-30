<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Subject;
use App\Models\Homework;
use App\Models\Classroom;
use Illuminate\Support\Str;
use App\Models\Notification;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(Faker $faker): void
    {
        // users

        // subjects
        $subjectClass = [
            [
                'title' => 'English',
                'subject' => 'English',
            ],
            [
                'title' => 'Math',
                'subject' => 'Math',
            ],
            [
                'title' => 'Art',
                'subject' => 'Art',
            ],
            [
                'title' => 'Science',
                'subject' => 'Science',
            ],
            [
                'title' => 'History',
                'subject' => 'History',
            ],
            [
                'title' => 'Music',
                'subject' => 'Music',
            ],
            [
                'title' => 'Geography',
                'subject' => 'Geography',
            ],
            [
                'title' => 'Physical Education',
                'subject' => 'Physical Education',
            ],
            [
                'title' => 'Drama',
                'subject' => 'Drama',
            ],
            [
                'title' => 'Biology',
                'subject' => 'Biology',
            ],
            [
                'title' => 'Chemistry',
                'subject' => 'Chemistry',
            ],
            [
                'title' => 'Physics',
                'subject' => 'Physics',
            ],
            [
                'title' => 'Information Technology',
                'subject' => 'Information Technology',
            ],
            [
                'title' => 'Social Studies',
                'subject' => 'Social Studies',
            ],
            [
                'title' => 'Philosophy',
                'subject' => 'Philosophy',
            ],
            [
                'title' => 'Graphic Design',
                'subject' => 'Graphic Design',
            ],
            [
                'title' => 'Literature',
                'subject' => 'Literature',
            ],
            [
                'title' => 'Algebra',
                'subject' => 'Algebra',
            ],
            [
                'title' => 'Geometry',
                'subject' => 'Geometry',
            ],
        ];

        $subjects = Subject::all();

        if(count($subjects) == 0){
            for ($i=0; $i < count($subjectClass); $i++) {
                $newSubject = new Subject;
                $newSubject->title = (string)$subjectClass[$i]['title'];
                $newSubject->alias = (string)Str::of($subjectClass[$i]['title'])->slug('-');
                $newSubject->description = (string)$faker->paragraph();
                $newSubject->save();
            }
        }

        $classrooms = Classroom::all();

        // classrooms
        if(count($classrooms) == 0){
            for ($i=0; $i < count($subjects); $i++) {
                $newClass = new Classroom;
                $newClass->title = (string)$subjects[$i]->title;
                $newClass->alias = (string)Str::of($subjects[$i]->title)->slug('-');
                $newClass->teacher_id = (string)$faker->numerify('user########################');
                $newClass->subject = (int)$subjects[$i]->_id;
                $newClass->description = (string)$faker->paragraph();
                $newClass->save();
            }
        }

        // homework
        $homeworks = Homework::all();
        if(count($homeworks) == 0){
            for ($i=0; $i < 100; $i++) {
                $title = $faker->word();
                $newHomework = new Homework;
                $newHomework->title = (string)$title;
                $newHomework->alias = (string)Str::of($title)->slug('-');
                $newHomework->description = (string)$faker->paragraph();
                $s = $faker->randomElement($classrooms);
                $newHomework->classroom_id = (int)$s->_id;
                $newHomework->save();
            }
        }

        // notification
        $notifications = Notification::all();
        if(count($notifications) == 0){
            for ($i=0; $i < 100; $i++) {
                $title = $faker->word();
                $newNotification = new Notification;
                $newNotification->title = (string)$title;
                $newNotification->alias = (string)Str::of($title)->slug('-');
                $newNotification->description = (string)$faker->paragraph();
                $s = $faker->randomElement($classrooms);
                $newNotification->classroom_id = (int)$s->_id;
                $newNotification->save();
            }
        }
    }
}
