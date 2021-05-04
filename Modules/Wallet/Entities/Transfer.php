<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfers';
    protected $fillable = ['transfer_id','action','userid','recipient_id','amount','fee','total','status'];
    
    protected static function newFactory()
    {
        return \Modules\Wallet\Database\factories\TransferFactory::new();
    }
}
