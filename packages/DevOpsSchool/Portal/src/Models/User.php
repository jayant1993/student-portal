<?php

namespace Portal\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Moloquent\Eloquent\Model as Eloquent;

class User extends Eloquent implements Authenticatable
{
    use HasApiTokens, Notifiable, AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'email','mobile','username','password','role','access','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * User Operations
     */

    public function pushOne($parameter)
    {
         foreach ($parameter as $key => $value){
             $this->$key = $value;
         }
         try { 
             $this->save();
             unset($this->_id);
             return $this;
         } catch (Exception $ex) {
             return false;
         }
    }
 
 
 
    public function findOne($parameter)
    {
        try{
         $result = $this::where(key($parameter['filters']), $parameter['filters'][key($parameter['filters'])])->project(["_id" => 0])->first($parameter['user_data']);
             return $result;
        } catch(Exception $e){
             return false;
        }
 
    }
 
 
 
    public function findAll($parameter)
    {
         try{
             $result = $this::skip((Integer) $parameter['offset'])->take((Integer) $parameter['count'])->project(["_id" => 0])->get($parameter['parameter']);
             return $result;
        } catch(Exception $e){
             return false;
        }
    }
 
 
 
    public function updateOne($parameter)
    {
        try{
             $result = $this::where('id', $parameter['id'])
             ->update($parameter['user_data']);
             return $result;
        } catch(Exception $e){
             return false;
        }
 
    }
 
 
 
    public function deleteOne($id)
    {
        try{
             $result_users = $this::where('id', $id)->delete();
             
             if($result_users){
                     return true;
             } else{
                 return false;
             }
 
        } catch(Exception $e){
             return false;
        }
 
    }

}
