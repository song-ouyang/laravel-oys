<?php

namespace App\Http\Controllers\File;

use App\Exports\TestExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    // 导出excel
    public function outexcel()
    {
        return Excel::download(new TestExport(), 'user.xlsx');
    }
    //导入excel
    public function inputexcel(FileRequest  $request)
    {
        $file = $request['file'];
        $res= Excel::import(new UsersImport,$file);
        return $res ?
            json_success('上传成功!', $res, 200) :
            json_fail('上传失败!', null, 100);
    }
}
