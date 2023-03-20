<?php

namespace App\Imports;

use App\Models\Patient;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PatientsImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * It creates a new patient with the data from the row, and then creates a new address for that patient
     * 
     * @param Collection collection The collection of rows that were imported.
     * 
     * @return The return is a boolean value, true or false.
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            try {
                $patient = Patient::create([
                    'name' => $row['nome'],
                    'mother_name' => $row['nome_da_mae'],
                    'birth_date' => $row['data_de_nascimento'],
                    'cpf' => $row['cpf'],
                    'cns' => $row['cns'],
                ]);
                $patient->address()->create([
                    'zip_code' => $row['cep'],
                    'street' => $row['rua'],
                    'number' => $row['numero'],
                    'complement' => $row['complemento'],
                    'district' => $row['bairro'],
                    'city' => $row['cidade'],
                    'state' => $row['uf'],
                ]);
            } catch (Exception $e) {
                return false;
            }
        }
    }

    /**
     * `headingRow` returns the row number of the heading row
     * 
     * @return int The heading row of the spreadsheet.
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * "The chunkSize() function returns the number of records to process at a time."
     * 
     * The chunkSize() function is called by the framework to determine how many records to process at a
     * time. The default value is 1000
     * 
     * @return int The chunkSize method returns the number of items to be processed at a time.
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
