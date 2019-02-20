<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionerCategory extends Model
{
    protected $table = 'quisioner_categories';

    public static function getQuestionerCategoryAll()
    {
      $data = DB::table('quisioner_categories')
            ->select('quisioner_categories.*')
            ->get();
      
      return $data;
    }
}
