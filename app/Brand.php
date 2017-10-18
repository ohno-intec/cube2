<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /*
	*
	* The table associated with the model.
	*
	* @var string
	*
    */

	protected $table = 'brands';

	/*
	*
	*The attributes that are mass assignale.
	*
	* @var array
	*
	*/

	public function products() {
		return $this->hasMany(Product::class);
	}

	protected $fillable = ['id', 'brand_code', 'brand_name', 'brand_subname', 'brand_description', 'brand_category', 'brand_logofilename', 'barnd_website', 'brand_country', 'created_at', 'updated_at' ];


	#brand::paginate(30);

}
