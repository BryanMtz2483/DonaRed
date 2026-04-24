<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Mis Donaciones Activas (del usuario, máximo 3 más recientes)
        $myDonations = Donation::where('user_id', $user->id)
            ->with('requests')
            ->latest()
            ->take(3)
            ->get();

        // Explorar Catálogo (de otros usuarios, máximo 3 más recientes disponibles)
        $exploreDonations = Donation::where('user_id', '!=', $user->id)
            ->with('requests')
            ->available()
            ->latest()
            ->take(3)
            ->get();

        // Total de donaciones activas (no entregadas)
        $totalActiveDonations = Donation::where('user_id', $user->id)
            ->where('estado', '!=', 'entregada')
            ->count();

        // Total de personas ayudadas (donaciones entregadas)
        $deliveredDonations = Donation::where('user_id', $user->id)
            ->where('estado', 'entregada')
            ->count();

        return view('dashboard', [
            'myDonations' => $myDonations,
            'exploreDonations' => $exploreDonations,
            'totalActiveDonations' => $totalActiveDonations,
            'deliveredDonations' => $deliveredDonations,
        ]);
    }
}
