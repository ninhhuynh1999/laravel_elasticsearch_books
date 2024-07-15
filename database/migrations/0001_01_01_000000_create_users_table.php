<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Fluent;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP TYPE IF EXISTS user_role');
        DB::statement('DROP TYPE IF EXISTS gender');
        DB::statement("CREATE TYPE user_role AS ENUM ('admin', 'staff')");
        DB::statement("CREATE TYPE gender AS ENUM ('male', 'female', 'other')");
        Grammar::macro('typeUserRole', fn () =>  'user_role');
        Grammar::macro('typeGender', fn () =>  'gender');
        // Grammar::macro('typeUserRole', function () {
        //     return 'user_role';
        // });

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->addColumn('gender', 'gender')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('profile_image', 255)->nullable();
            // $table->string('role', 100);
            $table->addColumn('userRole', 'role');
            $table->boolean('is_active')->default(true);
            $table->text('address')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

        DB::statement('DROP TYPE IF EXISTS user_role');
        DB::statement('DROP TYPE IF EXISTS gender');
    }
};
