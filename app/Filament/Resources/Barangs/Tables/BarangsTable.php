<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangImport;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use App\Models\Lokasi;
use App\Services\VercelBlobService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;
use Illuminate\Support\Facades\File;


class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions(
                [
                    Action::make('import')
                        ->label('Import Excel')
                        ->color('success')
                        ->icon('heroicon-o-arrow-up-tray')
                        ->form([
                            FileUpload::make('file')
                                ->required()
                                ->disk('tmp')
                                ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv'])
                        ])
                        ->action(function (array $data, VercelBlobService $service) {
                            $filePath  = $data['file'];
                            $disk = Storage::disk('tmp');
                            $fullPath = $disk->path($filePath);
                            $fileObject = new UploadedFile($fullPath, basename($fullPath), File::mimeType($fullPath), null, true);
                            try {
                                // Panggil service kita
                                $service->upload($fileObject, 'tmp');
                                // Import Excel dari URL
                                //    Excel::import(new BarangImport, $fullPath);
                                //    $disk->delete($filePath);

                                Notification::make()
                                    ->title('Berhasil!')
                                    ->body('Data berhasil diimpor.')
                                    ->success()
                                    ->send();
                            } catch (Exception $e) {
                                // Tangani error jika upload gagal
                                // Contoh: Log error atau tampilkan pesan kepada pengguna
                                throw new Exception("Gagal unggah ke Data: " . $e->getMessage());
                            }
                        }),
                    Action::make('download_template')
                        ->label('Download Template')
                        ->color('secondary')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(route('template.download'), true)
                        ->openUrlInNewTab()
                ]
            )
            ->columns([
                TextColumn::make('kode_barang')
                    ->label('Kode Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nup')
                    ->label('NUP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('merk')
                    ->label('Merk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kode_register')
                    ->label('Kode Register')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('status_bmn')
                    ->label('Status')
                    ->colors([
                        'success' => 'Aktif',
                        'danger' => 'Tidak Aktif',
                    ])
                    ->sortable()
                    ->searchable(),
                TextColumn::make('lokasi.nama_ruang')
                    ->label('Lokasi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pegawai.nama')
                    ->label('Pengguna')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('kondisi')
                    ->sortable()
                    ->searchable()
                    ->colors([
                        'success' => 'Baik',
                        'warning' => 'Rusak Ringan',
                        'danger' => 'Rusak Berat',
                    ]),
            ])
            ->filters([
                SelectFilter::make('kondisi')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat' => 'Rusak Berat',
                    ]),
                SelectFilter::make('lokasi_id')
                    ->label('Lokasi')
                    ->options(
                        Lokasi::orderBy('kode_ruang')
                            ->get()
                            ->mapWithKeys(fn($item) => [
                                $item->id => $item->kode_ruang . ' - ' . $item->nama_ruang
                            ])
                    )
                    ->searchable()
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),

            ]);
    }
}
