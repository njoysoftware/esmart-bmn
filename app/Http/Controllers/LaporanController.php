<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\Maintenance;
use App\Models\Rkbmn;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Section;
use Carbon\Carbon;

class LaporanController extends Controller
{

    private function kopSurat($section)
    {
        $table = $section->addTable();
        $table->addRow();

        // LOGO
        $table->addCell(2000)->addImage(
            public_path('logo.png'),
            ['width' => 80]
        );

        $cell = $table->addCell(8000);

        // STYLE RAPAT
        $pStyle = [
            'alignment' => 'left',
            'spaceAfter' => 0,
            'spaceBefore' => 0,
            'lineHeight' => 1,
        ];

        $cell->addText(
            'BADAN PENGAWAS PEMILIHAN UMUM',
            ['bold' => true, 'size' => 18],
            $pStyle
        );

        $cell->addText(
            'KABUPATEN LAMONGAN',
            ['bold' => true, 'size' => 16],
            $pStyle
        );

        $cell->addText(
            'Jl. Raya Mastrip No.44 Lamongan',
            ['size' => 10],
            $pStyle
        );

        $cell->addText(
            'Email: set.lamongan@bawaslu.go.id',
            ['size' => 10],
            $pStyle
        );

        $section->addTextBreak(1);
    }

    private function tandaTangan($section)
    {
        $kanan = ['alignment' => 'right'];
        $tte = ['spaceAfter' => 0, 'spaceBefore' => 0, 'lineHeight' => 1, 'padding-right' => 30];
        $rapat = ['spaceAfter' => 0];

        // Ambil tanggal otomatis
        $tanggal = now()->translatedFormat('d F Y');

        // Lokasi + tanggal
        $section->addText(
            'Lamongan, ' . $tanggal,
            [],
            $kanan + $rapat
        );

        $section->addTextBreak(1);

        // Jabatan
        $section->addText(
            'Mengetahui,',
            [],
            $kanan + $tte + $rapat
        );

        $section->addText(
            'Kuasa Pengguna Barang',
            [],
            $kanan + $tte + $rapat
        );

        // Jarak untuk tanda tangan
        $section->addTextBreak(3);

        // Nama pejabat
        $section->addText(
            'Agus Prijambodo,S.H.',
            ['bold' => true],
            $kanan + $tte + $rapat
        );

        // NIP
        $section->addText(
            'NIP.196807051989031021',
            [],
            $kanan + $tte + $rapat
        );
    }
    // =========================
    // 1. BARANG
    // =========================
    public function barang()
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultParagraphStyle([
            'spaceAfter' => 0,
            'spaceBefore' => 0,
            'lineHeight' => 1,
        ]);

        //$section = $phpWord->addSection();
        $section = $phpWord->addSection([
            'orientation' => Section::ORIENTATION_LANDSCAPE,
        ]);

        // KOP
        $this->kopSurat($section);
        $start = Carbon::parse(request('start'));
        $end = Carbon::parse(request('end'));
        $tanggal_start =  $start->translatedFormat('d F Y');
        $tanggal_end =  $end->translatedFormat('d F Y');
        $section->addText('LAPORAN DATA BARANG', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addText("Periode: $tanggal_start s/d $tanggal_end");
        $section->addTextBreak();
        $phpWord->addTableStyle('tableStyle', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 30,
        ]);
        $table = $section->addTable('tableStyle');

        $table->addRow();
        $headerStyle = ['bold' => true];
        $cellHeader = ['bgColor' => '66BBFF'];
        $center = ['alignment' => 'center'];
        $table->addCell(800, $cellHeader)->addText('No', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Kode', $headerStyle, $center);
        $table->addCell(1000, $cellHeader)->addText('NUP', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Kode Register', $headerStyle, $center);
        $table->addCell(4000, $cellHeader)->addText('Nama Barang', $headerStyle, $center);
        $table->addCell(1000, $cellHeader)->addText('Merk', $headerStyle, $center);
        $table->addCell(1000, $cellHeader)->addText('Status', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Lokasi', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Kondisi', $headerStyle, $center);

        $no = 1;
        $data = Barang::with('lokasi')
            ->get();

        foreach ($data as $b) {
            $table->addRow();
            $table->addCell()->addText($no++, [], $center);
            $table->addCell()->addText($b->kode_barang);
            $table->addCell()->addText($b->nup);
            $table->addCell()->addText($b->kode_register);
            $table->addCell()->addText($b->nama_barang);
            $table->addCell()->addText($b->merk);
            $table->addCell()->addText($b->status_bmn);
            $table->addCell()->addText($b->lokasi->nama_ruang ?? '-');
            $table->addCell()->addText($b->kondisi);
        }
        $table->addRow();
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $section->addTextBreak();
        //TTD
        $this->tandaTangan($section);

        return $this->download($phpWord, 'laporan_barang.docx');
    }

    // =========================
    // 2. MAINTENANCE
    // =========================
    public function maintenance()
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultParagraphStyle([
            'spaceAfter' => 0,
            'spaceBefore' => 0,
            'lineHeight' => 1,
        ]);

        //$section = $phpWord->addSection();
        $section = $phpWord->addSection([
            'orientation' => Section::ORIENTATION_LANDSCAPE,
        ]);

        // KOP
        $this->kopSurat($section);
        // $start = request('start');
        // $end = request('end');
        $start = Carbon::parse(request('start'));
        $end = Carbon::parse(request('end'));

        $tanggal_start =  $start->translatedFormat('d F Y');
        $tanggal_end =  $end->translatedFormat('d F Y');

        $section->addText('LAPORAN MAINTENANCE BMN', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addText("Periode: $tanggal_start s/d $tanggal_end");
        $section->addTextBreak();

        $phpWord->addTableStyle('tableStyle', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 30,
        ]);
        $table = $section->addTable('tableStyle');


        $table->addRow();
        $headerStyle = ['bold' => true];
        $cellHeader = ['bgColor' => '66BBFF'];
        $center = ['alignment' => 'center'];
        $table->addCell(1000, $cellHeader)->addText('No', $headerStyle, $center);
        $table->addCell(8000, $cellHeader)->addText('Barang', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Tanggal', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Jenis', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Biaya', $headerStyle, $center);

        $no = 1;
        $data = Maintenance::with('barang')
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereDate('tanggal', '>=', $start)
                    ->whereDate('tanggal', '<=', $end);
            })
            ->get();

        foreach ($data as $m) {
            $table->addRow();
            $table->addCell()->addText($no++, [], $center);
            $table->addCell()->addText($m->barang->nama_barang ?? '-');
            $table->addCell()->addText($m->tanggal);
            $table->addCell()->addText($m->jenis);
            $table->addCell()->addText($m->biaya);
        }
        $table->addRow();
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $section->addTextBreak();
        //TTD
        $this->tandaTangan($section);
        return $this->download($phpWord, 'laporan_maintenance.docx');
    }

    // =========================
    // 3. RKBMN
    // =========================
    public function rkbmn()
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultParagraphStyle([
            'spaceAfter' => 0,
            'spaceBefore' => 0,
            'lineHeight' => 1,
        ]);

        //$section = $phpWord->addSection();
        $section = $phpWord->addSection([
            'orientation' => Section::ORIENTATION_LANDSCAPE,
        ]);

        // KOP
        $this->kopSurat($section);
        $start = Carbon::parse(request('start'));
        $end = Carbon::parse(request('end'));
        $tanggal_start =  $start->translatedFormat('d F Y');
        $tanggal_end =  $end->translatedFormat('d F Y');

        $section->addText('LAPORAN RKBMN', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addText("Periode: $tanggal_start s/d $tanggal_end");
        $section->addTextBreak();

        $phpWord->addTableStyle('tableStyle', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 30,
        ]);
        $table = $section->addTable('tableStyle');


        $table->addRow();
        $headerStyle = ['bold' => true];
        $cellHeader = ['bgColor' => '66BBFF'];
        $center = ['alignment' => 'center'];
        $table->addCell(1000, $cellHeader)->addText('No', $headerStyle, $center);
        $table->addCell(8000, $cellHeader)->addText('Barang', $headerStyle, $center);
        $table->addCell(3000, $cellHeader)->addText('Rekomendasi', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Prioritas', $headerStyle, $center);
        $table->addCell(8000, $cellHeader)->addText('Alasan', $headerStyle, $center);

        $no = 1;

        $data = Rkbmn::with('barang')
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end);
            })
            ->get();

        foreach ($data as $r) {
            $table->addRow();
            $table->addCell()->addText($no++, [], $center);
            $table->addCell()->addText($r->barang->nama_barang ?? '-');
            $table->addCell()->addText($r->jenis_rekomendasi);
            $table->addCell()->addText($r->prioritas);
            $table->addCell()->addText($r->alasan);
        }
        $table->addRow();
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);

        $section->addTextBreak();
        //TTD
        $this->tandaTangan($section);
        return $this->download($phpWord, 'laporan_rkbmn.docx');
    }

    // =========================
    // 4. GABUNGAN
    // =========================
    public function semua()
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultParagraphStyle([
            'spaceAfter' => 0,
            'spaceBefore' => 0,
            'lineHeight' => 1,
        ]);
        $section = $phpWord->addSection([
            'orientation' => Section::ORIENTATION_LANDSCAPE,
        ]);
        // KOP
        $this->kopSurat($section);
        $start = Carbon::parse(request('start'));
        $end = Carbon::parse(request('end'));
        $tanggal_start =  $start->translatedFormat('d F Y');
        $tanggal_end =  $end->translatedFormat('d F Y');

        $section->addText('LAPORAN BMN TERPADU', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addText("Periode: $tanggal_start s/d $tanggal_end");

        $section->addTextBreak(2);
        // A. Barang
        $section->addText('A. BARANG', ['bold' => true]);
        $phpWord->addTableStyle('tableStyle', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 30,
        ]);
        $table = $section->addTable('tableStyle');

        $table->addRow();
        $headerStyle = ['bold' => true];
        $cellHeader = ['bgColor' => '66BBFF'];
        $center = ['alignment' => 'center'];
        $table->addCell(800, $cellHeader)->addText('No', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Kode', $headerStyle, $center);
        $table->addCell(1000, $cellHeader)->addText('NUP', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Kode Register', $headerStyle, $center);
        $table->addCell(4000, $cellHeader)->addText('Nama Barang', $headerStyle, $center);
        $table->addCell(1000, $cellHeader)->addText('Merk', $headerStyle, $center);
        $table->addCell(1000, $cellHeader)->addText('Status', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Lokasi', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Kondisi', $headerStyle, $center);

        $no = 1;
        $data_barang = Barang::with('lokasi')
            ->get();

        foreach ($data_barang as $b) {
            $table->addRow();
            $table->addCell()->addText($no++, [], $center);
            $table->addCell()->addText($b->kode_barang);
            $table->addCell()->addText($b->nup);
            $table->addCell()->addText($b->kode_register);
            $table->addCell()->addText($b->nama_barang);
            $table->addCell()->addText($b->merk);
            $table->addCell()->addText($b->status_bmn);
            $table->addCell()->addText($b->lokasi->nama_ruang ?? '-');
            $table->addCell()->addText($b->kondisi);
        }
        $table->addRow();
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);

        $section->addTextBreak(2);

        // B. Maintenance
        $section->addText('B. Maintenance', ['bold' => true]);
        $table = $section->addTable('tableStyle');
        $table->addRow();
        $table->addCell(1000, $cellHeader)->addText('No', $headerStyle, $center);
        $table->addCell(8000, $cellHeader)->addText('Barang', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Tanggal', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Jenis', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Biaya', $headerStyle, $center);

        $no = 1;
        $data_mainten = Maintenance::with('barang')
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereDate('tanggal', '>=', $start)
                    ->whereDate('tanggal', '<=', $end);
            })
            ->get();

        foreach ($data_mainten as $m) {
            $table->addRow();
            $table->addCell()->addText($no++, [], $center);
            $table->addCell()->addText($m->barang->nama_barang ?? '-');
            $table->addCell()->addText($m->tanggal);
            $table->addCell()->addText($m->jenis);
            $table->addCell()->addText($m->biaya);
        }
        $table->addRow();
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $section->addTextBreak();

        // C. RKBMN
        $section->addText('C. RKBMN', ['bold' => true]);
        $table = $section->addTable('tableStyle');
        $table->addRow();
        $table->addCell(1000, $cellHeader)->addText('No', $headerStyle, $center);
        $table->addCell(8000, $cellHeader)->addText('Barang', $headerStyle, $center);
        $table->addCell(3000, $cellHeader)->addText('Rekomendasi', $headerStyle, $center);
        $table->addCell(2000, $cellHeader)->addText('Prioritas', $headerStyle, $center);
        $table->addCell(8000, $cellHeader)->addText('Alasan', $headerStyle, $center);

        $no = 1;
        $data_rkbmn = Rkbmn::with('barang')
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end);
            })
            ->get();

        foreach ($data_rkbmn as $r) {
            $table->addRow();
            $table->addCell()->addText($no++, [], $center);
            $table->addCell()->addText($r->barang->nama_barang ?? '-');
            $table->addCell()->addText($r->jenis_rekomendasi);
            $table->addCell()->addText($r->prioritas);
            $table->addCell()->addText($r->alasan);
        }
        $table->addRow();
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $table->addCell()->addText('', $headerStyle, $center);
        $section->addTextBreak();
        //TTD
        $this->tandaTangan($section);

        return $this->download($phpWord, 'laporan_semua.docx');
    }

    // =========================
    // HELPER DOWNLOAD
    // =========================
    private function download($phpWord, $filename)
    {
        // $path = storage_path($filename);
        $path = sys_get_temp_dir() . '/' . uniqid() . '-' . $filename;
        IOFactory::createWriter($phpWord, 'Word2007')->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
