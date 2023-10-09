<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('discount');
            $table->date('c_date')->comment('create_date');
            $table->date('e_date')->comment('end_date');
            $table->integer('type')->comment('0: sabit indirim 1: yüzdelik indirim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
