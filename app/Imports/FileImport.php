<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
//use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class FileImport implements WithMultipleSheets, SkipsUnknownSheets
{

    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'Liste Med' => new ListeMed(),
            'Rapport Med' => new RapportMed(),
        ];
    }

    // public function sheets(): array
    // {
    //     return [
    //         'Liste Med' => new ListeMed(),
    //         //'Liste Ph' => new ListePh(),
    //         'Rapport Med' => new RapportMed(),
    //         /*'Rapport Ph' => new RapportPh(),
    //         'BC Med' => new BCMed(),
    //         'Suivi Pack' => new SuiviPack(),*/
    //         /*0 => new ListeMed(),
    //         1 => new ListePh    (),
    //         2 => new RapportMed(),
    //         3 => new RapportPh(),
    //         4 => new BCMed(),
    //         5 => new SuiviPack(),*/

    //     ];
    // }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
        //dd("ERROR : {$sheetName} is not found !");
    }


}
