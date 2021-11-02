<?php

namespace App\Http\Controllers;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentRequest1;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /***
     * yjx
     * 增加学生
     * @param StudentRequest $request
     * @return JsonResponse
     *
     */
    public function add(StudentRequest $request){
        $student_id = $request['student_id'];
        $student_password = $request['student_password'];
        $student_name = $request['student_name'];
        $student_phone = $request['student_phone'];
        $student_email = $request['student_email'];

        $res1 = Student::establish(
            $student_id,
            $student_password,
            $student_name,
            $student_phone,
            $student_email

        );
        return $res1?
            json_success("操作成功",$res1,200):
            json_fail("操作失败",$res1,100);

}

    /**
     * yjx
     * 修改学生
     * @param StudentRequest $request
     * @return JsonResponse
     *
     */
    public function modify(StudentRequest $request){
       // $stuid1 = $request['stuid1'];
        $student_id = $request['student_id'];
        $student_password = $request['student_password'];
        $student_name = $request['student_name'];
        $student_phone = $request['student_phone'];
        $student_email = $request['student_email'];

        $res1 = Student::modify(
            //$stuid1,
            $student_id,
            $student_password,
            $student_name,
            $student_phone,
            $student_email
        );
        return $res1?
            json_success("操作成功",$res1,200):
            json_fail("操作失败",$res1,100);
    }

    /***
     * yjx
     * 删除学生
     * @param StudentRequest1 $request
     * @return JsonResponse
     */
    public function delete(StudentRequest1 $request)
    {

        $student_id = $request['student_id'];
        $res = Student::delect($student_id);

        return $res ?
            json_success("操作成功", $res, 200) :
            json_fail("操作失败", $res, 100);

    }

    /***
     * yjx
     * 查询学生
     * @param StudentRequest1 $request
     * @return JsonResponse
     */
    public function showstudent(StudentRequest1 $request){
        $student_id = $request['student_id'];
        $res = Student::show($student_id);

        return $res ?
            json_success("操作成功", $res, 200) :
            json_fail("操作失败", $res, 100);



    }






}
