<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulos = [
            'Kit de comida lista para llevar',
            'Ropa de invierno en buen estado',
            'Libros educativos para niños',
            'Útiles escolares varios',
            'Electrodoméstico funcionando',
            'Muebles para hogar',
            'Juguetes para niños',
            'Mochilas y accesorios',
            'Botellas reutilizables',
            'Artículos de higiene personal',
        ];

        $descripciones = [
            'Se encuentra en excelente estado y listo para usar.',
            'Poco uso, perfecto para quien lo necesite.',
            'Completamente funcional, sin defectos.',
            'Como nuevo, se regala por cambio de casa.',
            'Muy bien cuidado, se regala por no uso.',
            'Donado para ayudar a la comunidad.',
            'Se regala por espacios en el hogar.',
            'Totalmente disponible para quien lo quiera.',
            'En perfectas condiciones de uso y limpieza.',
            'Donación de buena voluntad para necesitados.',
        ];

        return [
            'titulo' => $this->faker->randomElement($titulos),
            'descripcion' => $this->faker->randomElement($descripciones),
            'tipo' => $this->faker->randomElement(['comida', 'ropa', 'utiles', 'otro']),
            'estado' => $this->faker->randomElement(['disponible', 'en_proceso', 'entregada']),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? \App\Models\User::factory(),
        ];
    }
}
