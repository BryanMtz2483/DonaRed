<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: La donación pertenece a un usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: La donación tiene muchas solicitudes
     */
    public function requests(): HasMany
    {
        return $this->hasMany(DonationRequest::class, 'donation_id');
    }

    /**
     * Scope: Obtener donaciones disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('estado', 'disponible');
    }

    /**
     * Scope: Obtener donaciones por tipo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('tipo', $type);
    }

    /**
     * Scope: Ordenar por fecha más reciente
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Verificar si hay solicitud pendiente
     */
    public function hasPendingRequest(User $user): bool
    {
        return $this->requests()
            ->where('user_id', $user->id)
            ->where('estado', 'pendiente')
            ->exists();
    }

    /**
     * Verificar si la solicitud fue aceptada
     */
    public function isRequestAccepted(User $user): bool
    {
        return $this->requests()
            ->where('user_id', $user->id)
            ->where('estado', 'aceptada')
            ->exists();
    }
}
