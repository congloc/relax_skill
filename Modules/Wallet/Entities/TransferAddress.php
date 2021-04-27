<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferAddress extends Model
{
    use HasFactory;

    protected $table = 'wallet_address';
    protected $fillable = ['userid','sympol','input_address','destination_tag'];
    
    protected static function newFactory()
    {
        return \Modules\Wallet\Database\factories\TransferAddressFactory::new();
    }
}
