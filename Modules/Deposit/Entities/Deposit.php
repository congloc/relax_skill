<?php

namespace Modules\Deposit\Entities;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposit';

	protected $fillable = [
		'ip',
		'deposit_id',
		'action',
		'symbol',
		'user_id',
		'amount',
		'fee',
		'rate',
		'total',
		'status',
		'type',
		'author',
		'proof_image',
		'proof_reply',
		'txhash'
	];
}
