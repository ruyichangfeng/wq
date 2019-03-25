<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

class FlashHongBaoException extends Exception
{
    private $error_message;
    private $error_code;
    /**
     * WxHongBaoException constructor.
     * @param $error_message
     * @param $error_code
     */
    public function __construct($error_message, $error_code)
    {
        goto Oqf89;
        atGdG:
        $this->error_code = $error_code;
        goto ymn9A;
        ymn9A:
        $this->message = $error_message;
        goto GcT2y;
        Oqf89:
        $this->error_message = $error_message;
        goto atGdG;
        GcT2y:
        $this->code = $error_code;
        goto i1w0t;
        i1w0t:
    }
    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }
    /**
     * @param mixed $error_code
     */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;
    }
    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }
    /**
     * @param mixed $error_message
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }
}
