<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'gender', 'birth_date', 'address',
        'points', 'tier', 'role_id', 'avatar'
    ];

    public function role() {
        return $this->belongsTo(Role::class,'role_id');
    }

}
