<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UsersInterface
{
     /**
     * Get Users
     * 
     * @method  Get api/users
     * @access  private
     */
    public function getUsers();

    /**
     * Get Users Details
     * 
     * @method  Get api/user_details
     * @access  private
     */
    public function getUserDetails(Request $request);

    /**
     * Post Users Details
     * 
     * @method  Post api/user_details
     * @access  private
     */
    public function addUserDetails(Request $request);
}
