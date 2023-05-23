<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;

class RoomPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Room $room) : bool
    {
        return $user->id === $room->user_id;
    }

    public function delete(User $user, Room $room) : bool
    {
        return $user->id === $room->user_id;
    }

    public function createRate(User $user, Room $room) : bool
    {
        return $user->id != $room->user_id;
    }
}
