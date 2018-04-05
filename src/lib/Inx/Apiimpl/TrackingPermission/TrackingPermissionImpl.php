<?php

class Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl implements Inx_Api_TrackingPermission_TrackingPermission
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
	 * @var stdClass
	 */
	protected $_oData;


	public function __construct( Inx_Apiimpl_AbstractSession $oSession, $oData )
	{
		$this->_oSession = $oSession;
		$this->_oData = $oData;
		$this->_oService = $this->_oSession->getService( Inx_Apiimpl_SessionContext::TRACKING_PERMISSION_SERVICE );
	}


	public function getId()
	{
		return $this->_oData->id;
	}


	public function commitUpdate()
	{
		throw new Inx_Api_UpdateException( "No updates are allowed for tracking permissions.",
			Inx_Api_UpdateException::ERROR_TYPE_ILLEGAL_OPERATION, Inx_Api_UpdateException::ERROR_SOURCE_NOT_SPECIFIED );
	}


	public function reload()
	{
		try
	    {
	        $oData = $this->_oService->get( $this->_oSession->createCxt(), $this->getId() );

	        if( empty($oData) )
	            throw new Inx_Api_DataException( "Tracking permission has been deleted: ID: " . $this->getId() );

	        $this->_oData = $oData;
	    }
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSession->notify( $e );
		}

	}


	public function getRecipientId()
	{
		return $this->_oData->recipientId;
	}


	public function getListId()
	{
		return $this->_oData->listId;
	}


	/**
	 * @return Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl
	 */
	public static function convert( Inx_Apiimpl_AbstractSession $oSession, array $oData )
	{
		if( empty($oData) )
			return array();

		$aTrackingPermissions = array();

		for( $i = 0; $i < sizeof($oData); $i++ )
		{
			$aTrackingPermissions[$i] = new Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl( $oSession, $oData[$i] );
		}

		return $aTrackingPermissions;
	}

}
