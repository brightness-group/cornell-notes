<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class DemoNote extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = ['folder_id', 'title', 'content'];

    protected $casts = [
        'content' => 'object',
    ];

    protected $attributes = [
        'content' => '[{"cue": "", "note": "", "summary": ""}]',
    ];

    protected $appends = ['public_url', 'last_modified'];

    public function folder()
    {
        return $this->belongsTo(DemoFolder::class, 'folder_id');
    }

    public function dirPath()
    {
        return "public/demo/notes/{$this->id}";
    }

    public function getLastModifiedAttribute()
    {
        if ($this->updated_at) {
            return $this->updated_at->diffForHumans();
        }

        return 'Never';
    }

    public function getPublicUrlAttribute()
    {
        if ($this->id) {
            return URL::signedRoute('cornell_notes.public', ['note' => $this->id]);
        } else {
            return 'none';
        }
    }

    public function scopeWelcome($query, $condition = 1)
    {
        return $query->whereWelcome($condition);
    }
}
