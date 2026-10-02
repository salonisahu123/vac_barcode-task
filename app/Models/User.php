<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
 // Fillable properties for mass assignment
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'password',
        'user_type',
        'role_id',
        'show_password',
        'is_active',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function ticketComments()
    {
        return $this->hasMany(TicketComment::class, 'user_id');
    }
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
}
