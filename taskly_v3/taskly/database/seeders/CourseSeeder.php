<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $users = \App\Models\User::all();
        if ($users->isEmpty()) {
            return;
        }
        $courses = [
            [
                'name' => 'Programación Web',
                'code' => 'PW101',
                'description' => 'Fundamentos de desarrollo web y aplicaciones modernas',
                'color' => '#FF5733',
                'semester' => '2024-1',
                'professor' => 'Dr. Juan Pérez',
                'schedule' => 'Lunes y Miércoles 10:00-12:00',
                'credits' => 4
            ],
            [
                'name' => 'Base de Datos',
                'code' => 'BD201',
                'description' => 'Diseño e implementación de bases de datos relacionales',
                'color' => '#33FF57',
                'semester' => '2024-1',
                'professor' => 'Dra. María García',
                'schedule' => 'Martes y Jueves 14:00-16:00',
                'credits' => 3
            ],
            [
                'name' => 'Inteligencia Artificial',
                'code' => 'IA301',
                'description' => 'Conceptos fundamentales de IA y machine learning',
                'color' => '#3357FF',
                'semester' => '2024-1',
                'professor' => 'Dr. Carlos López',
                'schedule' => 'Viernes 9:00-13:00',
                'credits' => 4
            ]
        ];
        foreach ($users as $user) {
            foreach ($courses as $course) {
                \App\Models\Course::create([
                    'user_id' => $user->id,
                    ...$course
                ]);
            }
        }
    }
} 