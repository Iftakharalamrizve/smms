<?php

namespace Tests\Feature;

use App\Services\QueueService;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgentQueueTest extends TestCase
{
    use RefreshDatabase; // If you need to use a database during testing 
}
