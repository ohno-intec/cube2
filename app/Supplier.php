<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $table = 'suppliers';

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }

	protected $fillable = ['id', 'supplier_code', 'supplier_name', 'supplier_index', 'supplier_zipcode', 'supplier_address1', 'supplier_address2', 'supplier_address3', 'supplier_tel', 'supplier_fax', 'supplier_email', 'supplier_salerep', 'user_id', 'supplier_industrytype	', 'supplier_businesstype', 'supplier_information', 'created_at', 'updated_at', 'deleted_at' ];

}
