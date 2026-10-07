<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ArsipExport implements FromView, ShouldAutoSize
{
    protected $arsips;
    protected $kategori;

    public function __construct($arsips, $kategori)
    {
        $this->arsips = $arsips;
        $this->kategori = $kategori;
    }

    public function view(): View
    {
        return view('arsip.excel', [
            'arsips' => $this->arsips,
            'kategori' => $this->kategori
        ]);
    }
}
