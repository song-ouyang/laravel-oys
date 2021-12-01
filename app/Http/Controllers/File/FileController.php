<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Models\Updateservice;
use App\Models\Upload;
use App\services\OSS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OSS\Core\OssException;
use OSS\Core\OssUtil;
use OSS\OssClient;

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


    //上传框架
    public function downloadfile(Request $request){
        $filepath = $request['file1'];
        if($filepath!=null)
        {
            echo view('aetherupload::example');
            echo '<a href="/aetherupload/display/' . $filepath . '" target="_blank"><h3>预览</h3></a>' . PHP_EOL;
            echo '<a href="/aetherupload/download/' . $filepath. '/newname"><h3>下载</h3></a>' . PHP_EOL;
            echo '<a href="http://oys68.cn/"><h3>退出</h3></a>' . PHP_EOL;
        }
        else
        {
         echo view('aetherupload::example');
        }
    }

    //分片上传阿里
    public function uposs(Request $request){
        $uploadFile = $request['file'];
        $accessKeyId = config("filesystems.disks.oss.access_id");
        $accessKeySecret =config("filesystems.disks.oss.access_key");
        $endpoint  =config("filesystems.disks.oss.endpoint");
        $bucket =config("filesystems.disks.oss.bucket");
        $fileName = rand(1000,9999) . $uploadFile->getFilename() . time() .date('ymd') . '.' . $uploadFile->getClientOriginalExtension();
        $object = date('Y-m/d').'/'.$fileName;
         // 步骤1：初始化一个分片上传事件，获取uploadId。
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        //返回uploadId。uploadId是分片上传事件的唯一标识，您可以根据uploadId发起相关的操作，如取消分片上传、查询分片上传等。
        $uploadId = $ossClient->initiateMultipartUpload($bucket, $object);
        print(".....初始化分片事件成功,"."uploadId为:". $uploadId."\n");
        $partSize = 10 * 1024 * 1024;
        $uploadFileSize = filesize($uploadFile);
        $pieces = $ossClient->generateMultiuploadParts($uploadFileSize, $partSize);
        $responseUploadPart = array();
        $uploadPosition = 0;
        $isCheckMd5 = true;
        foreach ($pieces as $i => $piece) {
            $fromPos = $uploadPosition + (integer)$piece[$ossClient::OSS_SEEK_TO];
            $toPos = (integer)$piece[$ossClient::OSS_LENGTH] + $fromPos - 1;
            $upOptions = array(
                // 上传文件。
                $ossClient::OSS_FILE_UPLOAD => $uploadFile,
                // 设置分片号。
                $ossClient::OSS_PART_NUM => ($i + 1),
                // 指定分片上传起始位置。
                $ossClient::OSS_SEEK_TO => $fromPos,
                // 指定文件长度。
                $ossClient::OSS_LENGTH => $toPos - $fromPos + 1,
                // 是否开启MD5校验，true为开启。
                $ossClient::OSS_CHECK_MD5 => $isCheckMd5,
            );
            // 开启MD5校验。
            if ($isCheckMd5) {
                $contentMd5 = OssUtil::getMd5SumForFile($uploadFile, $fromPos, $toPos);
                $upOptions[$ossClient::OSS_CONTENT_MD5] = $contentMd5;
            }
                // 上传分片。
                $res=  $responseUploadPart[] = $ossClient->uploadPart($bucket, $object, $uploadId, $upOptions);
            printf( "第{$i}部分 加载成功\n");
        }
        $uploadParts = array();
        foreach ($responseUploadPart as $i => $eTag) {
            $uploadParts[] = array(
                'PartNumber' => ($i + 1),
                'ETag' => $eTag,
            );
        }
        //步骤3：完成上传
       // 执行completeMultipartUpload操作时，需要提供所有有效的$uploadParts。OSS收到提交的$uploadParts后，会逐一验证每个分片的有效性。当所有的数据分片验证通过后，OSS将把这些分片组合成一个完整的文件。
        $ossClient->completeMultipartUpload($bucket, $object, $uploadId, $uploadParts);
        printf( "分片合并成功，已完成上传\n");
        //步骤4:获取url
        $Url = OSS::getPublicObjectURL('test-oys',$object);
        return $Url?
                json_success('上传成功!',$Url,  200):
                json_fail('上传失败',null, 100 );
    }
}
