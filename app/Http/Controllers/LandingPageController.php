<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationRequest;

class LandingPageController extends Controller
{
    public function index()
    {
        // Estadísticas para la landing page
        $totalDonations = Donation::count();
        $totalRequests = DonationRequest::count();
        $activeDonations = Donation::where('estado', 'disponible')->count();
        
        // Donaciones destacadas (últimas 6)
        $featuredDonations = Donation::latest()
            ->limit(6)
            ->get();
        
        // Estadísticas de impacto
        $stats = [
            [
                'number' => $totalDonations,
                'label' => 'Donaciones Publicadas',
                'icon' => '📦',
            ],
            [
                'number' => $totalRequests,
                'label' => 'Personas Ayudadas',
                'icon' => '🤝',
            ],
            [
                'number' => $activeDonations,
                'label' => 'Artículos Disponibles',
                'icon' => '✨',
            ],
            [
                'number' => rand(100, 500), // Placeholder
                'label' => 'Vidas Transformadas',
                'icon' => '❤️',
            ],
        ];
        
        // Testimonos mock (en producción, podrían ser de base de datos)
        $testimonials = [
            [
                'name' => 'María García',
                'story' => 'Gracias a DonaRed conseguí lo que necesitaba para mi hogar. La comunidad fue increíblemente solidaria.',
                'avatar' => '👩‍🦱',
                'role' => 'Receptora de Ayuda',
            ],
            [
                'name' => 'Carlos López',
                'story' => 'Donar a través de esta plataforma me hizo sentir que estoy haciendo una diferencia real en mi comunidad.',
                'avatar' => '👨‍💼',
                'role' => 'Donante Activo',
            ],
            [
                'name' => 'Ana Rodríguez',
                'story' => 'Fue tan fácil encontrar exactamente lo que necesitaba. ¡DonaRed es una bendición!',
                'avatar' => '👩‍🎓',
                'role' => 'Beneficiaria',
            ],
        ];
        
        return view('landing', [
            'stats' => $stats,
            'testimonials' => $testimonials,
            'featuredDonations' => $featuredDonations,
        ]);
    }
}
