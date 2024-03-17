<?php
namespace App\Lib;

use App\Models\User;
use Illuminate\Support\Facades\DB;

Class Helper {
    
    public static function encryptData($plain_data, $salt) {

        $encryption_key = substr(hash('sha256', $salt), 0, 32);

        $iv = openssl_random_pseudo_bytes(16);

        $encrypted_data = openssl_encrypt($plain_data, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);

        $encrypted_data_with_iv = $iv . $encrypted_data;

        return base64_encode($encrypted_data_with_iv);

    }

    public static function decryptData($encrypted_data, $salt) {

        $encryption_key = substr(hash('sha256', $salt), 0, 32);
    
        $encrypted_data_with_iv = base64_decode($encrypted_data);
    
        $iv = substr($encrypted_data_with_iv, 0, 16); 
        $encrypted_data = substr($encrypted_data_with_iv, 16);
    
        $decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
    
        return $decrypted_data;
    }

    public static function getUserKey($id) {

      $salt_query = User::getSalt(); 
      $salt = DB::select($salt_query, [$id]);
      if (empty($salt)) {
        return [];
      }
      return $salt[0]->salt;
      
    }
}