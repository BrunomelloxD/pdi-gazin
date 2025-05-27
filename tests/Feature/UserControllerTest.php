<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    protected $userServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userServiceMock = Mockery::mock(UserService::class);

        $this->app->instance(UserService::class, $this->userServiceMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndexReturnsUsers()
    {
        $mockUsers = collect([
            ['id' => 1, 'name' => 'User 1', 'email' => 'user1@test.com'],
            ['id' => 2, 'name' => 'User 2', 'email' => 'user2@test.com'],
            ['id' => 3, 'name' => 'User 3', 'email' => 'user3@test.com'],
        ]);

        $this->userServiceMock
            ->shouldReceive('getAllUsers')
            ->andReturn($mockUsers);

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['name' => 'User 1']);
    }

    public function testIndexReturns404WhenNoUsers()
    {
        $this->userServiceMock
            ->shouldReceive('getAllUsers')
            ->once()
            ->andReturn(collect());

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(404);
        $response->assertJson(['status' => 'error', 'message' => 'No users found']);
    }

    public function testFindReturnsUser()
    {
        $user = ['id' => 1, 'name' => 'User 1', 'email' => 'user1@test.com'];

        $this->userServiceMock
            ->shouldReceive('getUserById')
            ->with(1)
            ->andReturn($user);

        $response = $this->getJson('/api/v1/user/1');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'User 1']);
    }

    public function testFindReturns404WhenUserNotFound()
    {
        $this->userServiceMock
            ->shouldReceive('getUserById')
            ->once()
            ->with(999)
            ->andReturn(null);

        $response = $this->getJson('/api/v1/user/999');

        $response->assertStatus(404);
        $response->assertJson(['status' => 'error', 'message' => 'User with id 999 not found']);
    }
}
