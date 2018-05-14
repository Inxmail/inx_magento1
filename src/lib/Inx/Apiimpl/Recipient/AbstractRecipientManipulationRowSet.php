<?php
abstract class Inx_Apiimpl_Recipient_AbstractRecipientManipulationRowSet 
        extends Inx_Apiimpl_Util_AbstractInsertionRowSet
        implements Inx_Api_Recipient_RecipientManipulationRowSet
{
	protected $_oRecipientContext;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, $sRemoteRefId, $iRowCount,
			array $aInitialBulk = null, $sTypeName, $oRecipientManager )
	{
		parent::__construct( $oSc, $sRemoteRefId, $iRowCount, $aInitialBulk, $sTypeName, 
                        $oRecipientManager->getUpdateableAttributeCount() );
		$this->_oRecipientContext = $oRecipientManager;
	}


	public function getBoolean( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getBoolean( $this->_oCurrentObject );
	}

	
	public function getInteger( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getInteger( $this->_oCurrentObject );
	}

	
	public function getDouble( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getDouble( $this->_oCurrentObject );
	}

	
	public function getDate( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getDate( $this->_oCurrentObject );
	}

	
	public function getTime( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getTime( $this->_oCurrentObject );
	}

	
	public function getDatetime( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getDatetime( $this->_oCurrentObject );
	}

	
	public function getString( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getString( $this->_oCurrentObject );
	}

	
	public function getObject( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getObject( $this->_oCurrentObject );
	}

	
	public function updateBoolean( Inx_Api_Recipient_Attribute $oAttr, $blValue )
	{
		$this->checkWriteAccess( $oAttr )->updateBoolean( $this->_oCurrentObject, $this->_aChangedAttrs, $blValue );
	}

	
	public function updateInteger( Inx_Api_Recipient_Attribute $oAttr, $iValue )
	{
		$this->checkWriteAccess( $oAttr )->updateInteger( $this->_oCurrentObject, $this->_aChangedAttrs, $iValue );
	}

	
	public function updateDouble( Inx_Api_Recipient_Attribute $oAttr, $fValue )
	{
		$this->checkWriteAccess( $oAttr )->updateDouble( $this->_oCurrentObject, $this->_aChangedAttrs, $fValue );
	}

	
	public function updateDate( Inx_Api_Recipient_Attribute $oAttr, $sValue )
	{
		$this->checkWriteAccess( $oAttr )->updateDate( $this->_oCurrentObject, $this->_aChangedAttrs, $sValue );
	}

	
	public function updateTime( Inx_Api_Recipient_Attribute $oAttr, $sValue )
	{
		$this->checkWriteAccess( $oAttr )->updateTime( $this->_oCurrentObject, $this->_aChangedAttrs, $sValue );
	}

	
	public function updateDatetime( Inx_Api_Recipient_Attribute $oAttr, $sValue )
	{
		$this->checkWriteAccess( $oAttr )->updateDatetime( $this->_oCurrentObject, $this->_aChangedAttrs, $sValue );
	}


	public function updateString( Inx_Api_Recipient_Attribute $oAttr, $sValue )
	{
		$this->checkWriteAccess( $oAttr )->updateString( $this->_oCurrentObject, $this->_aChangedAttrs, $sValue );
	}


	public function updateObject( Inx_Api_Recipient_Attribute $oAttr, $oValue )
	{
		$this->checkWriteAccess( $oAttr )->updateObject( $this->_oCurrentObject, $this->_aChangedAttrs, $oValue );
	}


	public function getContext()
	{
		return $this->_oRecipientContext;
	}


	
	public function getMetaData()
	{
		return $this->_oRecipientContext->getMetaData();
	}
        
        
        public function commitRowUpdate()
	{
		$this->checkExists();

		$ru = $this->createRecipientUpdate( $this->_oCurrentObject, $this->_aChangedAttrs );
		try
		{
			$this->_oCurrentObject = $this->doRecipientUpdate( $this->_createCxt(), $this->_refId(), $ru );
			$this->_oOriginObject = null;
			$this->updateBufferAfterUpdate( $this->_oBuffer, $this->_oCurrentObject, $this->_iCurrentRow, $ru->id == 0 );

			$this->rollbackRowUpdate();
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_notify( $x );
		}
	}


	protected function checkReadAccess( Inx_Api_Recipient_Attribute $oAttr )
	{
		$this->checkRecipientExists();

		if( $oAttr->getContext() === $this->_oRecipientContext )
			return $this->getAttributeGetter( $oAttr );

		throw new Inx_Api_IllegalStateException( "wrong context" );
	}


	protected function checkWriteAccess( Inx_Api_Recipient_Attribute $oAttr )
	{
		$this->checkRecipientExists();

		if( $this->_oOriginObject == null )
		{
			$this->_oOriginObject = $this->_oCurrentObject;
			$this->_oCurrentObject = $this->createWriteCopy( $this->_oOriginObject );
                        
                        $num = sizeof($this->_aChangedAttrs);
                        $this->_aChangedAttrs = ($num > 0) ? array_fill(0, $num, false) : array();
		}

		return $this->getAttributeWriter( $oAttr );
	}


	
	protected function doUpdate( $oSc, $sRemoteRefId, stdClass $oData, array $aChangedAttrs )
	{
                // not implemented here - see doRecipientUpdate
		return null;
	}


	protected abstract function checkRecipientExists();


	protected abstract function getAttributeGetter( Inx_Api_Recipient_Attribute $oAttr );


	protected abstract function getAttributeWriter( Inx_Api_Recipient_Attribute $oAttr );


	protected abstract function createWriteCopy( $oOriginObject );


	protected abstract function createRecipientUpdate( $oSource, array $aChangedAttrs );


	protected abstract function updateBufferAfterUpdate( Inx_Apiimpl_Util_IndexedBuffer $oBuffer, 
            $oUpdatedRecipient, $iCurrentRow, $blIsNewRecipient );


	protected abstract function doRecipientUpdate( $oSc, $sRemoteRefId, stdClass $oRecipientUpdate );
}