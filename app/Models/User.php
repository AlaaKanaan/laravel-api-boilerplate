<?php

namespace App\Models;

namespace App\Models;

use App\Enums\CacheKeys;
use App\Enums\TokenAbility;
use App\Enums\UserTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'authority',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'authority' => 'array'
    ];

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

    public function isAdmin(): bool
    {
        return in_array(UserTypes::ADMIN, $this['authority']);
    }

    public function getAuthTokens(): array
    {
        // Create access and refresh tokens
        $accessToken = $this->createToken(
            TokenAbility::ACCESS_API->value,
            [TokenAbility::ACCESS_API->value],
            Carbon::now()->addMinutes(config('sanctum.api_ac_expiration'))
        );

        $refreshToken = $this->createToken(
            TokenAbility::REFRESH_TOKEN->value,
            [TokenAbility::REFRESH_TOKEN->value],
            Carbon::now()->addMinutes(config('sanctum.api_rt_expiration'))
        );

        return [
            'token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ];
    }

    public function getOTPIdentifierKey(): string
    {
        return CacheKeys::OTP_KEY->value . $this['id'] . request()->ip();
    }

    public function getOTPIdentifierValue()
    {
        return Cache::get($this->getOTPIdentifierKey());
    }

    public function deleteOTPIdentifierValue(): bool
    {
        return Cache::delete($this->getOTPIdentifierKey());
    }
}
