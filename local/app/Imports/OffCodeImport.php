<?php

namespace App\Imports;

use App\Offcode;
use App\Miniproduct;
use Maatwebsite\Excel\Concerns\ToModel;

class OffCodeImport implements ToModel
{

    public function model(array $row)
    {
        $miniproduct = Miniproduct::orderby('id', 'desc')->first();
        return new Offcode([
            'code'     => $row[0],
            'product_id'    => $miniproduct->id,
        ]);
    }
}