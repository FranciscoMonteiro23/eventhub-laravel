<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use Carbon\Carbon;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obter users participants (role = 'participant')
        $participants = User::where('role', 'participant')->get();
        
        // Obter eventos futuros
        $events = Event::where('start_date', '>', now())->get();

        if ($participants->isEmpty()) {
            $this->command->warn('⚠️  Nenhum participant encontrado! Cria users primeiro.');
            return;
        }

        if ($events->isEmpty()) {
            $this->command->warn('⚠️  Nenhum evento futuro encontrado! Cria eventos primeiro.');
            return;
        }

        $this->command->info('🎫 A criar inscrições de teste...');

        $statuses = ['confirmed', 'confirmed', 'confirmed', 'pending', 'cancelled'];
        $count = 0;

        // Para cada participant, inscrever em 2-5 eventos aleatórios
        foreach ($participants as $participant) {
            $numEvents = rand(2, min(5, $events->count()));
            $selectedEvents = $events->random($numEvents);

            foreach ($selectedEvents as $event) {
                // Verificar se já existe inscrição
                $exists = Registration::where('user_id', $participant->id)
                    ->where('event_id', $event->id)
                    ->exists();

                if (!$exists) {
                    Registration::create([
                        'user_id' => $participant->id,
                        'event_id' => $event->id,
                        'status' => $statuses[array_rand($statuses)],
                        'registration_date' => Carbon::now()->subDays(rand(1, 30)),
                    ]);
                    $count++;
                }
            }
        }

        $this->command->info("✅ {$count} inscrições criadas com sucesso!");
    }
}