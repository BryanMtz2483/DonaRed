<?php

namespace App\Livewire;

use App\Models\Donation;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedDonation = null;
    public $editingDonation = null;

    protected $listeners = [
        'openDonation' => 'openDonationModal',
        'donationModalClosed' => 'closeDonationModal',
        'editDonation' => 'openEditModal',
        'editModalClosed' => 'closeEditModal',
        'donationUpdated' => '$refresh',
    ];

    public function openDonationModal($donationId)
    {
        $this->selectedDonation = Donation::with('requests', 'user')->find($donationId);
    }

    public function closeDonationModal()
    {
        $this->selectedDonation = null;
    }

    public function openEditModal($donationId)
    {
        $this->editingDonation = Donation::find($donationId);
    }

    public function closeEditModal()
    {
        $this->editingDonation = null;
    }

    public function render()
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

        return view('livewire.dashboard', [
            'myDonations' => $myDonations,
            'exploreDonations' => $exploreDonations,
            'totalActiveDonations' => $totalActiveDonations,
            'deliveredDonations' => $deliveredDonations,
        ]);
    }
}
