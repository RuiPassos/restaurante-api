<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar Utilizadores (Um Proprietário e uma Cliente)
        $admin = User::create([
            'name' => 'Proprietário',
            'email' => 'admin@restaurante.pt',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '912345678',
        ]);

        $cliente = User::create([
            'name' => 'Maria Oliveira',
            'email' => 'maria@email.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
            'phone' => '961234567',
        ]);

        // 2. Criar Categorias
        $entradas = Category::create(['name' => 'Entradas', 'description' => 'Para começar melhor do chef']);
        $principais = Category::create(['name' => 'Pratos Principais', 'description' => 'O prato principal']);
        $sobremesas = Category::create(['name' => 'Sobremesas', 'description' => 'Doce final']);

        // 3. Criar Pratos associados às categorias
        $caldo = $entradas->dishes()->create(['name' => 'Caldo Verde', 'price' => 5.50, 'allergens' => 'lactose']);
        $rissois = $entradas->dishes()->create(['name' => 'Rissóis de Camarão', 'price' => 7.00, 'allergens' => 'glúten, marisco']);
        
        $bacalhau = $principais->dishes()->create(['name' => 'Bacalhau à Brás', 'price' => 18.50, 'allergens' => 'ovos, glúten']);
        $bife = $principais->dishes()->create(['name' => 'Bife na Pedra', 'price' => 22.00, 'allergens' => '']);
        
        $mousse = $sobremesas->dishes()->create(['name' => 'Mousse de Chocolate', 'price' => 4.50, 'allergens' => 'ovos, lactose']);

        // 4. Criar uma Reserva de exemplo para a Maria
        $reserva = Reservation::create([
            'user_id' => $cliente->id,
            'reserved_at' => now()->addDays(3),
            'guests' => 2,
            'notes' => 'Mesa perto da janela, se possível.',
            'status' => 'pending',
        ]);

        // 5. Adicionar os pratos à reserva da Maria (com as respetivas quantidades)
        $reserva->dishes()->attach([
            $caldo->id => ['quantity' => 2],
            $bacalhau->id => ['quantity' => 2]
        ]);
    }
}
