<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use Session;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $payment = []; 
       $payment = Transaction::where(['payment_type'=> '1'])->orderBy('created_at', 'DESC')->with(['getUser'])->get();

       return view('admin.payment.index', compact('payment'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statements  $statements
     * @return \Illuminate\Http\Response
     */
    public function show(Statements $statements)
    {
        echo "<pre>";
        print_r($statements);
        echo "<pre>";
        die();
       $statement = [];
       $statement = Statements::with(['getUserName', 'getVerb'])->get();
       // dd($statement);
       return view('admin.statement.show', compact('statement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Statements  $statements
     * @return \Illuminate\Http\Response
     */
    public function edit(Statements $statements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statements  $statements
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statements $statements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Statements  $statements
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statements $statements)
    {
        //
    }
}
