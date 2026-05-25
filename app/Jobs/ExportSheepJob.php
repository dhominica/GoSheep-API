<?php

namespace App\Jobs;

use App\Models\Sheep;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Writer\XLSX\Options;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Row;

class ExportSheepJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $exportPath = storage_path('app/public/exports');
        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0755, true);
        }

        $filePath = $exportPath . '/data-domba.xlsx';

        // Konfigurasi Lebar Kolom Default agar teks tidak tertimpa/terpotong
        $options = new Options();
        $options->DEFAULT_COLUMN_WIDTH = 25;

        $writer = new Writer($options);
        $writer->openToFile($filePath);

        // Styling Borders & Tabel
        $border = new Border(
            new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
        );

        $headerStyle = (new Style())
            ->setFontBold()
            ->setBackgroundColor('FFD3D3D3')
            ->setBorder($border)
            ->setShouldWrapText(true)
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);

        $rowStyle = (new Style())
            ->setBorder($border)
            ->setShouldWrapText(true)
            ->setCellVerticalAlignment(CellVerticalAlignment::TOP);

        // Menambahkan Header
        $writer->addRow(Row::fromValues([
            'No.',
            'Eartag',
            'Warna Eartag',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Umur (Bulan)',
            'Jenis (Breed)',
            'Bapak (Eartag)',
            'Induk (Eartag)',
            'Kandang',
            'Status',
            'Tanggal Ditambahkan'
        ], $headerStyle));

        // Kamus Terjemahan Bahasa Indonesia
        $colors = [
            'yellow' => 'Kuning', 'red' => 'Merah', 'blue' => 'Biru',
            'green' => 'Hijau', 'black' => 'Hitam', 'white' => 'Putih',
            'brown' => 'Cokelat', 'orange' => 'Oranye', 'purple' => 'Ungu',
        ];
        $statuses = ['active' => 'Aktif', 'sold' => 'Terjual', 'dead' => 'Mati'];

        $query = Sheep::with(['breed', 'sire', 'dam', 'cage'])->orderBy('id', 'asc');
        
        $counter = 1;
        $query->chunk(100, function ($sheeps) use (&$writer, &$counter, $rowStyle, $colors, $statuses) {
            foreach ($sheeps as $sheep) {
                $warna = $colors[strtolower($sheep->eartag_color)] ?? ucfirst($sheep->eartag_color);
                $status = $statuses[strtolower($sheep->status)] ?? ucfirst($sheep->status);
                
                $writer->addRow(Row::fromValues([
                    'No.' => $counter++,
                    'Eartag' => $sheep->eartag,
                    'Warna Eartag' => $warna,
                    'Jenis Kelamin' => $sheep->gender === 'male' ? 'Jantan' : 'Betina',
                    'Tanggal Lahir' => \Carbon\Carbon::parse($sheep->birth_date)->locale('id')->translatedFormat('d F Y'),
                    'Umur (Bulan)' => \Carbon\Carbon::parse($sheep->birth_date)->age,
                    'Jenis (Breed)' => $sheep->breed ? $sheep->breed->name : '-',
                    'Bapak (Eartag)' => $sheep->sire ? $sheep->sire->eartag : '-',
                    'Induk (Eartag)' => $sheep->dam ? $sheep->dam->eartag : '-',
                    'Kandang' => $sheep->cage ? $sheep->cage->name : '-',
                    'Status' => $status,
                    'Tanggal Ditambahkan' => $sheep->created_at->locale('id')->translatedFormat('d F Y H:i:s'),
                ], $rowStyle));
            }
        });

        $writer->close();
    }
}
