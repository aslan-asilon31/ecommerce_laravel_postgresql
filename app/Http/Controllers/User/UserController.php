<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return $users;
    }
}
