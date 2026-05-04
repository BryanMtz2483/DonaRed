<?php

namespace App\Livewire\Donations;

use App\Models\Donation;
use Livewire\Component;

class EditarDonacion extends Component
{
    public Donation $donation;
    public string $titulo = '';
    public string $descripcion = '';
    public string $tipo = '';

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
     * Inicializar componente con los datos de la donación
     */
    public function mount(Donation $donation)
    {
        $this->donation = $donation;
        $this->titulo = $donation->titulo;
        $this->descripcion = $donation->descripcion;
        $this->tipo = $donation->tipo;
    }

    /**
     * Validación en tiempo real
     */
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    /**
     * Actualizar donación
     */
    public function actualizarDonacion()
    {
        $this->validate();

        $this->donation->update([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
        ]);

        // Emitir evento para cerrar modal y actualizar lista
        $this->dispatch('donationUpdated');
        $this->dispatch('editModalClosed');

        // Notificación
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '¡Donación actualizada exitosamente!',
        ]);
    }

    /**
     * Cancelar edición
     */
    public function cancelar()
    {
        $this->dispatch('editModalClosed');
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
        return view('livewire.donations.editar-donacion', [
            'tipos' => $this->getTipos(),
        ]);
    }
}
