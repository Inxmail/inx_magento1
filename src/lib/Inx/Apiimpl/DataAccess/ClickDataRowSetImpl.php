<?php
class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl 
        extends Inx_Apiimpl_Recipient_AbstractReadOnlyRecipientRowSet
        implements Inx_Api_DataAccess_ClickDataRowSet
{
	private $_oService;

	private $_oCd;

	public function __construct( Inx_Apiimpl_SessionContext $oSc, Inx_Api_Recipient_RecipientContext $oRecipientManager, 
                array $aAttrs, stdClass $oResult, Inx_Apiimpl_DataAccess_ClickDataImpl $oCd )
	{
            parent::__construct( $oSc, $oResult->remoteRefId, $oResult->rowCount, $oResult->data, "click", 
                    $oRecipientManager, $aAttrs, $oResult->typedIndices, 
                    Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetter::getFactory() );
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::DATAACCESS4_SERVICE );
                $this->_oCd = $oCd;
	}


	public function getClickId()
	{
		$this->checkExists();
		return $this->_oCurrentObject->clickId;
	}


	
	public function getClickTimestamp()
	{
		$this->checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentObject->clickTimestamp );
	}


	
	public function getRemoteHost()
	{
		$this->checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentObject->remoteHost );
	}


	
	public function getUserAgent()
	{
		$this->checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentObject->userAgent );
	}


	
	public function getLinkId()
	{
		$this->checkExists();
		return $this->_oCurrentObject->linkId;
	}


	
	public function getRecipientId()
	{
		$this->checkExists();
		return $this->_oCurrentObject->recipientId;
	}


	
	public function getRecipientState()
	{
		$this->checkExists();
		return $this->_oCurrentObject->recipientState;
	}

        
    public function getSendingId()
    {
    	$this->checkExists();
        return Inx_Apiimpl_TConvert::convert($this->_oCurrentObject->sendingId);
    }

    public function getSending()
    {
        if ($this->getSendingId() == null)
            return null;
        
        return $this->_oCd->findSendingBySendingId($this->getSendingId());
    }
    
     public function getTrackingHash()
    {
    	$this->checkExists();
        return Inx_Apiimpl_TConvert::convert($this->_oCurrentObject->trackingHash);
    }
	
    protected function checkRecipientExists()
    {
        $this->checkExists();
    }

	
	protected function doFetch( $oSc, $sRemoteRefId, $iIndex, $iDirection )
	{
		return $this->_oService->fetchClick( $oSc, $sRemoteRefId, $iIndex, $iDirection );
	}
}