<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CustomersImport implements ToModel, WithChunkReading, WithValidation, SkipsOnError, WithStartRow
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info("CustomersImport");
        return new Customer([
            'first_name' => $row[1],
            'last_name' => $row[2],
            'email' => $row[3],
            'phone' => $row[4],
            'street_address' => $row[5],
            'city' => $row[6],
            'state' => $row[7],
            'country' => $row[8],
            'organization_name' => $row[9],
            'website' => $row[10],
            'instagram' => $row[11],
            'tiktok' => $row[12],
            'twitter' => $row[13],
            'youtube' => $row[14],
            'description' => $row[15],
            'notes' => $row[16],
            'choose_one' => $row[17],
            'services' => $row[18],
            'has_supported' => $row[19],
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
    public function rules(): array
    {
        return [
            '1' => ['required'],
            '2' => ['required'],
            '3' => ['required'],
            '4' => ['required'],
            // '5' => ['required'],
            // '6' => ['required'],
            // '7' => ['required'],
            // '8' => ['required'],
            // '9' => ['required'],
            // '10' => ['required'],
            // '11' => ['required'],
            // '12' => ['required'],
            // '13' => ['required'],
            // '14' => ['required'],
            // '15' => ['required'],
            // '16' => ['required'],
            // '17' => ['required'],
            // '17' => ['required'],
            // '18' => ['required'],
        ];
    }
    public function chunkSize(): int
    {
        return 50; // Set the chunk size for reading data
    }
}
