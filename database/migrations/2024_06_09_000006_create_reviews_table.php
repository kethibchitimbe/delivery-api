<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('restaurant_id')->constrained('restaurants');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
} 