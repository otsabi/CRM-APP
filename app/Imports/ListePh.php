<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ListePh implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{

    public function Collection(Collection $collection)
    {

        echo "Liste Ph !<br>";
    }

}
