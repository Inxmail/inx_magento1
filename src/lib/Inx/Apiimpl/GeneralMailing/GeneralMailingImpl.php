<?php

class Inx_Apiimpl_GeneralMailing_GeneralMailingImpl implements Inx_Api_GeneralMailing_GeneralMailing
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
		$this->_oService = $this->_oSession->getService( Inx_Apiimpl_SessionContext::GENERAL_MAILING_SERVICE );
	}


	public function getId()
	{
		return $this->_oData->id;
	}


	public function reload()
	{
		try
	    {
	        $oData = $this->_oService->get( $this->_oSession->createCxt(), $this->getId() );

	        if( empty($oData) )
	            throw new Inx_Api_DataException( "Mailing has been deleted: ID: " . $this->getId() );

	        $this->_oData = $oData;
	    }
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSession->notify( $e );
		}

	}


	public function getName()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->name );
	}


	public function getSubject()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->subject );
	}


	public function getListContextId()
	{
		return $this->_oData->listId;
	}


	/**
	 * @return Inx_Api_GeneralMailing_MailingType
	 */
	public function getMailingType()
	{
		return Inx_Api_GeneralMailing_MailingType::byId( $this->_oData->type );
	}
        
        
        public function getCreationDatetime()
        {
            return Inx_Apiimpl_TConvert::convert( $this->_oData->creationDatetime );
        }
        
        
        public function getModificationDatetime()
        {
            return Inx_Apiimpl_TConvert::convert( $this->_oData->modificationDatetime );
        }
        
        
        public function findSendings()
        {
            return $this->_oSession->getSendingHistoryManager()->findSendingsByMailing($this->getId());
        }
        
        
        public function findLastSending()
        {
            return $this->_oSession->getSendingHistoryManager()->findLastSendingForMailing($this->getId());
        }


	/**
	 * @return Inx_Apiimpl_GeneralMailing_GeneralMailingImpl
	 */
	public static function convert( Inx_Apiimpl_AbstractSession $oSession, array $oData )
	{
		if( empty($oData) )
			return array();

		$aMailings = array();

		for( $i = 0; $i < sizeof($oData); $i++ )
		{
			$aMailings[$i] = new Inx_Apiimpl_GeneralMailing_GeneralMailingImpl( $oSession, $oData[$i] );
		}

		return $aMailings;
	}

}
