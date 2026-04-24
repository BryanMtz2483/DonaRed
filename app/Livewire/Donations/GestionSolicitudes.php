<?php

namespace App\Livewire\Donations;

use App\Models\DonationRequest;
use Livewire\Component;
use Livewire\WithPagination;

class GestionSolicitudes extends Component
{
    use WithPagination;

    public int $donationId;
    public string $filterStatus = '';
    public bool $loading = false;

    protected $listeners = ['requestUpdated' => '$refresh'];

    /**
     * Montar componente
     */
    public function mount($donationId = null)
    {
        if ($donationId) {
            $this->donationId = $donationId;
        }
    }

    /**
     * Obtener solicitudes
     */
    public function getRequests()
    {
        $query = DonationRequest::with('user', 'donation')
            ->whereHas('donation', function ($q) {
                $q->where('user_id', auth()->id());
            });

        // Filtrar por estado
        if ($this->filterStatus) {
            $query->where('estado', $this->filterStatus);
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Filtrar por estado
     */
    public function filterByStatus(string $status)
    {
        $this->filterStatus = $this->filterStatus === $status ? '' : $status;
        $this->resetPage();
    }

    /**
     * Aceptar solicitud
     */
    public function aceptarSolicitud(DonationRequest $request)
    {
        $this->loading = true;

        // Validar que sea el dueño de la donación
        if ($request->donation->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        // Rechazar otras solicitudes pendientes de la misma donación
        $request->donation->requests()
            ->where('id', '!=', $request->id)
            ->where('estado', 'pendiente')
            ->update(['estado' => 'rechazada']);

        // Aceptar esta solicitud
        $request->accept();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '✓ Solicitud aceptada. La donación está en proceso.',
        ]);

        $this->dispatch('requestUpdated');
        $this->loading = false;
    }

    /**
     * Rechazar solicitud
     */
    public function rechazarSolicitud(DonationRequest $request)
    {
        $this->loading = true;

        // Validar que sea el dueño de la donación
        if ($request->donation->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $request->reject();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '✓ Solicitud rechazada',
        ]);

        $this->dispatch('requestUpdated');
        $this->loading = false;
    }

    /**
     * Marcar donación como entregada
     */
    public function marcarEntregada(DonationRequest $request)
    {
        $this->loading = true;

        // Validar que sea el dueño
        if ($request->donation->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        // Actualizar donación
        $request->donation->update(['estado' => 'entregada']);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '✓ ¡Donación entregada! Gracias por tu generosidad.',
        ]);

        $this->dispatch('requestUpdated');
        $this->loading = false;
    }

    /**
     * Obtener resumen de solicitudes
     */
    public function getSummary(): array
    {
        $donaciones = \App\Models\Donation::where('user_id', auth()->id())
            ->with('requests')
            ->get();

        return [
            'pendientes' => $donaciones->sum(fn ($d) => $d->requests->where('estado', 'pendiente')->count()),
            'aceptadas' => $donaciones->sum(fn ($d) => $d->requests->where('estado', 'aceptada')->count()),
            'rechazadas' => $donaciones->sum(fn ($d) => $d->requests->where('estado', 'rechazada')->count()),
        ];
    }

    public function render()
    {
        return view('livewire.donations.gestion-solicitudes', [
            'requests' => $this->getRequests(),
            'summary' => $this->getSummary(),
        ]);
    }
}
