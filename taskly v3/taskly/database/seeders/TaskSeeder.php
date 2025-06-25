<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Task;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $courses = Course::all();
        $tags = Tag::all();

        if (!$user || $courses->isEmpty() || $tags->isEmpty()) {
            return;
        }

        $tasks = [
            [
                'title' => 'Desarrollo del Frontend',
                'description' => 'Implementar la interfaz de usuario usando React',
                'priority' => 'high',
                'start_date' => now(),
                'due_date' => now()->addDays(7),
                'status' => 'pending',
                'course_id' => $courses[0]->id,
                'tags' => [$tags[0]->id, $tags[5]->id]
            ],
            [
                'title' => 'Diseño de Base de Datos',
                'description' => 'Crear el esquema de la base de datos',
                'priority' => 'medium',
                'start_date' => now(),
                'due_date' => now()->addDays(5),
                'status' => 'pending',
                'course_id' => $courses[1]->id,
                'tags' => [$tags[1]->id, $tags[5]->id]
            ],
            [
                'title' => 'Implementación de Algoritmos',
                'description' => 'Desarrollar algoritmos de machine learning',
                'priority' => 'high',
                'start_date' => now(),
                'due_date' => now()->addDays(10),
                'status' => 'pending',
                'course_id' => $courses[2]->id,
                'tags' => [$tags[0]->id, $tags[6]->id]
            ]
        ];

        foreach ($tasks as $task) {
            $tags = $task['tags'];
            unset($task['tags']);

            $task = Task::create([
                'user_id' => $user->id,
                ...$task
            ]);

            $task->tags()->attach($tags);
        }
    }
} 