<?php
namespace App\Currencies;

use App\Coinpayments;
use Illuminate\Support\Facades\Cache;

class USDT {
    public $symbol;

    public function __construct() {
        $this->coinpayments = new Coinpayments();
        $this->symbol = 'USDT.ERC20';
    }

    public function account() {
		$list = $this->coinpayments->call('balances', array('all' => 1));
        $status = ($list['error'] == 'ok') ? array('status' => true, 'api_status' => $list['result'][$this->symbol]['status'], 'coin_status' => $list['result'][$this->symbol]['coin_status'], 'symbol' => $this->symbol, 'balance' => $list['result'][$this->symbol]['balancef']) : array('status' => false);
        return json_encode($status);
    }
    
    public function generateAddress($label = '') {
        $get = json_decode(file_get_contents('https://node.billiance.io/apiv1/account/generate'), true);
        $status = isset($get['address']) ? array('status' => true, 'symbol' => $this->symbol, 'address' => $get['address']['address'], 'privateKey' => $get['address']['privateKey']) : array('status' => false);
        return json_encode($status);
    }

	public function validator($address) {
        $validate = preg_match('/^0x[0-9A-Fa-f]{40}/i', $address);
        return $validate;
	}
    
    public function rate() {
        return 1;
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
    
	public function transfer($address, $amount, $memo) {
		$get = $this->coinpayments->call('create_withdrawal', array('amount' => $amount, 'currency' => $this->symbol, 'address' => $address, 'auto_confirm' => 1, 'note' => $memo));
		$status = ($get['error'] == 'ok') ? array('status' => true, 'symbol' => $this->symbol, 'address' => $address, 'description' => $memo, 'amount' => $amount, 'response' => json_encode($get)) : array('status' => false, 'msg' => $get);
		return json_encode($status);
	}
}
