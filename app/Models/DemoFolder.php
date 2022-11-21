<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoFolder extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function notes()
    {
        return $this->hasMany(DemoNote::class, 'folder_id');
    }

    public function scopeWelcome($query, $condition = 1)
    {
        return $query->whereWelcome($condition);
    }
}
