<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Type;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


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
        $clients = Client::all();
        $banks = Bank::all();
        $types = Type::all();
        return view('admin.admin', ['transfers'=>$transfers,'countTransfer'=>$countTransfer,'totalMount'=>$totalMount,'clients'=>$clients,'banks'=>$banks,'types'=>$types]);
    }

    public function fetchAllData()
    {
        // Fetch all data from the database (assuming you want all data without any filters)
        $allData = Transfer::with(['sender', 'receiver', 'bank', 'type'])->get();
        $countTransfer=Transfer::count();
        $totalMount = Transfer::sum('mount');
        $response = [
            'transfers' => $allData,
            'countTransfer' => $countTransfer,
            'totalMount' => $totalMount,
        ];

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $types = Type::all();
        $banks = Bank::all();
        return view('client.add', ['types'=>$types,'banks'=>$banks]);
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
            Alert::error('الحواله مدخله سابقا',' من '.$request->input('sender'));
            return redirect()->back()->withInput($request->all());
        }

        // Find or create the sender client
        $sender = Client::firstOrCreate(['name' => $request->input('sender')], ['role' => 'sender']);

        // Find or create the receiver client
        $receiver = Client::firstOrCreate(['name' => $request->input('receiver')], ['role' => 'receiver']);

        // Prepare the data for creating the transfer
        $data = $request->only(['numberAccount','numberOperation', 'mount', 'type_id', 'bank_id', 'dateTransfer']);
        $data['sender_id'] = $sender->id;
        $data['receiver_id'] = $receiver->id;

        // Create the transfer
        Transfer::create($data);
        Alert::success('تم حفظ الحواله بنجاح');

        return redirect()->route('transfer.index')->with('success', 'تمت الاضافة بنجاح');
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
    public function update(Request $request)
    {
        //
        $id = $request->input('id');
        $status = $request->input('status');

        Transfer::where('id',$id)->update(['status'=>$status]);
        return response()->json(['success' => true]);    }

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
        $countTransfer = $query->count();
        $totalMount = $query->sum('mount');
        $response = [
            'transfers' => $transfers,
            'countTransfer' => $countTransfer,
            'totalMount' => $totalMount,
        ];

        return response()->json($response);
    }
}
