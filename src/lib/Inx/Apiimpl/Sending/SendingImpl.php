<?php
class Inx_Apiimpl_Sending_SendingImpl implements Inx_Api_Sending_Sending
{
	protected $_oSession;
        
	protected $_oData;

	protected $_oService;


	public function __construct( Inx_Apiimpl_AbstractSession $oSession, $oData )
	{
		$this->_oSession = $oSession;
		$this->_oData = $oData;
		$this->_oService = $oSession->getService( Inx_Apiimpl_SessionContext::SENDING_SERVICE );
	}


	public function getId()
	{
		return $this->_oData->id;
	}


	public function reload()
	{
		try
		{
			$this->_oData = $this->_oService->get( $this->_oSession->createCxt(), $this->_oData->id );

			if( $this->_oData == null )
				throw new Inx_Api_DataException( "sending data has been deleted" );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
		}
	}


	public function getMailingId()
	{
		return $this->_oData->mailingId;
	}


	public function getListId()
	{
		return $this->_oData->listId;
	}


	public function getStartDate()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->startDate );
	}


	public function getEndDate()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->endDate );
	}


	public function getModificationDate()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->modificationDate );
	}


	public function getState()
	{
		return Inx_Api_Sending_SendingState::byId( $this->_oData->state );
	}


	public function getType()
	{
		return Inx_Api_Sending_SendingMailingType::byId( $this->_oData->type );
	}


	public function getTotalSize()
	{
		return $this->_oData->totalSize;
	}


	public function getReportData()
 	{
		try
		{
			$oResult = $this->_oService->fetchSendingReportData( 
                                $this->_oSession->createCxt(), $this->getId() );
			return new Inx_Apiimpl_Sending_SendingReportImpl( $this, $oResult );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify($x);
			return null;
		}
 	}


	public function isProtocolDeleted()
	{
		return $this->_oData->protocolDeleted;
	}


	public function isMailingDeleted()
	{
		return $this->_oData->mailingDeleted;
	}


	public function hasOpened( $iRecipientId )
	{
		try
		{
			return $this->_oService->hasOpened( $this->_oSession->createCxt(), $iRecipientId, 
                                $this->getMailingId() );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function hasClicked( $iRecipientId )
	{
		try
		{
			return $this->_oService->hasClicked( $this->_oSession->createCxt(), $iRecipientId, 
                                $this->getMailingId() );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function hasBounced( $iRecipientId )
	{
		try
		{
			return $this->_oService->hasBounced( $this->_oSession->createCxt(), $iRecipientId, 
                                $this->getMailingId() );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function findGeneralMailing()
    {
        try
        {
            return $this->_oSession->getGeneralMailingManager()->get($this->getMailingId());
        }
        catch(Inx_Api_DataException $x)
        {
            return null;
        }
    }
    
        
	public function findIndividualSendings()
	{
		try
		{
			$oResult = $this->_oService->findIndividualSendings( $this->_oSession->createCxt(), $this->getId() );
			return new Inx_Apiimpl_Sending_IndividualSendingRowSetImpl( $this->_oSession, $oResult );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findSendingRecipients( Inx_Api_Recipient_RecipientContext $oRc, $aAttrs )
	{
                if(is_null($oRc))
                    throw new Inx_Api_NullPointerException('Inx_Api_Recipient_RecipientContext may not be null');
            
		try
		{
			$sRcId = $oRc->_remoteRef()->refId();
			$aAttrIds = $this->convertAttributesToIds( $aAttrs );

			$oResult = $this->_oService->findSendingRecipients( $this->_oSession->createCxt(), $this->getId(), 
                                $sRcId, $aAttrIds );
			return new Inx_Apiimpl_Sending_SendingRecipientRowSetImpl( $this->_oSession, $oRc, $oResult, $aAttrs );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}
        
        
	public function findRecipients(Inx_Api_Recipient_RecipientContext $oRc) 
	{
		if(is_null($oRc))
			throw new Inx_Api_NullPointerException('Inx_Api_Recipient_RecipientContext may not be null');
		
		return $oRc->findBySending( $this->getId() );
	}


	public function findClicks(Inx_Api_Recipient_RecipientContext $oRc, $aAttrs)
	{
		if(is_null($oRc))
			throw new Inx_Api_NullPointerException('Inx_Api_Recipient_RecipientContext may not be null');
	
		return $this->_oSession->getDataAccess()->getClickData()->createQuery($oRc, $aAttrs)->sending($this->getId())->executeQuery();
	}
	
	
	public static function convert( Inx_Apiimpl_SessionContext $oSession, $oData )
	{
		if( $oData == null )
			return null;

		return new Inx_Apiimpl_Sending_SendingImpl( $oSession, $oData );
	}


	public static function convertArray( Inx_Apiimpl_SessionContext $oSession, $aData )
	{
		if( empty($aData) )
			return array();

		$aRs = array();

		for( $i = 0; $i < count($aData); $i++ )
		{
			if( $aData[$i] != null )
				$aRs[$i] = new Inx_Apiimpl_Sending_SendingImpl( $oSession, $aData[$i] );
		}

		return $aRs;
	}


	private function convertAttributesToIds( $aAttrs )
	{
		if( $aAttrs == null )
			return array();
		$aAttrIds = array();
		for( $i = 0; $i < count($aAttrs); $i++ )
			$aAttrIds[$i] = $aAttrs[$i]->getId();
		return $aAttrIds;
	}
}