<?php
/**
 * 公共接口
 * Created by PhpStorm.
 * User: lirui
 * Date: 2018/8/7
 * Time: 下午3:24
 */

class CommonController extends BaseController
{

    /**
     * 上传文件,返回上传文件绝对路径地址
     */
    public function ActionUploadFile()
    {
        load()->func('file');
        $type = (string)$this->_GPC['type'] ?: 'image';

        $uploadRet = file_upload($_FILES['file'], $type);
        if (is_error($uploadRet)) {
            $this->ajaxError($uploadRet['message']);
        }
        $this->ajaxSucceed('', tomedia($uploadRet['path']));
    }

}