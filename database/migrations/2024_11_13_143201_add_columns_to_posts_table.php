<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add the missing 'category' column if it's not present
            if (!Schema::hasColumn('posts', 'category')) {
                $table->string('category')->after('content');
            }

            // Add 'slug' and 'author' columns
            $table->string('slug')->nullable()->after('title');
            $table->string('author')->nullable()->after('category');
            
            // Add 'image' column
            $table->string('image')->nullable()->after('author');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop columns only if they exist
            if (Schema::hasColumn('posts', 'slug')) {
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('posts', 'author')) {
                $table->dropColumn('author');
            }

            if (Schema::hasColumn('posts', 'category')) {
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('posts', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
}
