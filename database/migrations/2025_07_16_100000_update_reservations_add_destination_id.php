<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('destination_id')->nullable()->after('email');
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('set null');
            $table->dropColumn('destination');
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('destination')->nullable()->after('email');
            $table->dropForeign(['destination_id']);
            $table->dropColumn('destination_id');
        });
    }
};
