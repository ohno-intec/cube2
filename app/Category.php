<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $table = 'categories';

	protected $fillable = ['id', 'category_type', 'category_code', 'category_name', 'category_detail', 'created_at', 'updated_at' ];

	public function products(){

		return $this->hasMany(Product::class);

	}

}
