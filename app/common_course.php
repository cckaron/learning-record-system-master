<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class common_course extends Model
{
    public $incrementing = false;

    protected  $fillable = ['id', 'name', 'year','semester','start_date', 'end_date'];

    public function course(){
        return $this->hasMany('App\Course', 'common_courses_id', 'id');
    }
}
