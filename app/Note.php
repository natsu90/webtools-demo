<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends BaseModel
{
    public function patient()
    {
    	return $this->belongsTo(Patient::class);
    }
}
