<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToLaundriesTable extends Migration
{
  public function up()
  {
    Schema::table('laundries', function (Blueprint $table) {
      $table->text('description')->nullable()->after('service_id');
    });
  }

  public function down()
  {
    Schema::table('laundries', function (Blueprint $table) {
      $table->dropColumn('description');
    });
  }
}
