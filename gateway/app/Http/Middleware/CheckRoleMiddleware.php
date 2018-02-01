<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Enums\ErrorCode;
use App\Enums\Role;
class CheckRoleMiddleware
{
   
    public function __construct()
    {
        #
    }

    private function retriveRole($request){
        $role = '';
        switch (strtolower($request->method())) {
            case 'post':
                $role =  'create';
                break;
            case 'put':
                $role =  'update';
                break;
            case 'delete':
                $role =  'delete';
                break;
            default:
                $role = 'view';
                break;
        }  
        return $role;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $path = $request->path();
        if(isset($user->feature->$path)){
            $nameRole = $this->retriveRole($request);
            if($user->feature->$path->$nameRole == Role::ACCEPT ){
                return $next($request);
            }
        } 

        return response(
            [
                'message'  => ErrorCode::PERMISSION_DENIED,
                'data'     => ErrorCode::PERMISSION_DENIED
            ], 
            ErrorCode::FORBIDDEN
        );
    }
}
