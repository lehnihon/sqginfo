<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
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
        return view('account');
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
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->bank_id = $request->bank_id;
        $user->save();

        return response()->json(["error" => ""],200);
    }

    public function show()
    {
        $user = User::orderBy('id', 'desc')->get();
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    public function destroy($id)
    {
        if(!empty($id)){
            $transaction = Transaction::where('user_id',$id)->count();
            if(!$transaction){
                $user = User::find($id);
                $user->delete();
                return response()->json(["error" => ""],200);
            }else{
                return response()->json(["error" => "Esse usuário tem transações ativas"],400);
            }
        }
    }
}
