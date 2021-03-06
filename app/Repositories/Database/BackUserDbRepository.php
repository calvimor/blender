<?php

namespace App\Repositories\Database;

use App\Foundation\Repositories\DbRepository;
use App\Repositories\BackUserRepository;
use App\Services\Auth\Back\Enums\UserRole;
use App\Services\Auth\Back\Enums\UserStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BackUserDbRepository extends DbRepository implements BackUserRepository
{
    public function getAllWithRole(UserRole $role): Collection
    {
        return $this->query()
            ->where('role', $role)
            ->get();
    }

    public function getAllWithRoleAndStatus(UserRole $role, UserStatus $status): Collection
    {
        return $this->query()
            ->where('role', $role)
            ->where('status', $status)
            ->get();
    }

    public function delete(Model $user): bool
    {
        if (current_back_user() && current_back_user()->id === $user->id) {
            abort(406);
        }

        return parent::delete($user);
    }
}
