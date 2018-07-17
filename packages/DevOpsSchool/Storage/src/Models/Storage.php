<?php

namespace Storage\Models;

use Moloquent\Eloquent\Model as Eloquent;

class Storage extends Eloquent
{

    protected $collection = 'storage';

    protected $fillable = [
        'id','course_name', 'status'
    ];


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
         $result = $this::where(key($parameter['filters']), $parameter['filters'][key($parameter['filters'])])->project(["_id" => 0])->first($parameter['course_data']);
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
             ->update($parameter['course_data']);
             return $result;
        } catch(Exception $e){
             return false;
        }
 
    }
 
 
 
    public function deleteOne($id)
    {
        try{
             $result_courses = $this::where('id', $id)->delete();
             
             if($result_courses){
                     return true;
             } else{
                 return false;
             }
 
        } catch(Exception $e){
             return false;
        }
 
    }

}