<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_username',
        'user_name_title',
        'user_fullname',
        'user_password',
        'user_role',
        'province',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'user_password',
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
            'user_password' => 'hashed',
        ];
    }

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    // app/Models/User.php

    public function assignRoleAndSync($role)
    {
        $this->assignRole($role);          // Assign ด้วย Spatie
        $this->user_role = $role;          // Sync ลงฟิลด์ในตาราง users
        $this->save();
    }
    public function provinceData()
    {
        return $this->belongsTo(Provinces::class, 'province', 'pvc_id');
    }
}
