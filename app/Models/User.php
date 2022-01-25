<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'academy_id',
        'name',
        'last_name',
        'email',
        'password',
        'dni',
        'gender',
        'active',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function academy(){
        return $this->belongsTo(Academy::class);
    }
    public function scopeIsDisabled($query,$state)
    {
        if ($state) {
            return $query;
        }
        return $query->where('users.active',true);
    }
    public function scopeEmail($query,$email)
    {
        if ($email) {
            return $query->where('users.email','ILIKE', "%$email%");
        }
    }
    public function scopeDni($query,$dni)
    {
        if ($dni) {
            return $query->where('users.dni','ILIKE', "$dni%");
        }
    }
    public function scopeYourAcademy($query)
    {
        if (!auth()->user()->hasRole(1) && !auth()->user()->hasRole(2)) {
            return $query->where('users.academy_id', auth()->user()->academy_id);
        }
    }

    // JWT
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
