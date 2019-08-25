<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction',[
            'api_token' => (Auth::user()) ? Auth::user()->api_token : null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user = User::find($request->user_id);

        $transaction = new Transaction;
        $transaction->description = $request->description;
        $transaction->status = $request->status;
        $transaction->value = $request->value;
        $transaction->user_id = $request->user_id;
        if($request->status == 'P'){
            $amount = $user->amount-$request->value;
            $transaction->type == 'D';
            $transaction->amount_before = $user->amount;
            $transaction->amount_after = $amount;
            $user->amount = $amount;
            $user->save();
        }elseif($request->status == 'R'){
            $amount = $user->amount+$request->value;
            $transaction->type == 'R';
            $transaction->amount_before = $user->amount;
            $transaction->amount_after = $amount;
            $user->amount = $amount;
            $user->save();
        }else{
            $request->type == '';
        }
        $transaction->save();
    }

    public function show()
    {
        $transaction = Transaction::orderBy('id', 'desc')->get();
        return response()->json($transaction);
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return response()->json($transaction);
    }

    public function update(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $user = User::find($transaction->user_id);

        $transaction->description = $request->description;
        $transaction->status = $request->status;
        $transaction->value = $request->value;
        $transaction->user_id = $request->user_id;
        if($request->status == 'P'){
            $amount = $user->amount-$request->value;
            $transaction->type == 'D';
            $transaction->amount_before = $user->amount;
            $transaction->amount_after = $amount;
            $user->amount = $amount;
            $user->save();
        }elseif($request->status == 'R'){
            $amount = $user->amount+$request->value;
            $transaction->type == 'R';
            $transaction->amount_before = $user->amount;
            $transaction->amount_after = $amount;
            $user->amount = $amount;
            $user->save();
        }else{
            $request->type == '';
        }
        $transaction->save();
    }

    public function destroy($id)
    {
        if(!empty($id)){
            $transaction = Transaction::find($id);
            $transaction->delete();
        }
    }
}
