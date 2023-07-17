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
        $countTransfer=Transfer::count();
        $totalMount = Transfer::sum('mount');
        return view('transfers.transfer_index', ['transfers'=>$transfers,'countTransfer'=>$countTransfer,'totalMount'=>$totalMount]);
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
        // Check if the numberOperation already exists in the transfers table
        $numberOperation = $request->input('numberOperation');
        $existingTransfer = Transfer::where('numberOperation', $numberOperation)->exists();
        if ($existingTransfer) {
            return view('transfers.createtransfer', ['errors' => $request->input('sender') . ' العملية مُسجلة من قبل']);
        }
    
        // Find or create the sender client
        $sender = Client::firstOrCreate(['name' => $request->input('sender')], ['role' => 'sender']);
    
        // Find or create the receiver client
        $receiver = Client::firstOrCreate(['name' => $request->input('receiver')], ['role' => 'receiver']);
    
        // Prepare the data for creating the transfer
        $data = $request->only(['numberAccount', 'mount', 'type_id', 'bank_id', 'dateTransfer']);
        $data['sender_id'] = $sender->id;
        $data['receiver_id'] = $receiver->id;   
    
        // Create the transfer
        Transfer::create($data);
    
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
        $transfer->update($request->all());
        return redirect()->route('transfers.show', $transfer->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
    public function filter(Request $request)
    {
        $query = Transfer::query();

        // Filter by date transfer
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $query->whereBetween('dateTransfer', [$fromDate, $toDate]);
        }

        // Filter by sender name or receiver name
        if ($request->filled('client_name') && $request->input('client_name') !== 'الجميع') {
            $clientName = $request->input('client_name');
            $query->where(function ($query) use ($clientName) {
                $query->whereHas('sender', function ($query) use ($clientName) {
                    $query->where('name', $clientName);
                })->orWhereHas('receiver', function ($query) use ($clientName) {
                    $query->where('name', $clientName);
                });
            });
        }

        // Filter by bank name
        if ($request->filled('bank_name') && $request->input('bank_name') !== 'الجميع') {
            $bankName = $request->input('bank_name');
            $query->whereHas('bank', function ($query) use ($bankName) {
                $query->where('name', $bankName);
            });
        }

        // Filter by type name
        if ($request->filled('type_name') && $request->input('type_name') !== 'الجميع') {
            $typeName = $request->input('type_name');
            $query->whereHas('type', function ($query) use ($typeName) {
                $query->where('name', $typeName);
            });
        }

        // Eager load related models (sender, receiver, bank, and type) to reduce queries
        $transfers = $query->with(['sender', 'receiver', 'bank', 'type'])->get();

        return view('transfers.transfer_index', ['transfers' => $transfers]);
    }
}
