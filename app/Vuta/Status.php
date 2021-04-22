<?php
namespace App\Vuta;

trait Status {
	
	public static function user_status() {
		return [
			'<span class="badge badge-warning">'.__('Inactive').'<span>',
			'<span class="badge badge-success">'.__('Actived').'<span>',
			'<span class="badge badge-danger">'.__('Banned').'<span>',
		];
	}
	
	public static function expert_status() {
		return [
			'<span class="badge badge-warning">'.__('Inactive').'<span>',
			'<span class="badge badge-success">'.__('Actived').'<span>',
			'<span class="badge badge-danger">'.__('Cancelled').'<span>',
		];
	}

	public static function commission_level_status() {
		return [
			'<span class="badge badge-warning">'.__('Inactive').'<span>',
			'<span class="badge badge-success">'.__('Actived').'<span>',
		];
	}

	public static function commission_sale_status() {
		return [
			'<span class="badge badge-warning">'.__('Inactive').'<span>',
			'<span class="badge badge-success">'.__('Actived').'<span>',
		];
	}
	
	public static function deposit_status() {
		return [
			'<span class="badge badge-warning">'.__('Pending').'<span>',
			'<span class="badge badge-success">'.__('Completed').'<span>',
			'<span class="badge badge-danger">'.__('Cancelled').'<span>',
		];
	}

	public static function transfers_status() {
		return [
			'<span class="badge badge-warning">'.__('Pending').'<span>',
			'<span class="badge badge-success">'.__('Completed').'<span>',
			'<span class="badge badge-danger">'.__('Cancelled').'<span>',
		];
	}
	
	public static function withdraw_status() {
		return [
			'<span class="badge badge-warning">'.__('Pending').'<span>',
			'<span class="badge badge-success">'.__('Completed').'<span>',
			'<span class="badge badge-danger">'.__('Cancelled').'<span>',
		];
	}
	
	public static function admincp_verify_status() {
		return [
			'',
			'<span class="badge badge-warning">'.__('Pending').'<span>',
			'<span class="badge badge-success">'.__('Completed').'<span>',
			'<span class="badge badge-danger">'.__('Từ chối').'<span>',
		];
	}
	
	public static function airdrop_status() {
		return [
			'<span class="badge badge-warning">'.__('Pending').'<span>',
			'<span class="badge badge-success">'.__('Completed').'<span>',
			'<span class="badge badge-danger">'.__('Error').'<span>',
		];
	}
	
	public static function action_type() {
		return [
			'DEPOSIT' => 'Nạp',
			'BUY' => 'Mua',
			'SELL' => 'Bán',
			'WITHDRAW' => 'Rút'
		];
	}

	public static function order_status() {
		return [
			'<span class="text-secondary">PENDING</span>',
			'<span class="text-success">WIN</span>',
			'<span class="text-danger">LOSE</span>',
			'<span class="text-light">TIE</span>',
		];
	}

	public static function robot_status() {
		return [
			'<span class="badge badge-danger">Stopped</span>',
			'<span class="badge badge-success">Running</span>',
		];
	}

	public static function admin_order_status() {
		return [
			'<span class="badge badge-warning">Pending...</span>',
			'<span class="badge badge-primary">Processing...</span>',
			'<span class="badge badge-success">Completed</span>',
			'<span class="badge badge-danger">Cancelled</span>',
			'<span class="badge badge-danger">Error</span>'
		];
	}

	public static function account_order_status() {
		return [
			'<span class="badge badge-warning">Chưa thanh toán</span>',
			'<span class="badge badge-primary">Đã thanh toán</span>',
			'<span class="badge badge-success">Completed</span>',
			'<span class="badge badge-danger">Cancelled</span>',
		];
	}
	
	public static function post_status() {
		return [
			'publish' => '<span class="text-success">Publish</span>',
			'draft' => '<span class="text-secondary">Draft</span>',
			'pending' => '<span class="text-danger">Pending Review</span>',
		];
	}
	
	public static function commission_status() {
		return [
			'<span class="badge badge-warning">Pending</span>',
			'<span class="badge badge-success">Paid</span>',
		];
	}

	public static function ticket_status() {
		return [
			'<span class="badge badge-success">OPEN</span>',
			'<span class="badge badge-warning">WAITING</span>',
			'<span class="badge badge-primary">RESPONSE</span>',
			'<span class="badge badge-danger">CLOSE</span>',
		];
	}

	public static function blb_status() {
		return [
			'<span class="badge badge-primary">OPEN</span>',
			'<span class="badge badge-success">SOLD OUT</span>',
			'<span class="badge badge-danger">CLOSE</span>',
		];
	}

	public static function staking_status() {
		return [
			'<span class="badge badge-danger">Stopped</span>',
			'<span class="badge badge-success">Running</span>',
		];
	}
}