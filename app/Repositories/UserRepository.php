<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Delete a user by their ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if the user was successfully deleted, false otherwise.
     */
    public function delete(int $id): bool
    {
        return User::destroy($id);
    }

    public function update(array $data): User
    {
        User::where('id', $data['id'])->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => isset($data['password']) ? bcrypt($data['password']) : null,
        ]);
        return User::find($data['id']);
    }
}
