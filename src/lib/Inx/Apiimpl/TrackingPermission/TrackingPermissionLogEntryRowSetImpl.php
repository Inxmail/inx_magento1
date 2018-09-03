<?php

class Inx_Apiimpl_TrackingPermission_TrackingPermissionLogEntryRowSetImpl
    extends Inx_Apiimpl_Util_AbstractInxRowSet implements Inx_Api_TrackingPermission_TrackingPermissionLogEntryRowSet
{
    private $_oService;

    public function __construct( Inx_Apiimpl_SessionContext $sc, $oResult )
    {
        parent::__construct( $sc, $oResult->remoteRefId, $oResult->rowCount, $oResult->data, 'trackingPermissionLogEntry' );
        $this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::TRACKING_PERMISSION_SERVICE );
    }

	public function getId()
	{
        $this->checkExists();
        return $this->_oCurrentObject->id;
	}

	public function getNewState()
	{
        $this->checkExists();
        return Inx_Api_TrackingPermission_TrackingPermissionState::byId( $this->_oCurrentObject->newState );
	}

	public function getTimestamp()
	{
        $this->checkExists();
        return Inx_Apiimpl_TConvert::convert( $this->_oCurrentObject->timestamp );
	}

	public function getRecipientId()
	{
        $this->checkExists();
        return $this->_oCurrentObject->recipientId;
	}

	public function getListId()
	{
        $this->checkExists();
        return $this->_oCurrentObject->listId;
	}

	public function getOriginator()
	{
        $this->checkExists();
        return $this->extractOriginator( $this->_oCurrentObject );
	}

    protected function doFetch($oCxt, $sRemoteRefId, $iIndex, $iDirection)
    {
        return $this->_oService->fetchTrackingPermissionLog( $oCxt, $sRemoteRefId, $iIndex, $iDirection );
    }

    private function extractOriginator( $oCurrentObject )
    {
        $oType = Inx_Api_TrackingPermission_OriginatorType::byId( $oCurrentObject->originatorType );
        $sIdentity = Inx_Apiimpl_TConvert::convert( $oCurrentObject->originatorIdentity );
        $sMessage = Inx_Apiimpl_TConvert::convert( $oCurrentObject->originatorMessage );
        $sDeterminedRemoteAddress = Inx_Apiimpl_TConvert::convert( $oCurrentObject->originatorDeterminedAddress );
        $sSuppliedRemoteAddress = Inx_Apiimpl_TConvert::convert( $oCurrentObject->originatorSuppliedAddress );
        return new Inx_Apiimpl_TrackingPermission_OriginatorImpl( $oType, $sIdentity, $sMessage, $sDeterminedRemoteAddress, $sSuppliedRemoteAddress );
    }

}
