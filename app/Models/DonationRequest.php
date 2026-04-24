<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationRequest extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'donation_id',
        'user_id',
        'estado',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: La solicitud pertenece a una donación
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }

    /**
     * Relación: La solicitud pertenece a un usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Solicitudes pendientes
     */
    public function scopePending($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope: Solicitudes aceptadas
     */
    public function scopeAccepted($query)
    {
        return $query->where('estado', 'aceptada');
    }

    /**
     * Scope: Solicitudes rechazadas
     */
    public function scopeRejected($query)
    {
        return $query->where('estado', 'rechazada');
    }

    /**
     * Aceptar solicitud
     */
    public function accept(): void
    {
        $this->update(['estado' => 'aceptada']);
        $this->donation->update(['estado' => 'en_proceso']);
    }

    /**
     * Rechazar solicitud
     */
    public function reject(): void
    {
        $this->update(['estado' => 'rechazada']);
    }
}
