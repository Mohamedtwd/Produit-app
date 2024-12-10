<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->bigInteger("product_id");
            $table->integer("Quantité");
            $table->decimal("prix", 10, 2);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
