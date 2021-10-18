<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BfarReport implements FromView, ShouldAutoSize
{
    protected $datas;

    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    public function view(): View
    {
        return view('wharf.report.bfar_export', [
            'row' => $this->datas,
        ]);
    }
}
