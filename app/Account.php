<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
    *	モデルと関連しているテーブル
    *
    *	@var string
    */

    protected $table = 'accounts';

    public function user(){
    	return $this->belongsTo(User::class);
    }

}
