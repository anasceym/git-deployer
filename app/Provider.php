<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'provider_code'
    ];

    /**
     * The relation to repositories.
     *
     */
    public function repositories() {
    	return $this->hasMany('App\Repository');
    }

    public static function bitbucket()
    {
        return self::where('provider_code', 'BITBUCKET')->first();
    }
}
