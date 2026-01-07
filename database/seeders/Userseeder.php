<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@evento.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '912345678',
            'bio' => 'Administrador do sistema de eventos',
        ]);

        // Organizador 1
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@evento.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'phone' => '913456789',
            'bio' => 'Organizador de eventos musicais e culturais',
        ]);

        // Organizador 2
        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@evento.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'phone' => '914567890',
            'bio' => 'Especialista em eventos corporativos',
        ]);

        // Participante 1
        User::create([
            'name' => 'Pedro Costa',
            'email' => 'pedro@evento.com',
            'password' => Hash::make('password'),
            'role' => 'participant',
            'phone' => '915678901',
            'bio' => 'Entusiasta de eventos tech e networking',
        ]);

        // Participante 2
        User::create([
            'name' => 'Ana Ferreira',
            'email' => 'ana@evento.com',
            'password' => Hash::make('password'),
            'role' => 'participant',
            'phone' => '916789012',
            'bio' => 'Apaixonada por música e cultura',
        ]);

        // Criar mais 5 participantes
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Participante $i",
                'email' => "participante$i@evento.com",
                'password' => Hash::make('password'),
                'role' => 'participant',
            ]);
        }
    }
}