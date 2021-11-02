<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentReturn extends Model
{
    protected $table = "equipment";
    public $timestamps = true;
    protected $primaryKey = "equipment_id";
    protected $guarded = [];


    /***
     * yjx
     * 归还改变状态
     * @param $equipment_id
     * @param $status
     * @return false
     */
    public static function changestatus($equipment_id, $status)
    {
        try {
            //dd($status);
            $res = EquipmentReturn::where('equipment_id', '=', $equipment_id)->update(
                [
                    'status' => $status
                ]
            );

            return $res ?
                $res :
                false;
        } catch (\Exception $e) {
            logError('改变错误', [$e->getMessage()]);
            return false;
        }
    }
}
