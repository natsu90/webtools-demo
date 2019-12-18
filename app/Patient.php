<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends BaseModel
{
	public function creator()
	{
		return $this->belongsTo(User::class);
	}

	public function updater()
	{
		return $this->belongsTo(User::class);
	}
}
