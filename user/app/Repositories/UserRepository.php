<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{

    /**
     * insert new user to database
     *
     * @param  App\Models\User $user
     * @return int
     */
    public function newUser($user)
    {
        return DB::table('users')->insertGetId(
            [
                'email'      => $user->email,
                'password'   => $user->password,
                'username'   => $user->userName,
                'is_active'  => $user->isActive,
                'is_delete'  => $user->isDelete,
                'created_at' => Carbon::now(),
                'token'      => $user->token,
            ]
        );
    }

}
