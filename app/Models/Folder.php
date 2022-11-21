<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function scopeUser($query, $id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
        }

        return $query->where('user_id', $id);
    }
}
