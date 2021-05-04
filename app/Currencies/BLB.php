<?php
namespace App\Currencies;

use Illuminate\Support\Facades\Cache;

class BLB {
    public $symbol;

    public function __construct() {
        $this->symbol = 'BLB';
    }
    
	public function validator($address) {
        $validate = preg_match('/^0x[0-9A-Fa-f]{40}/i', $address);
        return $validate;
    }

    public function generateAddress($label = '') {
        $get = json_decode(file_get_contents('https://node.billiance.io/apiv1/account/generate'), true);
        $status = isset($get['address']) ? array('status' => true, 'symbol' => $this->symbol, 'address' => $get['address']['address'], 'privateKey' => $get['address']['privateKey']) : array('status' => false);
        return json_encode($status);
    }
    
    public function rate() {
        return 0.1;
    }
    
    public function percent_change() {
        return 0;
    }
    
    public function transactionLink($address) {
        $url = '<a href="https://etherscan.io/address/'.$address.'" target="_blank">'.$address.'</a>';
        return $url;
    }
    
    public function hashLink($tx_id) {
        $tx_id = substr($tx_id, 0, 2) == '0x' ? str_replace('0x', '', $tx_id) : $tx_id;
		$url = 'https://etherscan.io/tx/0x'.$tx_id;
		return $url;
    }
    
    public function addressLink($address) {
		$url = 'https://etherscan.io/address/'.$address;
		return $url;
    }
}
