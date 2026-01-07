<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Música',
                'slug' => 'musica',
                'description' => 'Concertos, festivais e eventos musicais',
                'color' => '#e74c3c',
                'icon' => 'music'
            ],
            [
                'name' => 'Desporto',
                'slug' => 'desporto',
                'description' => 'Jogos, competições e atividades desportivas',
                'color' => '#3498db',
                'icon' => 'trophy'
            ],
            [
                'name' => 'Tecnologia',
                'slug' => 'tecnologia',
                'description' => 'Conferências, workshops e eventos tech',
                'color' => '#9b59b6',
                'icon' => 'laptop'
            ],
            [
                'name' => 'Arte e Cultura',
                'slug' => 'arte-cultura',
                'description' => 'Exposições, teatro e eventos culturais',
                'color' => '#f39c12',
                'icon' => 'palette'
            ],
            [
                'name' => 'Educação',
                'slug' => 'educacao',
                'description' => 'Cursos, palestras e formações',
                'color' => '#27ae60',
                'icon' => 'book'
            ],
            [
                'name' => 'Negócios',
                'slug' => 'negocios',
                'description' => 'Networking, conferências empresariais',
                'color' => '#34495e',
                'icon' => 'briefcase'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}