<?php

use App\Models\Lending;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lendings', function (Blueprint $table) {
            $table->primary(['user_id', 'copy_id', 'start']);
            //létrehozza a mezőt és össze is köti a megf. tábla megf. mezőjével
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('copy_id')->references('copy_id')->on('copies');
            $table->date('start');
            $table->date('end')->nullable();
            $table->tinyInteger('extension')->default(0);
            $table->integer('notice')->default(0);
            $table->timestamps();
            
        });
        
        DB::statement("ALTER TABLE lendings ADD CONSTRAINT check_dates CHECK (start > '2022-12-06')");

        Lending::create(['user_id'=> 2, 'copy_id' => 1, 'start'=> '2022-12-07', 'end'=>'2022-11-02', 'notice'=>1]);
        Lending::create(['user_id'=> 3, 'copy_id' => 6, 'start'=> '2023-01-12', 'notice'=>0]);
        Lending::create(['user_id'=> 2, 'copy_id' => 1, 'start'=> '2023-10-08', 'end'=>'2022-11-06', 'notice'=>0]);
        Lending::create(['user_id'=> 3, 'copy_id' => 6, 'start'=> '2023-11-10', 'end'=>'2022-11-08','notice'=>1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lendings');
    }
};
