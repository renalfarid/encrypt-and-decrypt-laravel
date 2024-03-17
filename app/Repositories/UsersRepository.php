<?php
namespace App\Repositories;

use App\Http\Resources\Resource\UserResource;
use App\Interfaces\UsersInterface;
use App\Lib\Helper;
use App\Models\User;
use App\Models\UserDetails;
use App\Trait\ResponseApiTrait;
use Illuminate\Http\Request;

class Usersrepository implements UsersInterface {
  use ResponseApiTrait;

  public function getUsers() {
    $users = User::all();

    $decryptedUsers = $users->map(function ($user) {
      $decryptedName = Helper::decryptData($user->name, $user->salt);
      $decryptedEmail = Helper::decryptData($user->email, $user->salt);

      // Update the user object with decrypted values
      $user->name = $decryptedName;
      $user->email = $decryptedEmail;

      return $user;
    });

    //$user_collection = new UserResource($users);

    return $this->success("Users data", $decryptedUsers);
  }

  public function getUserDetails(Request $request) 
  {
    try {

        $id = $request->input('id');
        $user_details = UserDetails::userDetailsById($id)->get();
        if(!$user_details) return $this->error("No user details with ID $id", 404);

        $decrypt_details = $user_details->map(function ($details) {
          $salt = Helper::getUserKey($details->user_id);
          $decrypt_full_name = Helper::decryptData($details->full_name, $salt);
          $decrypt_id_card_number = Helper::decryptData($details->id_card_number, $salt);
          $decrypt_address= Helper::decryptData($details->address, $salt);
          $decrypt_birth_date = Helper::decryptData($details->birth_date, $salt);
          $details->full_name = $decrypt_full_name;
          $details->address = $decrypt_address;
          $details->id_card_number = $decrypt_id_card_number;
          $details->birth_date = $decrypt_birth_date;

          return $details;

        });

        return $this->success("User Detail", $decrypt_details);

    } catch (\Exception $e) {
        return $this->error($e->getMessage(), $e->getCode());
    }
    
  }

  public function addUserDetails(Request $request)
  {

    try {
        
        $user_id = $request->input('user_id');
        $full_name = $request->input('full_name');
        $address = $request->input('address');
        $id_card_number = $request->input('id_card_number');
        $birth_date = $request->input('birth_date');

        $salt = Helper::getUserKey($user_id);

        UserDetails::create([
            'user_id' => $user_id,
            'full_name' => Helper::encryptData($full_name, $salt),
            'address' => Helper::encryptData($address, $salt),
            'id_card_number' => Helper::encryptData($id_card_number, $salt),
            'birth_date' => Helper::encryptData($birth_date, $salt),
        ]);
        $response = UserDetails::where('user_id', $user_id)->first();
        return $this->success("user details success !", $response);

    } catch (\Exception $e) {
        return $this->error($e->getMessage(), $e->getCode());
    }
  }
}