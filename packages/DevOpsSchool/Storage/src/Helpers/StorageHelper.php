<?php

namespace Storage\Helpers;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

use Storage\Models\Storage; 

class StorageHelper
{
    public $s3;

    public function __construct(){
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-2',
            'credentials' => array('key' => env('S3_KEY'),
                'secret' => env('S3_Secret'))
        ]);
    }

    public function addObject($request){

        try {

            $addObject = $this->s3->putObject([
                'Bucket' => env('S3_bucket'),
                'Key'    => $request['file']['filename'],
                'Body'   => fopen($request['file']['path'], "rb"),
                'ACL'    => 'public-read'
            ]);

            if($addObject){

                return ['message' => 'success', 'data' => $request['file']['filename'], 'status_code' => 200];
            } else{
    
                return ['message' => 'failed', 'data' => 'unable to upload', 'status_code' => 500];
            }
    

        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }

    }

    public function listObjects(){

        try {

            $listObject = $this->s3->listObjects([ 'Bucket' => env('S3_bucket') ]);


            if($listObject){

                return ['message' => 'success', 'data' => $listObject['Contents'], 'status_code' => 200];
            } else{
    
                return ['message' => 'failed', 'data' => 'unable to list', 'status_code' => 500];
            }
    

        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }

    }
    
}