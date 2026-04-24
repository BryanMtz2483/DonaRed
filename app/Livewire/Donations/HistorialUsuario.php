<?php

namespace App\Livewire\Donations;

use App\Models\Donation;
use App\Models\DonationRequest;
use Livewire\Component;
use Livewire\WithPagination;

class HistorialUsuario extends Component
{
    use WithPagination;

    public string $tab = 'donaciones'; // 'donaciones' o 'solicitudes'
    public string $filterStatus = '';

    protected $listeners = ['historialUpdated' => '$refresh'];

    /**
     * Cambiar pestaña
     */
    public function changeTab(string $tab)
    {
        $this->tab = $tab;
        $this->resetPage();
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
     * Obtener donaciones del usuario
     */
    public function getDonaciones()
    {
        $query = Donation::where('user_id', auth()->id())
            ->with('requests', 'user')
            ->latest();

        // Filtrar por estado
        if ($this->filterStatus) {
            $query->where('estado', $this->filterStatus);
        }

        return $query->paginate(10);
    }

    /**
     * Obtener solicitudes del usuario
     */
    public function getSolicitudes()
    {
        $query = DonationRequest::where('user_id', auth()->id())
            ->with('donation', 'donation.user')
            ->latest();

        // Filtrar por estado
        if ($this->filterStatus) {
            $query->where('estado', $this->filterStatus);
        }

        return $query->paginate(10);
    }

    /**
     * Obtener estadísticas
     */
    public function getEstadisticas(): array
    {
        $donaciones = Donation::where('user_id', auth()->id())->get();
        $solicitudes = DonationRequest::where('user_id', auth()->id())->get();

        return [
            'donaciones_totales' => $donaciones->count(),
            'donaciones_entregadas' => $donaciones->where('estado', 'entregada')->count(),
            'solicitudes_totales' => $solicitudes->count(),
            'solicitudes_aceptadas' => $solicitudes->where('estado', 'aceptada')->count(),
            'solicitudes_pendientes' => $solicitudes->where('estado', 'pendiente')->count(),
        ];
    }

    /**
     * Cancelar donación
     */
    public function cancelarDonacion(Donation $donation)
    {
        // Validar que sea el dueño
        if ($donation->user_id !== auth()->id()) {
            abort(403);
        }

        // Solo si está disponible y sin solicitudes aceptadas
        if ($donation->estado !== 'disponible' || $donation->requests()->where('estado', 'aceptada')->exists()) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => '✗ No puedes cancelar esta donación',
            ]);
            return;
        }

        $donation->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '✓ Donación cancelada',
        ]);

        $this->dispatch('historialUpdated');
    }

    /**
     * Cancelar solicitud
     */
    public function cancelarSolicitud(DonationRequest $request)
    {
        // Validar que sea el solicitante
        if ($request->user_id !== auth()->id()) {
            abort(403);
        }

        // Solo si está pendiente
        if ($request->estado !== 'pendiente') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => '✗ No puedes cancelar esta solicitud',
            ]);
            return;
        }

        $request->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '✓ Solicitud cancelada',
        ]);

        $this->dispatch('historialUpdated');
    }

    public function render()
    {
        $data = match ($this->tab) {
            'solicitudes' => ['items' => $this->getSolicitudes()],
            default => ['items' => $this->getDonaciones()],
        };

        return view('livewire.donations.historial-usuario', [
            ...$data,
            'tab' => $this->tab,
            'estadisticas' => $this->getEstadisticas(),
        ]);
    }
}
