<?php

namespace App\Livewire\Donations;

use App\Models\Donation;
use App\Models\DonationRequest;
use Livewire\Component;

class SolicitarDonacion extends Component
{
    public Donation $donation;
    public bool $loading = false;

    /**
     * Solicitar donación
     */
    public function solicitar()
    {
        $this->loading = true;

        // Validar que no sea su propia donación
        if ($this->donation->user_id === auth()->id()) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => '✗ No puedes solicitar tu propia donación',
            ]);
            $this->loading = false;
            return;
        }

        // Validar que la donación siga disponible
        if ($this->donation->estado !== 'disponible') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => '✗ Esta donación ya no está disponible',
            ]);
            $this->loading = false;
            return;
        }

        // Verificar si ya existe solicitud
        $existingRequest = $this->donation->requests()
            ->where('user_id', auth()->id())
            ->first();

        if ($existingRequest) {
            $this->dispatch('notify', [
                'type' => 'warning',
                'message' => '⚠️ Ya has solicitado esta donación',
            ]);
            $this->loading = false;
            return;
        }

        // Crear solicitud
        DonationRequest::create([
            'donation_id' => $this->donation->id,
            'user_id' => auth()->id(),
            'estado' => 'pendiente',
        ]);

        // Actualizar evento
        $this->dispatch('donationRequested')->to(ListaDonaciones::class);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '✓ ¡Solicitud enviada! Espera la respuesta del donador',
        ]);

        $this->loading = false;
    }

    /**
     * Cancelar solicitud
     */
    public function cancelarSolicitud()
    {
        $this->loading = true;

        $request = $this->donation->requests()
            ->where('user_id', auth()->id())
            ->first();

        if ($request && $request->estado === 'pendiente') {
            $request->delete();

            $this->dispatch('donationRequested')->to(ListaDonaciones::class);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => '✓ Solicitud cancelada',
            ]);
        }

        $this->loading = false;
    }

    /**
     * Obtener estado de la solicitud
     */
    public function getRequestStatus(): ?string
    {
        if (!auth()->check()) {
            return null;
        }

        $request = $this->donation->requests()
            ->where('user_id', auth()->id())
            ->first();

        return $request?->estado;
    }

    /**
     * Verificar si el usuario es el dueño
     */
    public function isOwner(): bool
    {
        return $this->donation->user_id === auth()->id();
    }

    public function render()
    {
        return view('livewire.donations.solicitar-donacion', [
            'requestStatus' => $this->getRequestStatus(),
            'isOwner' => $this->isOwner(),
        ]);
    }
}
