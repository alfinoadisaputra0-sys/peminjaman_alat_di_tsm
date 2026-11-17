
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('peminjamen')
            ->where('status', 'dipinjam')
            ->update(['status' => 'disetujui']);

        DB::statement("
            ALTER TABLE peminjamen
            MODIFY status ENUM(
                'menunggu',
                'disetujui',
                'ditolak',
                'dikembalikan'
            ) NOT NULL DEFAULT 'menunggu'
        ");
    }

    public function down(): void
    {
        DB::table('peminjamen')
            ->whereIn('status', ['menunggu', 'ditolak', 'disetujui'])
            ->update(['status' => 'dipinjam']);

        DB::statement("
            ALTER TABLE peminjamen
            MODIFY status ENUM(
                'dipinjam',
                'dikembalikan'
            ) NOT NULL DEFAULT 'dipinjam'
        ");
    }
};
