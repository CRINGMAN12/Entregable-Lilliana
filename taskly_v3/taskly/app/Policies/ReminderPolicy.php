<?php

namespace App\Policies;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReminderPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Reminder $reminder): bool
    {
        return $user->id === $reminder->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Reminder $reminder): bool
    {
        return $user->id === $reminder->user_id;
    }

    public function delete(User $user, Reminder $reminder): bool
    {
        return $user->id === $reminder->user_id;
    }

    public function restore(User $user, Reminder $reminder): bool
    {
        return $user->id === $reminder->user_id;
    }

    public function forceDelete(User $user, Reminder $reminder): bool
    {
        return $user->id === $reminder->user_id;
    }
} 