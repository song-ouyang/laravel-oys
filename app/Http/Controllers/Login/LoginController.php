<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Login\RegisteredRequest;
use App\Http\Requests\Login\UpdateRequest;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Superadmin;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * super登录
     * @param Request $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequest)
    {

        try {
            $credentials = self::credentials($loginRequest);
            if (!$token = auth('api')->attempt($credentials)) {
                return json_fail(100, '账号或者密码错误!', null);
            }
            return self::respondWithToken($token, '登录成功!');
        } catch (\Exception $e) {
            echo $e->getMessage();
            return json_fail(500, '登录失败!', null, 500);
        }
    }


    /**
     * admin登录
     * @param Request $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminlogin(LoginRequest $loginRequest)
    {

        try {
            $credentials = self::credentials($loginRequest);
            if (!$token = auth('apis')->attempt($credentials)) {
                return json_fail(100, '账号或者密码错误!', null);
            }
            return self::respondWithToken($token, '登录成功!');
        } catch (\Exception $e) {
            echo $e->getMessage();
            return json_fail(500, '登录失败!', null, 500);
        }
    }



    /**
     * student登录
     * @param Request $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentlogin(LoginRequest $loginRequest)
    {

        try {
            $credentials = self::credentials($loginRequest);
            if (!$token = auth('apiss')->attempt($credentials)) {
                return json_fail(100, '账号或者密码错误!', null);
            }
            return self::respondWithToken($token, '登录成功!');
        } catch (\Exception $e) {
            echo $e->getMessage();
            return json_fail(500, '登录失败!', null, 500);
        }
    }


    /**
     * 注销登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
        } catch (\Exception $e) {

        }
        return auth()->check() ?
            json_fail('注销登录失败!',null, 100 ) :
            json_success('注销登录成功!',null,  200);
    }



    protected function credentials($request)
    {
        return ['account' => $request['account'], 'password' => $request['password']];
    }

    protected function respondWithToken($token, $msg)
    {
        $data = Auth::user();

        return json_success( $msg, array(
            'token' => $token,
            //设置权限  'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ),200);
    }

    /**
     * 超管注册
     * @param Request $registeredRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registered(RegisteredRequest $registeredRequest)
    {
        $count = Superadmin::checknumber($registeredRequest);
        if($count == 0)
        {
            $student_id = Superadmin::createUser(self::userHandle($registeredRequest));
                return  $student_id ?
                    json_success('注册成功!',$student_id,200  ) :
                    json_success('注册失败!',null,100  ) ;
        }
        else{
            return
                json_success('注册失败!该工号已经注册过了！',null,100  ) ;
        }
    }



    /**
     * admin注册
     * @param Request $registeredRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registereds(RegisteredRequest $registeredRequest)
    {
        $count = Admin::checknumber($registeredRequest);
        if($count == 0)
        {
            $student_id = Admin::createUser(self::userHandle($registeredRequest));
            return  $student_id ?
                json_success('注册成功!',$student_id,200  ) :
                json_success('注册失败!',$student_id,100  ) ;
        }
        else{
            return
                json_success('注册失败!该工号已经注册过了！',null,100  ) ;
        }
    }



    /**
     * student注册
     * @param Request $registeredRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registeredss(RegisteredRequest $registeredRequest)
    {
        $count = Student::checknumber($registeredRequest);
        if($count == 0)
        {
            $student_id = Student::createUser(self::userHandle($registeredRequest));

            return  $student_id ?
                json_success('注册成功!',$student_id,200  ) :
                json_success('注册失败!',$student_id,100  ) ;
        }
        else{
            return
                json_success('注册失败!该工号已经注册过了！',null,100  ) ;
        }
    }



    //
    protected function userHandle($request)
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);
        $registeredInfo['name'] = $registeredInfo['name'];
        $registeredInfo['phone'] = $registeredInfo['phone'];
        $registeredInfo['email'] = $registeredInfo['email'];
        $registeredInfo['account'] = $registeredInfo['account'];
        return $registeredInfo;
    }


    protected function userHandle2($request)
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);

        $registeredInfo['name'] = $registeredInfo['name'];
        $registeredInfo['phone'] = $registeredInfo['phone'];
        $registeredInfo['email'] = $registeredInfo['email'];
        $registeredInfo['account'] = $registeredInfo['account'];

       // $registeredInfo['type'] = $registeredInfo['type'];

        return $registeredInfo;
    }


    public function change1(UpdateRequest $request){

        $account=$request->get('account');
        $password=$request->get('password');
        $password= bcrypt($password);

        $res=Superadmin::update1($account,$password);
        return $res ?
            json_success("操作成功", $res, 200) :
            json_fail("操作失败", $res, 100);

    }


    /**修改admin密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change2(UpdateRequest $request){
        $account=$request->get('account');
        $password=$request->get('password');
        $password= bcrypt($password);

        $res=Admin::update1($account,$password);
        return $res ?
            json_success("操作成功", $res, 200) :
            json_fail("操作失败", $res, 100);

    }
    /**修改admin密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change3(UpdateRequest $request){
        $account=$request->get('account');
        $password=$request->get('password');
        $password= bcrypt($password);

        $res=Student::update1($account,$password);
        return $res ?
            json_success("操作成功", $res, 200) :
            json_fail("操作失败", $res, 100);
    }

}
