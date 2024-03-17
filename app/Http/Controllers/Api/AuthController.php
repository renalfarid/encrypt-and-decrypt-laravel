<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\AuthInterface;
use App\Repositories\AuthRepository;

class AuthController extends Controller
{
  protected $AuthRepositoryInterface;
  /**
     * Create a new constructor for this controller
     */
    public function __construct(AuthInterface $AuthRepositoryInterface)
    {
        $this->AuthRepositoryInterface = $AuthRepositoryInterface;
    }

  public function auth(Request $request) {
    return $this->AuthRepositoryInterface->auth($request);
  }

  public function signup(Request $request) {
    return $this->AuthRepositoryInterface->signup(($request));
  }

  public function logout() {
    return $this->AuthRepositoryInterface->logout();
  }
}
