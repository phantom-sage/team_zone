<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_team_member', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->foreignId('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('team_member_id')
                ->references('id')
                ->on('team_members')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('project_team_member');
    }
};
