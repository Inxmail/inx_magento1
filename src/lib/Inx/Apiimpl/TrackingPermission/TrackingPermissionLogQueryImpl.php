<?php

class Inx_Apiimpl_TrackingPermission_TrackingPermissionLogQueryImpl implements Inx_Api_TrackingPermission_TrackingPermissionLogQuery
{
    /**
     * @var Inx_Apiimpl_AbstractSession
     */
    protected $_oSession;

    /**
     * @var stdClass
     */
    protected $_oService;

    /**
     * @var array int
     */
    protected $_aListIds;

    /**
     * @var array int
     */
    protected $_aRecipientIds;

    /**
     * @var string
     */
    protected $_sStartDate;

    /**
     * @var string
     */
    protected $_sEndDate;

    /**
     * @var int
     */
    protected $_iAfterId;

    /**
     * @var int
     */
    protected $_iOrderType;

    /**
     * @var Inx_Api_TrackingPermission_TrackingPermissionLogAttribute
     */
    protected $_oOrderAttribute;

    public function __construct(Inx_Apiimpl_AbstractSession $oSession, $oService)
    {
        $this->_oSession = $oSession;
        $this->_oService = $oService;
        $this->_iAfterId = -1;
        $this->_oOrderAttribute = Inx_Api_TrackingPermission_TrackingPermissionLogAttribute::ID();
        $this->_iOrderType = Inx_Api_Order::ASC;
    }

    public function recipientIds(array $aRecipientIds = null )
    {
        $this->_aRecipientIds = $this->filterNullValues( $aRecipientIds );
        return $this;
    }

    public function listIds(array $aListIds )
    {
        $this->_aListIds = $this->filterNullValues( $aListIds );
        return $this;
    }

    public function after( $sDate )
    {
        $this->_sStartDate = $sDate;
        return $this;
    }

    public function before( $sDate )
    {
        $this->_sEndDate = $sDate;
        return $this;
    }

    public function between( $sStart, $sEnd )
    {
        return $this->after( $sStart )->before( $sEnd );
    }

    public function afterId( $iId )
    {
        $this->_iAfterId = $iId;
        return $this;
    }

    public function sort( Inx_Api_TrackingPermission_TrackingPermissionLogAttribute $oAttribute, $iOrderType )
    {
        if (null === $oAttribute)
            throw new Inx_Api_NullPointerException("TrackingPermissionLogAttribute for sorting must not be null!");
        if (Inx_Api_TrackingPermission_TrackingPermissionLogAttribute::UNKNOWN() === $oAttribute)
            throw new Inx_Api_IllegalArgumentException("TrackingPermissionLogAttribute for sorting must not be UNKNOWN!");
        if ($iOrderType != Inx_Api_Order::ASC && $iOrderType != Inx_Api_Order::DESC)
            throw new Inx_Api_IllegalArgumentException("Order must be Ascending (Order.ASC) or Descending (Order.DESC)!");

        $this->_oOrderAttribute = $oAttribute;
        $this->_iOrderType = $iOrderType;
        return $this;
    }

    public function executeQuery()
    {
        $iOrderAttributeId = $this->_oOrderAttribute->getId();
        try
        {
            $oData = $this->_oService->findTrackingPermissionLog( $this->_oSession->createCxt(), $this->_aRecipientIds,
        	    $this->_aListIds, Inx_Apiimpl_TConvert::TConvert( $this->_sStartDate ),
        	    Inx_Apiimpl_TConvert::TConvert( $this->_sEndDate ), Inx_Apiimpl_TConvert::TConvert( $this->_iAfterId ), $iOrderAttributeId,
        	    $this->_iOrderType );

            return new Inx_Apiimpl_TrackingPermission_TrackingPermissionLogEntryRowSetImpl( $this->_oSession, $oData );
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return null;
        }
    }

    private static function filterNullValues($given)
    {
        if (is_array($given))
            return array_filter($given, "strlen");

        return $given;
    }
}
