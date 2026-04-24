<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos usuarios de prueba
        $users = User::factory(5)->create();

        // Para cada usuario, crear algunas donaciones
        foreach ($users as $user) {
            // Crear entre 2 y 5 donaciones por usuario
            $donationCount = random_int(2, 5);
            $donaciones = Donation::factory($donationCount)->create([
                'user_id' => $user->id,
            ]);

            // Para cada donación, crear algunas solicitudes
            foreach ($donaciones as $donation) {
                // Crear entre 1 y 3 solicitudes
                $requestCount = random_int(1, 3);
                
                // Obtener usuarios aleatorios (diferentes al dueño)
                $otherUsers = $users->where('id', '!=', $user->id)->random(min($requestCount, count($users) - 1));
                
                foreach ($otherUsers as $requester) {
                    // Evitar crear solicitudes duplicadas
                    if ($donation->requests()->where('user_id', $requester->id)->doesntExist()) {
                        DonationRequest::create([
                            'donation_id' => $donation->id,
                            'user_id' => $requester->id,
                            'estado' => collect(['pendiente', 'aceptada', 'rechazada'])->random(),
                        ]);
                    }
                }
            }
        }
    }
}
