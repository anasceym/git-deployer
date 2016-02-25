<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'branch', 'remote', 'local_path',
    ];


    /** 
     * Relation to providers.
     *
     */
    public function provider() {
    	return $this->belongsTo('App\Provider');
    }
}
