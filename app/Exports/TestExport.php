<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;


class TestExport implements FromArray
{

    public function array(): array
    {
        $data = [
            // 设置表头信息
            ['序号','姓名','电话','邮箱','账号'],
        ];
        // 取出需求导出的数据
        $userDatas = Student::get();
        foreach ($userDatas as $k => $v) {
            $data[] = [
                $v->id,
                $v->name,
                $v->phone,
                $v->email,
                $v->account,
            ];
        }
        return $data;
    }
}
