<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\updateservice;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function upload(Request  $request){
        $fileObj = $request['file'];
        $remoteDir = config("filesystems.disks.oss.ad_upload_dir");
        $res=Updateservice::doUpload($fileObj,$remoteDir);
        return $res ;
    }
}
