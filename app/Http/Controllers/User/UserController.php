<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member\User;

/**
 * @OA\Get(
 *    path="/api/user",
 *    summary="Get all Users",
 *    description="Retrieve a list of all Users",
 *    tags={"Transaction"},
 *    @OA\Response(
 *      response=200,
 *      description="Successful operation",

 *    ),
 *    security={{"bearerAuth": {}}}
 * ),
**/

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return $users;
    }
}
