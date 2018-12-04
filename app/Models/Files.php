<?php

namespace App\Models;

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
        'description',
        'comment',
        'created_by'
    ];

    public function owners()
    {
        return $this->belongsToMany('App\User','files','id','created_by','id');
    }

}
