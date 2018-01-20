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
    
    public function update($data,$id){
        
        $user = User::find($id);
            $user->name       = $data->name;
            $user->email      = $data->email;
            if(isset($data->password)){
                $user->password = bcrypt($data->password);
            }
            if(isset($data->pp_image_path)){
                $user->pp_image = $data->pp_image_path;
            }
            $user->phone_number = $data->phone_number;
            $user->save();
        
    }
}
