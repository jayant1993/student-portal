<?php

namespace Portal\Models;

use Moloquent\Eloquent\Model as Eloquent;

class Topic extends Eloquent
{
    
    protected $fillable = [
        'id', 'course_id', 'topic_name', 'price','status'
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
         $result = $this::where(key($parameter['filters']), $parameter['filters'][key($parameter['filters'])])->project(["_id" => 0])->first($parameter['topic_data']);
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
             ->update($parameter['topic_data']);
             return $result;
        } catch(Exception $e){
             return false;
        }
 
    }
 
 
 
    public function deleteOne($id)
    {
        try{
             $result_topic = $this::where('id', $id)->delete();
             
             if($result_topic){
                     return true;
             } else{
                 return false;
             }
 
        } catch(Exception $e){
             return false;
        }
 
    }
}