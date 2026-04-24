<?php

namespace App\Livewire\Donations;

use App\Models\Donation;
use Livewire\Component;

class VerDonacion extends Component
{
    public Donation $donation;

    public function closeModal()
    {
        $this->dispatch('donationModalClosed');
    }

    public function render()
    {
        return view('livewire.donations.ver-donacion');
    }
}
