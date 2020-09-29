<?php
namespace App\Http\Requests\Rbac;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest {
    /**
     * 检测当前用户是否有权访问当前资源
     *
     * @return bool
     */
    public function authorize () {
        return true;
    }

    /**
     * 配置请求的检验规则
     *
     * @return array
     */
    public function rules () {
        return [
        ];
    }


    /**
     * 为失败的请求定义错误消息
     *
     * @return array
     */
    public function messages () {
        return [
        ];
    }

    /**
     * 返回请求中可以接收的数据
     */
    public function data () {
        return [
            'uid' => (int) $this->uid ,
            'connection' => $this->connection ,
            'sql' => $this->sql ,
            'bindings' => $this->bindings ,
            'time' => (double) $this->time ,
            'created_at' => $this->created_at ,
            'updated_at' => $this->updated_at
        ];
    }
}

