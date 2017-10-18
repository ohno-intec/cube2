<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //

    protected $table = 'products';

	public function brand(){
		return $this->belongsTo('App\Brand');
	}

    public function supplier(){
    	return $this->belongsTo(Supplier::class);
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    use SoftDeletes;
    protected $dates = ['deleted_at'];

	protected $fillable = ['id', 'brand_id', 'product_code', 'product_modelnumber', 'product_name', 'product_index', 'supplier_id', 'product_unitprice', 'product_costprice', 'product_stockprice', 'product_retailprice', 'product_newpricestartdate', 'product_newunitprice', 'product_newcostprice', 'product_newstockprice', 'product_newretailprice', 'category_id', 'product_typecode', 'product_stockholdingcode', 'product_rackcode', 'product_warehouseholdingcode', 'product_properstockquantity', 'product_boystockquantity', 'product_boybalance', 'product_showmastersearch', 'product_eancode', 'product_asin', 'user_id', 'product_smileregistration', 'product_targetsmileupdate', 'product_smileregistrationcomment', 'product_status', 'product_stockstatus', 'product_arrivalschedule','product_orderstatus', 'product_arrivaldate', 'product_ordernote', 'product_imageurl', 'product_size', 'product_weight', 'product_material', 'product_packagesize', 'product_packageweight', 'product_waterproof', 'product_color', 'product_batterynumber', 'product_specnote', 'product_function', 'product_includeditem', 'product_warrantyterm', 'product_releasedate', 'product_description', 'created_at', 'updated_at', 'deleted_at' ];

}
