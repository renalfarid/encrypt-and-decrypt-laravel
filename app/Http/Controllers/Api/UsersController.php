<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\UsersInterface;
use Illuminate\Http\Request;

class UsersController extends Controller {
    protected $UserRepositoryInterface;

    public function __construct(UsersInterface $userRepositoryInterface)
    {
        $this->UserRepositoryInterface = $userRepositoryInterface;
    }

    public function getUsers() {
        return $this->UserRepositoryInterface->getUsers();
    }

    public function getUserDetails(Request $request) {
        return $this->UserRepositoryInterface->getUserDetails($request);
    }

    public function addUserDetails(Request $request) 
    {
        return $this->UserRepositoryInterface->addUserDetails($request);
    }
}