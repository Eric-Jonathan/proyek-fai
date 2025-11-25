<?php

namespace App\Services;

use App\Models\NomorSurat;

class NomorSuratService
{
    /**
     * Generate preview tanpa menyimpan ke DB.
     */
    public function generatePreview()
    {
        $tahun = date('Y');

        // Ambil record nomor surat untuk tahun berjalan.
        $record = NomorSurat::firstOrCreate(
            ['tahun' => $tahun],
            ['nomor_terakhir' => 0]
        );

        $nextNumber = $record->nomor_terakhir + 1;
        $bulanRomawi = $this->convertToRoman(date('n'));

        return "{$nextNumber}/A6/ISTTS/{$bulanRomawi}/{$tahun}";
    }

    /**
     * Generate nomor surat final (menyimpan increment ke database)
     */
    public function generateFinal()
    {
        $tahun = date('Y');

        $record = NomorSurat::firstOrCreate(
            ['tahun' => $tahun],
            ['nomor_terakhir' => 0]
        );

        $record->nomor_terakhir += 1;
        $record->save();

        $bulanRomawi = $this->convertToRoman(date('n'));

        return "{$record->nomor_terakhir}/A6/ISTTS/{$bulanRomawi}/{$tahun}";
    }

    /**
     * Konversi angka bulan ke romawi
     */
    private function convertToRoman($month)
    {
        $romans = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $romans[$month];
    }
}
