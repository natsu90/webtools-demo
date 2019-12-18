<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class BaseModel extends Model
{
    protected $guarded = [];

    public static function boot() 
    {
        parent::boot();

        // create a event to happen on updating
        static::saving(function($table)  {
            $table->updated_by = Auth::user()->id;
            $table->updated_at = Carbon::now();
        });

        // create a event to happen on saving
        static::creating(function($table)  {
            $table->created_by = Auth::user()->id;
            $table->created_at = Carbon::now();
        });
    }
}