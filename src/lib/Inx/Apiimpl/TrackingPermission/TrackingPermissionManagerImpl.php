<?php

class Inx_Apiimpl_TrackingPermission_TrackingPermissionManagerImpl implements Inx_Api_TrackingPermission_TrackingPermissionManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
    /**
     * @var Inx_Apiimpl_AbstractSession
     */
    protected $_oSession;

    /**
     * @var stdClass
     */
    protected $_oService;

    public function __construct(Inx_Apiimpl_AbstractSession $oSession)
    {
        $this->_oSession = $oSession;
        $this->_oService = $this->_oSession->getService(Inx_Apiimpl_SessionContext::TRACKING_PERMISSION_SERVICE);
    }

    /**
     * @return Inx_Api_TrackingPermission_TrackingPermissionQueryImpl
     */
    public function createQuery()
    {
        return new Inx_Apiimpl_TrackingPermission_TrackingPermissionQueryImpl($this->_oSession, $this, $this->_oService);
    }


    /**
     * @return Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl
     * @throws Inx_Api_DataException
     */
    public function get($iId)
    {
        if (!is_long($iId))
        {
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got ' . gettype($iId));
        }

        try
        {
            $data = $this->_oService->get($this->_oSession->createCxt(), $iId);

            if (empty($data))
                throw new Inx_Api_DataException("No tracking permission found for ID: " . $iId);

            return new Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl($this->_oSession, $data);
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return null;
        }
    }

    public function remove( $iId )
    {
        try
        {
            return $this->_oService->remove($this->_oSession->createCxt(), $iId );
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return false;
        }
    }

    /**
     * @return Inx_Apiimpl_Core_DelegateBOResultSet
     */
    public function selectAll()
    {
        try
        {
            $data = $this->_oService->find($this->_oSession->createCxt(), null, null, null,
                Inx_Api_TrackingPermission_TrackingPermissionAttribute::TRACKING_PERMISSION_ID()->getId(), Inx_Api_Order::ASC);

            return new Inx_Apiimpl_Core_DelegateBOResultSet($this->_oSession, $this, $data->remoteRefId, $data->size,
                $data);
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return null;
        }
    }

    /**
     * @param Inx_Apiimpl_RemoteRef $oResultSetRef
     * @param int $iIndex
     * @param int $iDirection
     * @return array of Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl's
     * @throws Inx_Api_RemoteException
     */
    public function fetchBOs(Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection)
    {
        return Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl::convert($this->_oSession,
                $this->_oService->fetchBOs($this->_oSession->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection));
    }

    public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $indexRanges )
    {
        return $this->_oService->removeBOs( $oResultSetRef->createCxt(), $oResultSetRef->refId(), $indexRanges );
    }

    public function grantTrackingPermission( $iRecipientId, $iListId )
    {
        try
        {
            $h = $this->_oService->grantTrackingPermission( $this->_oSession->createCxt(), $iRecipientId, $iListId );

            if( !empty($h->excDesc) )
                throw new Inx_Api_UpdateException( $h->excDesc->msg, $h->excDesc->type, $h->excDesc->source );
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
        }
    }

    public function revokeTrackingPermission( $iRecipientId, $iListId )
    {
        try
        {
            $h = $this->_oService->revokeTrackingPermission( $this->_oSession->createCxt(), $iRecipientId, $iListId );

            if( !empty($h->excDesc) )
                throw new Inx_Api_UpdateException( $h->excDesc->msg, $h->excDesc->type, $h->excDesc->source );
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
        }
    }

    public function createLogQuery()
    {
        return new Inx_Apiimpl_TrackingPermission_TrackingPermissionLogQueryImpl($this->_oSession, $this->_oService);
    }
}
