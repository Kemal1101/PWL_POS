<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'nama', 'password'];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];
    //relasi
    public function level(): BelongsTo{
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    //mendapatkan nama role
    public function getRoleName(): string{
        return $this->level->level_kode;
    }
    //cek apakah user memiliki role tertentu
    public function hasRole($role): bool{
        return $this->level->level_kode == $role;
    }

}
