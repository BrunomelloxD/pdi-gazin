<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Services\UserService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserServiceTest extends TestCase
{
    protected $service;
    protected $mockRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = Mockery::mock(UserRepository::class);
        $this->service = new UserService($this->mockRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_can_get_all_users_when_users_exist()
    {
        $user1 = new \stdClass();
        $user1->id = 1;
        $user1->name = 'Bruno Mello';
        $user1->email = 'bruno@test.com';

        $user2 = new \stdClass();
        $user2->id = 2;
        $user2->name = 'Jane Doe';
        $user2->email = 'jane@test.com';

        $users = new Collection([$user1, $user2]);

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($users);

        $result = $this->service->getAllUsers();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertEquals('Bruno Mello', $result->first()->name);
    }

    public function test_returns_empty_collection_when_no_users_found()
    {
        $emptyUsers = new Collection([]);

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($emptyUsers);

        $result = $this->service->getAllUsers();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->isEmpty());
    }

    public function test_repository_all_method_is_called_exactly_once()
    {
        $users = new Collection([]);

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($users);

        $result = $this->service->getAllUsers();

        $this->assertInstanceOf(Collection::class, $result);
    }

    public function test_can_get_user_by_id_when_user_exists()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Bruno Mello';
        $user->email = 'bruno@test.com';

        $this->mockRepository->shouldReceive('find')->with(1)->andReturn($user);

        $result = $this->service->getUserById(1);

        $this->assertNotNull($result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Bruno Mello', $result->name);
        $this->assertEquals('bruno@test.com', $result->email);
    }


    public function test_returns_null_when_user_not_found()
    {
        $this->mockRepository
            ->shouldReceive('find')
            ->with(999)
            ->andReturn(null);

        $result = $this->service->getUserById(999);

        $this->assertNull($result);
    }

    public function test_can_update_user()
    {
        $data = [
            'id' => 1,
            'name' => 'Bruno Atualizado',
            'email' => 'brunoatualizado@test.com'
        ];

        $user = new User();
        $user->id = $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];

        $this->mockRepository
            ->shouldReceive('update')
            ->with($data)
            ->once()
            ->andReturn($user);

        $result = $this->service->updateUser($data);

        $this->assertNotNull($result);
        $this->assertEquals($data['id'], $result->id);
        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['email'], $result->email);
    }
}
