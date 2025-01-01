<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->boolean('block')->default(false)->comment('0 (false) = active , 1(true) = blocked');

            $table->foreignId('role_id')->nullable()->constrained('roles');

            $table->string('profile_photo_path', 2048)->nullable();

            $table->integer('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable()->references('id')->on('users');
            $table->integer('deleted_by')->nullable()->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'name'              =>  'Admin',
                'email'             =>  'admin@admin.com',
                'email_verified_at' =>  now(),
                'password'          =>  '$2y$10$Ra1gm7.5KspMfuH6Ovc0nOToG1CKKCtnCBJXDwbYaX2MYY9tdyUJK', #admin@admin.com
                'block'             =>  false,
                'role_id'           =>  '1',
                'created_at'        =>  now(),
                'updated_at'        =>  now(),
                'created_by'        =>  '0'
            ],

            [
                'name'              =>  'User',
                'email'             =>  'user@user.com',
                'email_verified_at' =>  now(),
                'password'          =>  '$2y$10$qgsvHOwuCHOrnksxg2drMux5vRRwQHI1SfBkZFOfektDu0XNyhOWO', #user@user.com
                'block'             =>  false,
                'role_id'           =>  '2',
                'created_at'        =>  now(),
                'updated_at'        =>  now(),
                'created_by'        =>  '0'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
