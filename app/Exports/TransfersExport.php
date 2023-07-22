<?php
namespace App\Exports;

use App\Models\Transfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransfersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Transfer::join('clients as sender', 'transfers.sender_id', '=', 'sender.id')
        ->join('clients as receiver', 'transfers.receiver_id', '=', 'receiver.id')
        ->join('types', 'transfers.type_id', '=', 'types.id')
        ->join('banks', 'transfers.bank_id', '=', 'banks.id')
        ->select('sender.name as sender', 'receiver.name as receiver', 'types.name as type', 'banks.name as bank', 'dateTransfer', 'numberAccount', 'numberOperation', 'mount')
        ->get();
    }

    /**
     * Write code on Method
     *
     * @return array
     */
    public function headings(): array
    {
        return ["sender", "receiver", "type", "bank", "datetransfer", "numberaccount", "numberoperation", "mount"];
    }
}
