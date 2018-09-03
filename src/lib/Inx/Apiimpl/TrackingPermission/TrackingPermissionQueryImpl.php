<?php

class Inx_Apiimpl_TrackingPermission_TrackingPermissionQueryImpl implements Inx_Api_TrackingPermission_TrackingPermissionQuery
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
     * @var Inx_Apiimpl_Core_BOResultSetDelegate
     */
    protected $_oDelegate;

    /**
     * @var array int
     */
    protected $_aTrackingPermissionIds;

    /**
     * @var array int
     */
    protected $_aRecipientIds;

    /**
     * @var array int
     */
    protected $_aListIds;

    /**
     * @var int
     */
    protected $_iOrderType;

    /**
     * @var Inx_Api_TrackingPermission_TrackingPermissionAttribute
     */
    protected $_oOrderAttribute;

    public function __construct(Inx_Apiimpl_AbstractSession $oSession,
        Inx_Apiimpl_Core_BOResultSetDelegate $oDelegate, $oService)
    {
        $this->_oSession = $oSession;
        $this->_oDelegate = $oDelegate;
        $this->_oService = $oService;
        $this->_oOrderAttribute = Inx_Api_TrackingPermission_TrackingPermissionAttribute::TRACKING_PERMISSION_ID();
        $this->_iOrderType = Inx_Api_Order::ASC;
    }

    public function trackingPermissionIds(array $trackingPermissionIds = null)
    {
        $this->_aTrackingPermissionIds = $this->filterNullValues( $trackingPermissionIds );
        return $this;
    }


    public function recipientIds(array $recipientIds = null)
    {
        $this->_aRecipientIds = $this->filterNullValues( $recipientIds );
        return $this;
    }


    public function listIds(array $listIds = null)
    {
        $this->_aListIds = $this->filterNullValues( $listIds );
        return $this;
    }

    public function sort(Inx_Api_TrackingPermission_TrackingPermissionAttribute $attribute, $iOrderType)
    {
        if (null === $attribute)
            throw new Inx_Api_NullPointerException("TrackingPermissionAttribute for sorting must not be null!");
        if (Inx_Api_TrackingPermission_TrackingPermissionAttribute::UNKNOWN() === $attribute)
            throw new Inx_Api_IllegalArgumentException("TrackingPermissionAttribute for sorting must not be UNKNOWN!");
        if ($iOrderType != Inx_Api_Order::ASC && $iOrderType != Inx_Api_Order::DESC)
            throw new Inx_Api_IllegalArgumentException("Order must be Ascending (Order.ASC) or Descending (Order.DESC)!");

        $this->_oOrderAttribute = $attribute;
        $this->_iOrderType = $iOrderType;
        return $this;
    }


    public function executeQuery()
    {
        $orderAttributeId = $this->_oOrderAttribute->getId();
        try
        {
            $oResult = $this->_oService->find($this->_oSession->createCxt(), $this->_aTrackingPermissionIds,
                $this->_aRecipientIds, $this->_aListIds, $orderAttributeId, $this->_iOrderType);

            return new Inx_Apiimpl_Core_DelegateBOResultSet($this->_oSession, $this->_oDelegate,
                $oResult->remoteRefId, $oResult->size, $oResult);
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
