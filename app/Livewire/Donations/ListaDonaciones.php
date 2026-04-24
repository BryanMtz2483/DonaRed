<?php

namespace App\Livewire\Donations;

use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ListaDonaciones extends Component
{
    use WithPagination;

    public string $filterType = '';
    public string $sortBy = 'recent';
    public string $searchTerm = '';
    public ?int $selectedDonationId = null;

    protected $listeners = ['donationCreated' => '$refresh', 'donationUpdated' => '$refresh', 'donationRequested' => '$refresh', 'openDonation' => 'openDonation', 'donationModalClosed' => 'closeDonation'];

    /**
     * Montar el componente
     */
    public function mount()
    {
        // Inicializar filtros
    }

    /**
     * Actualizar filtro por tipo
     */
    public function updateFilter(string $type)
    {
        $this->filterType = $this->filterType === $type ? '' : $type;
        $this->resetPage();
    }

    /**
     * Actualizar ordenamiento
     */
    public function updateSort(string $sortOption)
    {
        $this->sortBy = $sortOption;
        $this->resetPage();
    }

    /**
     * Obtener donaciones filtradas
     */
    public function getDonations()
    {
        $query = Donation::available()
            ->latest()
            ->with('user', 'requests');

        // Filtrar por tipo
        if ($this->filterType) {
            $query->where('tipo', $this->filterType);
        }

        // Buscar por título o descripción
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('titulo', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Ordenamiento
        if ($this->sortBy === 'oldest') {
            $query->oldest();
        }

        return $query->paginate(12);
    }

    /**
     * Obtener tipos disponibles
     */
    public function getTipos(): array
    {
        return ['comida', 'ropa', 'utiles', 'otro'];
    }

    /**
     * Verificar si el usuario ya solicitó
     */
    public function userHasRequested(Donation $donation): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return $donation->requests()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Obtener estado de la solicitud del usuario
     */
    public function getUserRequestStatus(Donation $donation): ?string
    {
        if (!auth()->check()) {
            return null;
        }

        $request = $donation->requests()
            ->where('user_id', auth()->id())
            ->first();

        return $request?->estado;
    }

    /**
     * Abrir donación en modal
     */
    public function openDonation(int $donationId)
    {
        $this->selectedDonationId = $donationId;
    }

    /**
     * Cerrar donación modal
     */
    public function closeDonation()
    {
        $this->selectedDonationId = null;
    }

    public function render()
    {
        return view('livewire.donations.lista-donaciones', [
            'donations' => $this->getDonations(),
            'tipos' => $this->getTipos(),
            'selectedDonation' => $this->selectedDonationId ? Donation::find($this->selectedDonationId) : null,
        ])->with('paginationPath', route('donations.list'));
    }
}
