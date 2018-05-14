<?php
class Inx_Apiimpl_DataAccess_ClickDataQueryImpl implements Inx_Api_DataAccess_ClickDataQuery
{
	private $_oSc;

	private $_oService;

        private $_oCd;
        
	private $_oRecipientContext;
	
	private $_oDataAccessUtil;

	private $_aAttributes;

	private $aMailingIds;
        
	private $aSendingIds;

	private $aLinkIds;

	private $aRecipientIds;

	private $aLinkTypes;

	private $sStartDate;

	private $sEndDate;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, Inx_Api_Recipient_RecipientContext $oRecipientContext, 
                array $aAttributes, Inx_Apiimpl_DataAccess_ClickDataImpl $oCd )
	{
		$this->_oSc = $oSc;
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::DATAACCESS4_SERVICE );
		$this->_oRecipientContext = $oRecipientContext;
		$this->_aAttributes = $aAttributes;
		$this->_oCd = $oCd;
		$this->_oDataAccessUtil = new Inx_Apiimpl_DataAccess_DataAccessUtil();
	}


	public function mailing( $iMailingId )
	{
		$this->aMailingIds = array( $iMailingId );
		return $this;
	}


	public function mailings( array $aMailingIds )
	{
		$this->aMailingIds = $aMailingIds;
		return $this;
	}


	public function link( $iLinkId )
	{
		$this->aLinkIds = array( $iLinkId );
		return $this;
	}


	public function links( array $aLinkIds )
	{
		$this->aLinkIds = $aLinkIds;
		return $this;
	}


	public function recipient( $iRecipientId )
	{
		$this->aRecipientIds = array( $iRecipientId );
		return $this;
	}


	public function recipients( array $aRecipientIds )
	{
		$this->aRecipientIds = $aRecipientIds;
		return $this;
	}
	
	
    public function sending( $iSendingId ){
        $this->aSendingIds = array($iSendingId);
        return $this;
    }
    
    
    public function sendings( array $aSendingIds ){
        $this->aSendingIds = $aSendingIds;
        return $this;
    }


	public function linkType( $iLinkType )
	{
        $this->_oDataAccessUtil->checkLinkTypeValid(array( $iLinkType ));
		$this->aLinkTypes = array( $iLinkType );
		return $this;
	}


	public function linkTypes( array $aLinkTypes )
	{
		$this->_oDataAccessUtil->checkLinkTypeValid($aLinkTypes);
		$this->aLinkTypes = $aLinkTypes;
		return $this;
	}


	public function before( $sDate )
	{
		$this->sEndDate = $sDate;
		return $this;
	}


	public function after( $sDate )
	{
		$this->sStartDate = $sDate;
		return $this;
	}


	public function between( $sStart, $sEnd )
	{
		$this->sStartDate = $sStart;
		$this->sEndDate = $sEnd;
		return $this;
	}


	public function executeQuery()
	{
		try
		{
			$attrIds = $this->convertAttributesToIds( $this->_aAttributes );
                        
			$result = $this->_oService->selectClickGeneric( $this->_oSc->createCxt(), $this->aMailingIds, 
                                $this->aLinkIds, $this->aRecipientIds, $this->aLinkTypes, Inx_Apiimpl_TConvert::TConvert( 
                                        $this->sStartDate ), Inx_Apiimpl_TConvert::TConvert( $this->sEndDate ),  $this->aSendingIds,
                                        $this->_oRecipientContext->_remoteRef()->refId(), $attrIds );
                        
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl( $this->_oSc, $this->_oRecipientContext, 
                                $this->_aAttributes, $result, $this->_oCd );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
	}


	private function convertAttributesToIds( array $aAttrs )
	{
		$attrIds = array();
		for( $i = 0; $i < sizeof($aAttrs); $i++ )
			$attrIds[$i] = $aAttrs[$i]->getId();
		return $attrIds;
	}
}
