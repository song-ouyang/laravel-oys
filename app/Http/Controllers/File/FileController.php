<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Models\updateservice;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function upload(FileRequest  $request){
        $fileObj = $request['file'];
        $remoteDir = config("filesystems.disks.oss.ad_upload_dir");
        $res=Updateservice::doUpload($fileObj,$remoteDir);
        return $res ?
            json_success('上传成功!', $res, 200) :
            json_fail('上传失败!', null, 100);
    }
}
