<?php

namespace App\Repository;
use App\User;

class UserRepository
{
    public function verify($token = '')
    {
        $user = User::where('email_token', $token)->first();
        $user->verified = 1;
        if ($user->save()) {
            return TRUE;
        }
        return FALSE;
    }
    
    public function getByToken($token = '')
    {
        $user = User::where('email_token', $token)->first();
        return $user;
    }
    
    public function getById($id = NULL){
        if($id){
            return User::find($id);
        }
        
        return FALSE;
    }
}
