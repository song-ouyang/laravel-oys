<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentReturnRequest;
use App\Models\EquipmentReturn;
use Illuminate\Http\Request;

class EquipmentReturnController extends Controller
{

    /***
     * yjx
     * 归还器材改变状态
     * @param EquipmentReturnRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changestatus(EquipmentReturnRequest $request){
        $equipment_id=$request['equipment_id'];
        $status = $request['status'];
//dd($status);
        $res = EquipmentReturn::changestatus($equipment_id,$status);

        return $res?
            json_success("操作成功",$res,200):
            json_fail("操作失败",$res,100);

    }
}
