<?php

namespace App\Livewire\Donations;

use App\Models\Donation;
use Livewire\Component;

class CrearDonacion extends Component
{
    public string $titulo = '';
    public string $descripcion = '';
    public string $tipo = 'comida';
    public bool $showForm = false;

    protected $listeners = ['openForm' => '$refresh'];

    protected array $rules = [
        'titulo' => 'required|string|min:3|max:100',
        'descripcion' => 'required|string|min:10|max:1000',
        'tipo' => 'required|in:comida,ropa,utiles,otro',
    ];

    protected array $messages = [
        'titulo.required' => 'El título es obligatorio',
        'titulo.min' => 'El título debe tener al menos 3 caracteres',
        'titulo.max' => 'El título no puede exceder 100 caracteres',
        'descripcion.required' => 'La descripción es obligatoria',
        'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        'descripcion.max' => 'La descripción no puede exceder 1000 caracteres',
        'tipo.required' => 'Debes seleccionar un tipo',
    ];

    /**
     * Validación en tiempo real
     */
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    /**
     * Guardar donación
     */
    public function guardarDonacion()
    {
        $this->validate();

        $donation = Donation::create([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'user_id' => auth()->id(),
        ]);

        // Emitir evento para actualizar lista
        $this->dispatch('donationCreated')->to(ListaDonaciones::class);

        // Limpiar formulario
        $this->reset(['titulo', 'descripcion', 'tipo', 'showForm']);

        // Notificación
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '¡Donación creada exitosamente!',
        ]);
    }

    /**
     * Cancelar formulario
     */
    public function cancelar()
    {
        $this->reset(['titulo', 'descripcion', 'tipo', 'showForm']);
    }

    /**
     * Obtener tipos disponibles
     */
    public function getTipos(): array
    {
        return [
            'comida' => '🍕 Comida',
            'ropa' => '👕 Ropa',
            'utiles' => '📚 Útiles',
            'otro' => '📦 Otro',
        ];
    }

    public function render()
    {
        return view('livewire.donations.crear-donacion', [
            'tipos' => $this->getTipos(),
        ]);
    }
}
