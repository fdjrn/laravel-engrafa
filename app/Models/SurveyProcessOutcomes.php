<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyProcessOutcomes extends Model
{
    //
    public $percentLevel1 = 0;
    public $percentLevel2 = 0;
    public $percentLevel3 = 0;
    public $percentLevel4 = 0;
    public $percentLevel5 = 0;
    public $ratingLevel1 = "";
    public $ratingLevel2 = "";
    public $ratingLevel3 = "";
    public $ratingLevel4 = "";
    public $ratingLevel5 = "";

    protected $appends = ['percentLevel1','percentLevel2','percentLevel3','percentLevel4','percentLevel5','ratingLevel1','ratingLevel2','ratingLevel3','ratingLevel4','ratingLevel5'];

    function getPercentLevel1Attribute(){
    	return $this->percentLevel1;
    }

    function getPercentLevel2Attribute(){
    	return $this->percentLevel2;
    }

    function getPercentLevel3Attribute(){
    	return $this->percentLevel3;
    }

    function getPercentLevel4Attribute(){
    	return $this->percentLevel4;
    }

    function getPercentLevel5Attribute(){
    	return $this->percentLevel5;
    }

    function getRatingLevel1Attribute(){
    	return $this->ratingLevel1;
    }

    function getRatingLevel2Attribute(){
    	return $this->ratingLevel2;
    }

    function getRatingLevel3Attribute(){
    	return $this->ratingLevel3;
    }

    function getRatingLevel4Attribute(){
    	return $this->ratingLevel4;
    }

    function getRatingLevel5Attribute(){
    	return $this->ratingLevel5;
    }
}
