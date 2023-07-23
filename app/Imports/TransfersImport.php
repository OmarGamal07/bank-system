<?php
namespace App\Imports;
use App\Models\Transfer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Type;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use RealRashid\SweetAlert\Facades\Alert;

class TransfersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
        // Check if the numberOperation already exists in the transfers table
        $existingTransfer = Transfer::where('numberOperation', $row['numberoperation'])->exists();
        if ($existingTransfer) {
             
            return null;
        }
         // Convert the Excel serialized date to a regular date format
       $excelDateValue = $row['datetransfer'];
       $dateTransfer = Date::excelToDateTimeObject($excelDateValue)->format('Y-m-d');
        // Find or create the sender client
        $sender = Client::firstOrCreate(['name' => $row['sender']], ['role' => 'sender']);

        // Find or create the receiver client
        $receiver = Client::firstOrCreate(['name' => $row['receiver']], ['role' => 'receiver']); 
        $type =  Type::where('name', $row['type'])->first();
        $bank =  Bank::where('name', $row['bank'])->first();
        
        return new Transfer([
            'sender_id' =>$sender->id ,
            'receiver_id' =>$receiver->id,
            'type_id' =>$type->id,
            'bank_id' =>$bank->id,
            'mount' =>$row['mount'],
            'dateTransfer' =>$dateTransfer,
            'numberAccount' =>$row['numberaccount'],
            'numberOperation' =>$row['numberoperation'],
        ]);
        
    }
}