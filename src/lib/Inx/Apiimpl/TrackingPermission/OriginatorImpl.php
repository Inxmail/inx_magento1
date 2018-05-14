<?php

class Inx_Apiimpl_TrackingPermission_OriginatorImpl implements Inx_Api_TrackingPermission_Originator
{
    /**
     * @var Inx_Api_TrackingPermission_OriginatorType
     */
    protected $_oType;

    /**
     * @var string
     */
    protected $_sIdentity;

    /**
     * @var string
     */
    protected $_sMessage;

    /**
     * @var string
     */
    protected $_sDeterminedRemoteAddress;

    /**
     * @var string
     */
    protected $_sSuppliedRemoteAddress;

    public function __construct( Inx_Api_TrackingPermission_OriginatorType $oType, $sIdentity,
        $sMessage, $sDeterminedRemoteAddress, $sSuppliedRemoteAddress )
    {
        $this->_oType = $oType;
        $this->_sIdentity = $sIdentity;
        $this->_sMessage = $sMessage;
        $this->_sDeterminedRemoteAddress = $sDeterminedRemoteAddress;
        $this->_sSuppliedRemoteAddress = $sSuppliedRemoteAddress;
    }


    public function getType()
    {
        return $this->_oType;
    }

    public function getIdentity()
    {
        return $this->_sIdentity;
    }

    public function getMessage()
    {
        return $this->_sMessage;
    }

    public function getDeterminedRemoteAddress()
    {
        return $this->_sDeterminedRemoteAddress;
    }

    public function getSuppliedRemoteAddress()
    {
        return $this->_sSuppliedRemoteAddress;
    }
}
