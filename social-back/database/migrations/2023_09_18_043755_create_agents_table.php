<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->char('agent_id', 4)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('nick', 10)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('nick_sound', 8)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('name', 35)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('did', 10)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('language_1', 2)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('EN');
            $table->char('language_2', 2)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('language_3', 2)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('telephone', 12)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('email', 50)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('birth_day', 4)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('altid', 9)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('seat_id', 3)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('password', 64)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('login_pin', 5)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('usertype', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('active', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('Y');
            $table->char('session_id', 13)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('vcc_id', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('partition_id', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('var1', 25)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('var2', 6)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('skillout', 2)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('browser_ip', 15)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('browser_port', 5)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->decimal('max_chat_session', 2, 0)->default(0);
            $table->decimal('chat_session_limit_with_call', 1, 0)->default(0);
            $table->char('always_recv_voice_call', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('')->comment('Keep a dedicated channel for voice call when used with non-voice calls');
            $table->char('supervisor_id', 4)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('role_id', 10)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('screen_logger', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('ob_call', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('gender', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('agent_group', 10)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->char('login_status', 1)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('session_string', 32)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('');
            $table->primary('agent_id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
