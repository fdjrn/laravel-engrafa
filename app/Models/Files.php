<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'folder_root',
        'file_root',
        'name',
        'url',
        'is_file',
        'version',
        'size',
        'mime_type',
        'description',
        'comment',
        'created_by'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function files(){
        return $this->hasMany(Bookmark::class, 'created_by', 'id');
    }

}
