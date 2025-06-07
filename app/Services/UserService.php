<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $users = $this->userRepository = $userRepository;

        $this->userRepository = $users;
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function deleteUser($id)
    {
        $this->userRepository->delete($id);
    }

    public function updateUser(array $data)
    {
        return $this->userRepository->update($data);
    }
}
