<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_type', function (Blueprint $table) {
            $table->id();
            $table->integer('industry_id');
            $table->string('feedback_type');
            $table->enum('status',['0','1'])->default("0")->comment("0 for Active, 1 for Inactive");
            $table->enum('is_deleted',['Y','N'])->default("N")->comment("Y for deleted, N for not deleted");
            $table->integer('add_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_type');
    }
}
