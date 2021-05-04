<?php

namespace Modules\Deposit\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 200,
            'data' => parent::toArray($request)
        ];
    }
}
