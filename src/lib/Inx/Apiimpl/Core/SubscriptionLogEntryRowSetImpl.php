<?php
class Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl 
        extends Inx_Apiimpl_Recipient_AbstractReadOnlyRecipientRowSet
        implements Inx_Api_Subscription_SubscriptionLogEntryRowSet
{
	private $_oService;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, Inx_Api_Recipient_RecipientContext $oRc, 
                array $aAttrs, stdClass $oResult )
	{
		parent::__construct( $oSc, $oResult->remoteRefId, $oResult->rowCount, $oResult->data, "log entry", 
                        $oRc, $aAttrs, $oResult->typedIndices, 
                        Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_SubscriptionLogEntryAttributeGetter::getFactory() );
		$this->_oService = $oSc->getService(Inx_Apiimpl_SessionContext::CORE2_SERVICE);
	}


	public function getLogMessage() 
	{
		$this->checkExists();
		return $this->_oCurrentObject->logMsg;
	}


	public function getListId() 
	{
		$this->checkExists();
		return $this->_oCurrentObject->listId;
	}


	public function getType() 
	{
		$this->checkExists();
		return $this->_oCurrentObject->type;
	}


	public function getEntryDatetime() 
	{
		$this->checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentObject->logDate );
	}


	public function getEmailAddress() 
	{
		$this->checkExists();
		return $this->_oCurrentObject->email;
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


	protected function checkRecipientExists() 
	{
		$this->checkExists();
	}


	protected function doFetch( $oSc, $sRemoteRefId, $iIndex, $iDirection )
	{
		return $this->_oService->fetchSubscriptionLog( $oSc, $sRemoteRefId, $iIndex, $iDirection );
	}

    public function getSendingId()
    {
        $this->checkExists();
        return $this->_oCurrentObject->sendingId;
    }
}