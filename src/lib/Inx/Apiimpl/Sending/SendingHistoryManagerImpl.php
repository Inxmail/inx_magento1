<?php
class Inx_Apiimpl_Sending_SendingHistoryManagerImpl implements Inx_Api_Sending_SendingHistoryManager, 
        Inx_Apiimpl_Core_ROBOResultSetDelegate
{
	protected $_oSession;

	protected $_oService;


	public function __construct( Inx_Apiimpl_AbstractSession $oSession )
	{
		$this->_oSession = $oSession;
		$this->_oService = $oSession->getService( Inx_Apiimpl_SessionContext::SENDING_SERVICE );
	}


	public function get( $iId )
	{
		try
		{
			$bo = Inx_Apiimpl_Sending_SendingImpl::convert( $this->_oSession, $this->_oService->get( 
                                $this->_oSession->createCxt(), $iId ) );

			if( $bo == null )
				throw new Inx_Api_DataException( 'sending data has been deleted' );

			return $bo;
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function selectAll()
	{
		try
		{
			$rs = $this->_oService->selectAll( $this->_oSession->createCxt() );
			return new Inx_Apiimpl_Core_DelegateROBOResultSet( $this->_oSession, $this, $rs->remoteRefId, 
                                $rs->size, Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findSendingsByMailing( $iMailingId )
	{
		try
		{
			$rs = $this->_oService->findByMailing( $this->_oSession->createCxt(), $iMailingId );
                        
			return new Inx_Apiimpl_Core_DelegateROBOResultSet( $this->_oSession, $this, $rs->remoteRefId, 
                                $rs->size, Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findSendingsByRecipient( $iRecipientId )
	{
		try
		{
			$rs = $this->_oService->findByRecipient( $this->_oSession->createCxt(), $iRecipientId );
                        
			return new Inx_Apiimpl_Core_DelegateROBOResultSet( $this->_oSession, $this, $rs->remoteRefId, 
                                $rs->size, Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findSendingsByDate( $sStart = null, $sEnd = null )
	{
		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			$rs = $this->_oService->findByDate( $this->_oSession->createCxt(), $oStartDate, $oEndDate );
			return new Inx_Apiimpl_Core_DelegateROBOResultSet( $this->_oSession, $this, $rs->remoteRefId, 
                                $rs->size, Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findPastSendingsByMailing( $iMailingId, $sStart = null, $sEnd = null )
	{
		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			$rs = $this->_oService->findPastByMailing( $this->_oSession->createCxt(), $iMailingId, 
                                $oStartDate, $oEndDate );
			return new Inx_Apiimpl_Core_DelegateROBOResultSet( $this->_oSession, $this, $rs->remoteRefId, 
                                $rs->size, Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findPastSendingsByRecipient( $iRecipientId, $sStart = null, $sEnd = null )
	{
		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			$rs = $this->_oService->findPastByRecipient( $this->_oSession->createCxt(), $iRecipientId, 
                                $oStartDate, $oEndDate );
			return new Inx_Apiimpl_Core_DelegateROBOResultSet( $this->_oSession, $this, $rs->remoteRefId, $rs->size, 
                                Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findFutureSendingsByDate( $sStart, $sEnd )
	{
		if( $sEnd == null )
			throw new Inx_Api_NullPointerException( 'end date may not be null' );

		if( $sStart == null )
			$sStart = date ('c');

		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			$rs = $this->_oService->findFutureByDate( $this->_oSession->createCxt(), $oStartDate, $oEndDate );
			return Inx_Apiimpl_TConvert::TArrToArr( $rs );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findFutureSendingsByMailing( $iMailingId, $sStart, $sEnd )
	{
		if( $sEnd == null )
			throw new Inx_Api_NullPointerException( 'end date may not be null' );

		if( $sStart == null )
			$sStart = date('c');

		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			$rs = $this->_oService->findFutureByMailing( $this->_oSession->createCxt(), $iMailingId, 
                                $oStartDate, $oEndDate );
			return Inx_Apiimpl_TConvert::TArrToArr( $rs );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findModifiedSendings( $sSince )
	{
		if( $sSince == null )
			throw new Inx_Api_NullPointerException( 'reference date may not be null' );

		try
		{
			$oSinceDate = Inx_Apiimpl_TConvert::TConvert( $sSince );

			$rs = $this->_oService->findModified( $this->_oSession->createCxt(), $oSinceDate );
			return new Inx_Apiimpl_Core_DelegateROBOResultSet( $this->_oSession, $this, $rs->remoteRefId, 
                                $rs->size, Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findNextSending( $iMailingId )
	{
		try
		{
			return Inx_Apiimpl_TConvert::convert( $this->_oService->findNext( $this->_oSession->createCxt(), 
                                $iMailingId ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findLastSendingForMailing( $iMailingId )
	{
		try
		{
			return Inx_Apiimpl_Sending_SendingImpl::convert( $this->_oSession, 
                                $this->_oService->findLastByMailing( $this->_oSession->createCxt(), $iMailingId ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findLastSendingForRecipient( $iRecipientId )
	{
		try
		{
			return Inx_Apiimpl_Sending_SendingImpl::convert( $this->_oSession, 
                                $this->_oService->findLastByRecipient( $this->_oSession->createCxt(), $iRecipientId ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function findLastSending()
	{
		try
		{
			return Inx_Apiimpl_Sending_SendingImpl::convert( $this->_oSession,
                                $this->_oService->findLast( $this->_oSession->createCxt() ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return null;
		}
	}


	public function hasOpened( $iRecipientId, $iMailingId )
	{
		try
		{
			return $this->_oService->hasOpened( $this->_oSession->createCxt(), $iRecipientId, 
                                $iMailingId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function hasClicked( $iRecipientId, $iMailingId )
	{
		try
		{
			return $this->_oService->hasClicked( $this->_oSession->createCxt(), $iRecipientId, 
                                $iMailingId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function hasBounced( $iRecipientId, $iMailingId )
	{
		try
		{
			return $this->_oService->hasBounced( $this->_oSession->createCxt(), 
                                $iRecipientId, $iMailingId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}
        
        
        public function hasOpenedBetween( $iRecipientId, $iMailingId, $sStart, $sEnd )
	{
		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			return $this->_oService->hasOpenedBetween( $this->_oSession->createCxt(), $iRecipientId, 
                                $iMailingId, $oStartDate, $oEndDate );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function hasClickedBetween( $iRecipientId, $iMailingId, $sStart, $sEnd )
	{
		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			return $this->_oService->hasClickedBetween( $this->_oSession->createCxt(), $iRecipientId, 
                                $iMailingId, $oStartDate, $oEndDate );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function hasBouncedBetween( $iRecipientId, $iMailingId, $sStart, $sEnd )
	{
		try
		{
			$oStartDate = Inx_Apiimpl_TConvert::TConvert( $sStart );
			$oEndDate = Inx_Apiimpl_TConvert::TConvert( $sEnd );

			return $this->_oService->hasBouncedBetween( $this->_oSession->createCxt(), $iRecipientId, 
                                $iMailingId, $oStartDate, $oEndDate );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSession->notify( $x );
			return false;
		}
	}


	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_Sending_SendingImpl::convertArray( $this->_oSession,  
                        $this->_oService->fetchBOs( $oResultSetRef->createCxt(), $oResultSetRef->refId(),
				$iIndex, $iDirection ) );
	}
}