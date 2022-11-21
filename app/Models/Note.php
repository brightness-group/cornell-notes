<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use App\Utils\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Note extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = ['folder_id', 'title', 'content'];

    protected $appends = ['public_url', 'formatted_size', 'last_modified'];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function dirPath()
    {
        return "public/user/{$this->user_id}/notes/{$this->id}";
    }

    public function scopeUser($query, $id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
        }

        return $query->where('user_id', $id);
    }

    public function getPublicUrlAttribute()
    {
        return URL::signedRoute('cornell_notes.public', ['note' => $this->id]);
    }

    public function getSizeAttribute()
    {
        $mediaSize = Media::folderSize($this->dirPath(), false);
        $contentSize = self::contentSize($this->id);

        return $mediaSize + $contentSize;
    }

    public function getFormattedSizeAttribute()
    {
        return Media::unitConverter($this->size);
    }

    public function getLastModifiedAttribute()
    {
        if ($this->updated_at) {
            return $this->updated_at->diffForHumans();
        }

        return 'Never';
    }

    public static function contentSize($id)
    {
        return;
    }
}
