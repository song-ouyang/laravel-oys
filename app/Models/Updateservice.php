<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Updateservice extends Model
{
    //上传文件
    public static function doUpload($fileObj,$remoteDir){
        $path = $fileObj->store($remoteDir,'oss');
        $imgUrl =config("filesystems.disks.oss.endpoint")."/".$path;
        if ( $path ){
            return ["status" => "SUCCESS","fileUrl" => $imgUrl];
        }
        return ["status" => "ERROR","fileUrl" => ""];
    }

    //删除文件
    public function deleteImg($imgUrl){
        $path = str_replace("http://","","$imgUrl");
        $pos = strpos($path,"/");
        $imgUrl = substr($path,$pos+1);
        $isExist = Storage::exists($imgUrl);
        if (!$isExist){
            return true;
        }
        $res = Storage::delete($imgUrl);
        return $res ;
        if(!$res){
            return false;
        }
        return true;
    }
}
