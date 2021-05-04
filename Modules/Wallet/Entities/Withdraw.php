<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'withdraw';
    protected $fillable = ['action', 'withdraw_id', 'userid', 'symbol', 'output_address', 'rate', 'amount', 'fee', 'total', 'txhash','status'];
    
    protected static function newFactory()
    {
        return \Modules\Wallet\Database\factories\WithdrawFactory::new();
    }
}
