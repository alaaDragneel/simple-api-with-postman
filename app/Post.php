<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = ['title', 'slug', 'body'];

	public function setTitleAttribute($title)
	{
		$this->attributes['title'] = $title;
		$this->attributes['slug'] = str_slug($title);
	}
}
