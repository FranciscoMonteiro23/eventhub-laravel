<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar organizadores (users com role organizer)
        $organizers = User::where('role', 'organizer')->get();
        
        // Buscar categorias
        $musicaId = Category::where('slug', 'musica')->first()->id;
        $desportoId = Category::where('slug', 'desporto')->first()->id;
        $tecnologiaId = Category::where('slug', 'tecnologia')->first()->id;
        $arteId = Category::where('slug', 'arte-cultura')->first()->id;
        $educacaoId = Category::where('slug', 'educacao')->first()->id;
        $negociosId = Category::where('slug', 'negocios')->first()->id;

        $events = [
            [
                'user_id' => $organizers[0]->id,
                'category_id' => $musicaId,
                'title' => 'Festival de Verão 2025',
                'slug' => 'festival-verao-2025',
                'description' => 'O maior festival de música do ano! Com artistas nacionais e internacionais, venha celebrar o verão connosco. 3 dias de música, diversão e boa energia!',
                'location' => 'Parque da Cidade, Porto',
                'start_date' => Carbon::now()->addMonths(2),
                'end_date' => Carbon::now()->addMonths(2)->addDays(3),
                'max_participants' => 5000,
                'price' => 75.00,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'user_id' => $organizers[0]->id,
                'category_id' => $musicaId,
                'title' => 'Concerto Jazz no Rivoli',
                'slug' => 'concerto-jazz-rivoli',
                'description' => 'Uma noite mágica de jazz com os melhores músicos portugueses. Ambiente intimista e sofisticado.',
                'location' => 'Teatro Rivoli, Porto',
                'start_date' => Carbon::now()->addWeeks(3),
                'end_date' => Carbon::now()->addWeeks(3)->addHours(3),
                'max_participants' => 300,
                'price' => 25.00,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'user_id' => $organizers[1]->id,
                'category_id' => $tecnologiaId,
                'title' => 'Web Summit Portugal 2025',
                'slug' => 'web-summit-2025',
                'description' => 'A maior conferência de tecnologia da Europa! Palestras, workshops, networking e as últimas tendências em tech.',
                'location' => 'Altice Arena, Lisboa',
                'start_date' => Carbon::now()->addMonths(4),
                'end_date' => Carbon::now()->addMonths(4)->addDays(4),
                'max_participants' => 10000,
                'price' => 299.00,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'user_id' => $organizers[1]->id,
                'category_id' => $tecnologiaId,
                'title' => 'Workshop: Laravel Avançado',
                'slug' => 'workshop-laravel-avancado',
                'description' => 'Aprenda técnicas avançadas de Laravel com especialistas. Inclui projeto prático e certificado.',
                'location' => 'ISCAP, Porto',
                'start_date' => Carbon::now()->addWeeks(2),
                'end_date' => Carbon::now()->addWeeks(2)->addHours(8),
                'max_participants' => 30,
                'price' => 0.00,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'user_id' => $organizers[0]->id,
                'category_id' => $desportoId,
                'title' => 'Maratona do Porto 2025',
                'slug' => 'maratona-porto-2025',
                'description' => 'Participe na maratona mais bonita de Portugal! Percurso pela cidade do Porto e junto ao rio Douro.',
                'location' => 'Centro do Porto',
                'start_date' => Carbon::now()->addMonths(3),
                'end_date' => Carbon::now()->addMonths(3)->addHours(6),
                'max_participants' => 2000,
                'price' => 35.00,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'user_id' => $organizers[1]->id,
                'category_id' => $arteId,
                'title' => 'Exposição: Arte Contemporânea',
                'slug' => 'exposicao-arte-contemporanea',
                'description' => 'Exposição de artistas portugueses contemporâneos. Entrada gratuita durante todo o mês.',
                'location' => 'Museu Serralves, Porto',
                'start_date' => Carbon::now()->addWeeks(1),
                'end_date' => Carbon::now()->addMonth(),
                'max_participants' => 500,
                'price' => 0.00,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'user_id' => $organizers[0]->id,
                'category_id' => $educacaoId,
                'title' => 'Palestra: Inteligência Artificial',
                'slug' => 'palestra-ia',
                'description' => 'Como a IA está a transformar o mundo? Palestra gratuita com especialistas da área.',
                'location' => 'Universidade do Porto',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(10)->addHours(2),
                'max_participants' => 150,
                'price' => 0.00,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'user_id' => $organizers[1]->id,
                'category_id' => $negociosId,
                'title' => 'Networking Business Night',
                'slug' => 'networking-business',
                'description' => 'Noite de networking para empreendedores e profissionais. Inclui jantar e drinks.',
                'location' => 'Hotel Intercontinental, Porto',
                'start_date' => Carbon::now()->addWeeks(4),
                'end_date' => Carbon::now()->addWeeks(4)->addHours(4),
                'max_participants' => 100,
                'price' => 50.00,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'user_id' => $organizers[0]->id,
                'category_id' => $musicaId,
                'title' => 'Festival Rock in Rio Lisboa',
                'slug' => 'rock-in-rio-lisboa',
                'description' => 'O maior festival de rock do mundo regressa a Lisboa! Headliners internacionais e muito mais.',
                'location' => 'Parque Tejo, Lisboa',
                'start_date' => Carbon::now()->addMonths(5),
                'end_date' => Carbon::now()->addMonths(5)->addDays(2),
                'max_participants' => 80000,
                'price' => 89.00,
                'status' => 'draft',
                'is_featured' => false,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}