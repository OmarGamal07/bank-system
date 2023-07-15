<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Type;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $transfers = Transfer::with(['sender', 'receiver'])->get();
        // countTr
        return view('transfers.transfer_index', ['transfers'=>$transfers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $types = Type::all();
        $banks = Bank::all();
        return view('transfers.createtransfer', ['types'=>$types,'banks'=>$banks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        //
        $sender = Client::where('name', $request->input('sender'))->first();
        if(!$sender){
            $sender = Client::create([
                'name' => $request->input('sender'),
                'role' => 'sender',
            ]);
        }
        $receiver = Client::where('name', $request->input('receiver'))->first();
        if(!$receiver){
            $receiver = Client::create([
                'name' => $request->input('receiver'),
                'role' => 'receiver',
            ]);
        }
        $data = $request->only(['numberAccount', 'mount', 'type_id', 'bank_id','dateTransfer']);
        $data['sender_id'] = $sender->id;
        $data['receiver_id'] = $receiver->id;    
        $transfer=Transfer::create($data);
        return redirect()->route('transfers.index');  
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
