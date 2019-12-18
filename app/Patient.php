<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends BaseModel
{
	public function notes()
	{
		return $this->hasMany(Note::class);
	}
}
