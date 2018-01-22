<?php

namespace App\Repositories;

use App\Models\User;
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

    /**
     * insert new user to database
     *
     * @param  App\Models\User $user
     * @return int
     */
    public function updateUser($user)
    {
        return DB::table('users')
            ->where('id', $user->id)
            ->update(['token' => $user->token]);
    }

    /**
     * get user by email
     *
     * @param  String $email
     * @return App\Models\User
     */
    public function getUserByEmail($email)
    {
        $userTable = DB::table('users')
            ->where('email', '=', $email)
            ->first();

        if ($userTable) {
            $user            = new User();
            $user->id        = $userTable->id;
            $user->userName  = $userTable->username;
            $user->email     = $userTable->email;
            $user->phone     = $userTable->phone;
            $user->firstName = $userTable->first_name;
            $user->lastName  = $userTable->last_name;
            $user->address   = $userTable->address;
            $user->token     = $userTable->token;
            $user->birthday  = $userTable->birthday;
            $user->password  = $userTable->password;
            return $user;
        }
        return null;

    }

    public function getUserByToken($token)
    {
        $userTable = DB::table('users')
            ->where('token', '=', $token)
            ->first();
        if ($userTable) {
            $user            = new User();
            $user->id        = $userTable->id;
            $user->userName  = $userTable->username;
            $user->email     = $userTable->email;
            $user->phone     = $userTable->phone;
            $user->firstName = $userTable->first_name;
            $user->lastName  = $userTable->last_name;
            $user->address   = $userTable->address;
            $user->token     = $userTable->token;
            $user->birthday  = $userTable->birthday;
            $user->password  = $userTable->password;
            return $user;
        }
        return null;

    }

}
