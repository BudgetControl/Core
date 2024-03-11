<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) { $table->integer('workspace_id'); });
        Schema::table('budgets', function (Blueprint $table) { $table->integer('workspace_id'); });
        Schema::table('entries', function (Blueprint $table) { $table->integer('workspace_id'); });
        Schema::table('labels', function (Blueprint $table) { $table->integer('workspace_id');});
        Schema::table('models', function (Blueprint $table) { $table->integer('workspace_id'); });
        Schema::table('payees', function (Blueprint $table) { $table->integer('workspace_id'); });
        Schema::table('planned_entries', function (Blueprint $table) { $table->integer('workspace_id'); });
        Schema::table('sub_categories', function (Blueprint $table) { $table->integer('workspace_id'); });
        Schema::table('user_settings', function (Blueprint $table) { $table->integer('workspace_id'); });

        Schema::table('accounts', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('budgets', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('entries', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('labels', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('models', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('payees', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('planned_entries', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('sub_categories', function (Blueprint $table) { $table->dropColumn(['user_id']); });
        Schema::table('user_settings', function (Blueprint $table) { $table->dropColumn(['user_id']); });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('budgets', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('entries', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('labels', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('models', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('payees', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('planned_entries', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('sub_categories', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        Schema::table('user_settings', function (Blueprint $table) { $table->dropColumn(['workspace_id']); });
        
        Schema::table('accounts', function (Blueprint $table) { $table->integer('user_id'); });
        Schema::table('budgets', function (Blueprint $table) { $table->integer('user_id'); });
        Schema::table('entries', function (Blueprint $table) { $table->integer('user_id'); });
        Schema::table('labels', function (Blueprint $table) { $table->integer('user_id');});
        Schema::table('models', function (Blueprint $table) { $table->integer('user_id'); });
        Schema::table('payees', function (Blueprint $table) { $table->integer('user_id'); });
        Schema::table('planned_entries', function (Blueprint $table) { $table->integer('user_id'); });
        Schema::table('sub_categories', function (Blueprint $table) { $table->integer('user_id'); });
        Schema::table('user_settings', function (Blueprint $table) { $table->integer('user_id'); });


    }
};
