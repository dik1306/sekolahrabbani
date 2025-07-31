<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TahunAjaranAktif extends Model
{
    use HasFactory;

    protected $table = 'master_tahun_ajaran';
    protected $primaryKey = 'id';

    public $timestamps = false;

    // Menambahkan kolom tahun_ajaran ke dalam fillable
    protected $fillable = [
        'tahun_ajaran', // Tambahkan ini
        'mulai',
        'status',
        'update_date',
        'update_user',
        'status_tampil',
    ];

    // Fungsi untuk memperbarui status_tampil
    public static function updateStatusTampil()
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::today();

        // Mengecek apakah sudah ada tahun ajaran baru yang dimulai pada 1 Agustus tahun ini
        $existingYear = self::where('mulai', $today->format('Y') . '-08-01')->first();

        if (!$existingYear) {
            // Tidak ada tahun ajaran baru, buat tahun ajaran baru
            // Format tahun ajaran (misal: 2025-2026)
            $newYear = $today->year + 1 . '-' . ($today->year + 2);

            // Membuat data tahun ajaran baru
            self::create([
                'tahun_ajaran' => $newYear,
                'mulai' => $today->year. '-08-01',
                'status' => 1,
                'update_date' => Carbon::now(),
                'update_user' => 'system',
                'status_tampil' => 1,  // Menetapkan status_tampil untuk tahun ajaran baru
            ]);
        }

        // Setelah menambah tahun ajaran baru, kita perbarui status_tampil
        // Ambil dua tahun ajaran terbaru berdasarkan tanggal mulai
        $latestTwoYears = self::orderByDesc('mulai')
                              ->take(2)
                              ->get();

        // Set status_tampil menjadi 1 untuk dua tahun ajaran terbaru
        foreach ($latestTwoYears as $year) {
            $year->status_tampil = 1;
            $year->save();
        }

        // Menonaktifkan status_tampil untuk tahun ajaran yang lebih lama
        self::where('status_tampil', 1)
            ->whereNotIn('id', $latestTwoYears->pluck('id')->toArray())  // Mengambil ID tahun ajaran yang lebih lama
            ->update(['status_tampil' => 0]);  // Mengubah status_tampil yang lebih lama menjadi 0
    }
}
