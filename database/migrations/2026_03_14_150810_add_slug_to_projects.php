<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        DB::table('projects')
            ->orderBy('id')
            ->select(['id', 'title'])
            ->lazy()
            ->each(function ($project) {
                $base = Str::slug($project->title) ?: 'project';
                $slug = $base;
                $i = 1;

                while (DB::table('projects')->where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }

                DB::table('projects')
                    ->where('id', $project->id)
                    ->update(['slug' => $slug]);
            });

        Schema::table('projects', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
