<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthInterface
{
    /**
     * Post signup
     * 
     * @method  Post api/signup
     * @access  public
     */
    public function signup(Request $request);

    /**
     * Post Auth
     * 
     * @method  Post api/login
     * @access  public
     */
    public function auth(Request $request);

    /**
     * Post Logout
     * 
     * @method  GET api/auth/logout
     * @access  public
     */
    public function logout();
}
