<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'google_id',
        'kode_csdm',
        'id_role',
        'no_hp',
        'no_hp_2',
        'id_profile_csdm',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'id';
    protected $table = 'users';

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $incrementing = false;
    public $timestamps = false;


    public function csdm()
    {
        return $this->belongsTo(Csdm::class, 'id_profile_csdm', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    public function kumpul_tugas() {
        return $this->hasMany(PengumpulanTugas::class, 'user_id');

    }

    public function profile() {
        return $this->hasMany(Profile::class, 'user_id');
    }

    public static function get_profile_csdm($id)
    {
        $data = static::with(['role', 'csdm'])
            ->where('id', $id)
            ->first();

        return $data;

    }

    public static function get_all()
    {
        $data = static::with(['role', 'csdm'])
            ->get();

        return $data;

    }

    public static function get_user_with_kumpul_tugas () {
        $data = static::with('kumpul_tugas')->get();

        return $data;
    }

    public static function get_user_csdm () {
        $data = static::whereIn('id_role', [1,2,3])   
                ->get();

        return $data;
    }
}
