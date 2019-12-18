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

        static::saving(function($table)  {
            $table->updated_by = Auth::user()->id;
            $table->updated_at = Carbon::now();
        });

        static::creating(function($table)  {
            $table->created_by = Auth::user()->id;
            $table->created_at = Carbon::now();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}