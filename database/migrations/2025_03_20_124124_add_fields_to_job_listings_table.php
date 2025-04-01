<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //clear table data
        DB::table('job_listings')->truncate();

        //use the nullable method to set a field as optional
        Schema::table('job_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->integer('salary');
            $table->string('tags')->nullable();
            $table->enum('job_type', ['Full-Time', 'Part-Time', 'Contract', 'Temporary', 'Internship', 'Volunteer', 'On-Call'])->default('Full-Time'); 
            $table->boolean('remote')->default(false);
            $table->string('requirements')->nullable();
            $table->string('benefits')->nullable();
            $table->string('address')->nullable();
            $table->string('city');
            $table->string('county');
            $table->string('postal_code')->nullable();
            $table->string('email');
            $table->string('phone_number');
            $table->string('company_name')->nullable();
            $table->string('company_description')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_website')->nullable();

            //add user foreign key constraint - if we delete a user then all of their job listings get deleted as well
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            //drop the foreign key constraint
            $table->dropForeign(['user_id']);

            //drop user_id column
            $table->dropColumn('user_id');
            //drop columns
            $table->dropColumn(['salary', 'tags', 'job_type', 'remote', 'requirements', 'benefits', 'address', 'city', 'county', 'postal_code', 'email', 'phone_number', 'company_name', 'company_description', 'company_logo', 'company_website']);
        });
    }
};