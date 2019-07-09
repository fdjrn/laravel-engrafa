<?php
/**
 * Created by PhpStorm.
 * User: fadjrin
 * Date: 18/12/18
 * Time: 10:43
 */

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmarks';

    protected $fillable = [
        'file', 'user','created_by'
    ];


    public function files() {
        return $this->belongsTo(Files::class,'file','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user','id');
    }

}