<?php

namespace FF\NovaTools\Core\Setting;

use FF\User\Contracts\User;

class SettingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user)
    {
        return $user->checkPurview(['admin']);
    }

    public function delete(User $user): bool
    {
        return false;
    }

    public function forceDelete(User $user): bool
    {
        return false;
    }

    public function restore(User $user): bool
    {
        return false;
    }
}