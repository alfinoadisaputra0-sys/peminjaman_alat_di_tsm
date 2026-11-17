
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE peminjamen
            MODIFY status ENUM(
                'menunggu',
                'disetujui',
                'ditolak',
                'pengajuan_pengembalian',
                'dikembalikan'
            ) NOT NULL DEFAULT 'menunggu'
        ");
    }

    public function down(): void
    {
        DB::table('peminjamen')
            ->where('status', 'pengajuan_pengembalian')
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
};
