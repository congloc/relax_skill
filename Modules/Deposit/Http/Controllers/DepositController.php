<?php

namespace Modules\Deposit\Http\Controllers;

use App\Vuta\Device;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Modules\Deposit\Entities\Deposit;
use Modules\Deposit\Http\Requests\DeleteDepositRequest;
use Modules\Deposit\Http\Requests\UpdateDepositRequest;
use Modules\Deposit\Transformers\DepositResource;

class DepositController extends Controller
{
    public function postCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient' => 'required|string',
            'amount' => 'required|min:0',
            'symbol' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()->first()
            ]);
        }

        $recipient = $request->recipient;
        $user = DB::table('users')->where(function ($query) use ($recipient) {
            $query->where('username', $recipient)->orWhere('email', $recipient);
        })->first();

        if (is_null($user)) {
            return response()->json([
                'status' => 422,
                'message' => 'Receiver not exist'
            ]);
        }

        if ($request->amount == 0) {
            return response()->json([
                'status' => 422,
                'message' => 'Amount is not correct.'
            ]);
        }

        $fee = 0;
        $total = $request->amount + ($fee*$request->amount)/100;
        $cf_ip = request()->server('HTTP_CF_CONNECTING_IP');
        $client_ip = !is_null($cf_ip) ? $cf_ip : request()->server('REMOTE_ADDR');
        DB::beginTransaction();
        try {
            $create = [
                'ip' => $client_ip,
                'deposit_id' => strtoupper(uniqid('D')),
                'action' => 'DEPOSIT',
                'user_id' => $user->id,
                'symbol' => $request->symbol,
                'amount' => (float)$request->amount,
                'fee' => $fee,
                'total' => $total,
                'status' => 0,
                'type' => 'deposit',
                'author' => auth()->user()->id,
            ];

            Deposit::create($create);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Create deposit success.'
            ]);
        } catch (QueryException $ex) {
            DB::rollback();
            return response()->json([
                'status' => 422,
                'message' => 'Create deposit fail.'
            ]);
        }
    }

    public function getHistory(Request $request)
    {
        $keyword = $request->get('keyword');
        $searchField = ['deposit_id'];

        $deposit = DB::table('deposit')->leftjoin('users', 'deposit.user_id', '=', 'users.id')
        ->where('deposit.action', 'DEPOSIT')
        ->when($keyword,function($query) use ($keyword, $searchField){
            return $query->where(function ($query) use ($keyword, $searchField)  {
                foreach ($searchField as $field) {
                    $query->orWhere($field, 'like', '%' . $keyword . '%');
                }
            });
        })
        ->select('deposit.*', 'users.username as username')
        ->orderBy('deposit.id', 'desc')->paginate(config('app.per_page'));

        $data = [
            'deposit' => $deposit,
        ];

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function show(Deposit $deposit){
        if(Gate::denies('deposit_show')){
            return response()->json([
                'status' => 403,
                'message' => 'You not have permission.',
            ]);
        }
        return new DepositResource($deposit);
    }

    public function update(UpdateDepositRequest $request, Deposit $deposit){
        if(Gate::denies('deposit_edit')){
            return response()->json([
                'status' => 403,
                'message' => 'You not have permission.',
            ]);
        }
        $deposit->update($request->except('user_id'));
    }

    public function destroy(DeleteDepositRequest $deposit){
        if(Gate::denies('deposit_delete')){
            return response()->json([
                'status' => 403,
                'message' => 'You not have permission.',
            ]);
        }

        $deposit->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Delete deposit success.',
        ]);
    }
}
