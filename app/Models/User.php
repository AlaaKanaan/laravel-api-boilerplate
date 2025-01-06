<?php

namespace App\Models;

namespace App\Models;

use App\Enums\TokenAbility;
use App\Enums\UserTypes;
use App\Notifications\VerifyEmailOtp;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'role',
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
        return $this->role === UserTypes::ADMIN;
    }


    public function sendEmailVerificationNotification(): void
    {
        if (config('app.must_confirm_email')) {
            $this->notify(new VerifyEmailOtp());
        }
    }

    public function hasVerifiedEmail(): bool
    {
        if (config('app.must_confirm_email')) {
            return parent::hasVerifiedEmail();
        }
        return true;
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

    public function getVerifyToken(): array
    {

        // Identify and delete the old refresh token
        $this->tokens()->where('name', TokenAbility::VERIFY_TOKEN->value)->delete();
        // Create access and refresh tokens
        $verify_token = $this->createToken(
            TokenAbility::VERIFY_TOKEN->value,
            [TokenAbility::VERIFY_TOKEN->value],
            Carbon::now()->addMinutes(config('sanctum.api_rt_expiration'))
        );

        return [
            'verify_token' => $verify_token->plainTextToken
        ];
    }
}
