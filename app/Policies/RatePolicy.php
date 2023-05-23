<?php

namespace App\Policies;

use App\Models\Rate;
use App\Models\Room;
use App\Models\User;

class RatePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Rate $rate)
    {
        return $user->id == $rate->user_id;
    }

    public function delete(User $user, Rate $rate)
    {
        return $user->id == $rate->user_id;
    }
}
