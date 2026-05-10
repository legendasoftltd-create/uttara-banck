<?php

namespace CinetPay;

class CinetPay
{
    public $_cpm_site_id;
    public $_signature;
    public $_cpm_amount;
    public $_cpm_trans_id;
    public $_cpm_custom;
    public $_cpm_currency;
    public $_cpm_payid;
    public $_cpm_payment_date;
    public $_cpm_payment_time;
    public $_cpm_error_message;
    public $_payment_method;
    public $_cpm_phone_prefixe;
    public $_cel_phone_num;
    public $_cpm_ipn_ack;
    public $_created_at;
    public $_updated_at;
    public $_cpm_result;
    public $_cpm_trans_status;
    public $_cpm_designation;
    public $_buyer_name;

    protected $siteId;
    protected $apiKey;
    protected $notifyUrl;
    protected $returnUrl;
    protected $cancelUrl;

    public function __construct($siteId = null, $apiKey = null)
    {
        $this->siteId = $siteId;
        $this->apiKey = $apiKey;
        $this->_cpm_site_id = $siteId;
    }

    public static function generateTransId()
    {
        return date('YmdHis') . random_int(1000, 9999);
    }

    public function setTransId($value) { $this->_cpm_trans_id = $value; return $this; }
    public function setDesignation($value) { $this->_cpm_designation = $value; return $this; }
    public function setTransDate($value) { $this->_created_at = $value; return $this; }
    public function setAmount($value) { $this->_cpm_amount = $value; return $this; }
    public function setCurrency($value) { $this->_cpm_currency = $value; return $this; }
    public function setDebug($value) { return $this; }
    public function setCustom($value) { $this->_cpm_custom = $value; return $this; }
    public function setNotifyUrl($value) { $this->notifyUrl = $value; return $this; }
    public function setReturnUrl($value) { $this->returnUrl = $value; return $this; }
    public function setCancelUrl($value) { $this->cancelUrl = $value; return $this; }

    public function displayPayButton($formName = 'goCinetPay', $btnType = 2, $btnSize = 'large')
    {
        return '';
    }

    public function getPayStatus()
    {
        $this->_cpm_trans_status = $_POST['cpm_trans_status'] ?? null;
        $this->_cpm_result = $_POST['cpm_result'] ?? null;
        $this->_cpm_error_message = $_POST['cpm_error_message'] ?? null;
        return $this;
    }

    public function isValidPayment()
    {
        return in_array($this->_cpm_trans_status, ['ACCEPTED', '00'], true)
            || in_array($this->_cpm_result, ['00', 'ACCEPTED'], true);
    }
}
