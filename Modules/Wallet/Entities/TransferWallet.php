<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferWallet extends Model
{
    use HasFactory;

    protected $table = 'wallet_transfers';

    protected $fillable = ['userid','amount','from_wallet','to_wallet', 'status'];
    
    protected static function newFactory()
    {
        return \Modules\Wallet\Database\factories\TransferWalletFactory::new();
    }
}
