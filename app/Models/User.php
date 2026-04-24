<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Relación: Un usuario tiene muchas donaciones
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Relación: Un usuario tiene muchas solicitudes
     */
    public function donationRequests(): HasMany
    {
        return $this->hasMany(DonationRequest::class);
    }

    /**
     * Contar donaciones realizadas
     */
    public function donationsCount(): int
    {
        return $this->donations()->count();
    }

    /**
     * Contar solicitudes realizadas
     */
    public function requestsCount(): int
    {
        return $this->donationRequests()->count();
    }

    /**
     * Obtener solicitudes recibidas (de sus donaciones)
     */
    public function receivedRequests()
    {
        return DonationRequest::whereIn(
            'donation_id',
            $this->donations()->pluck('id')
        );
    }
}
