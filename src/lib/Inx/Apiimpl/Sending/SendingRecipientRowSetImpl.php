<?php
class Inx_Apiimpl_Sending_SendingRecipientRowSetImpl 
        extends Inx_Apiimpl_Recipient_AbstractReadOnlyRecipientRowSet
        implements Inx_Api_Sending_SendingRecipientRowSet
{
	private $_oService;

	private $_iSendingId;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, 
                Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientManager, $oResult, $aAttrs )
	{
            parent::__construct( $oRecipientManager->_remoteRef(), $oResult->remoteRefId, $oResult->rowCount, 
                $oResult->data, 'sending recipient data', $oRecipientManager, $aAttrs, $oResult->typedIndices, 
                Inx_Apiimpl_Sending_SendingRecipientAttributeGetter::getFactory() );
            $this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::SENDING_SERVICE );
            $this->_iSendingId = $oResult->sendingId;
	}


	public function getRecipientId()
	{
		$this->checkExists();
		return $this->_oCurrentObject->recipientId;
	}


	public function hasBounced()
	{
		$this->checkExists();
		return $this->_oCurrentObject->bounced;
	}


	public function hasOpened()
	{
		$this->checkExists();
		return $this->_oCurrentObject->opened;
	}


	public function hasClicked()
	{
		$this->checkExists();
		return $this->_oCurrentObject->clicked;
	}


	public function getState()
	{
		$this->checkExists();
		return Inx_Api_Sending_IndividualSendingState::byId( $this->_oCurrentObject->state );
	}


	public function getRecipientState()
	{
		$this->checkRecipientExists();
		return Inx_Api_Recipient_RecipientState::byId( $this->_oCurrentObject->recipientState );
	}


	protected function doFetch( $oCxt, $sRemoteRefId, $iIndex, $iDirection )
	{
		return $this->_oService->fetchSendingRecipientData( $oCxt, $sRemoteRefId, $this->_iSendingId, 
                        $iIndex, $iDirection );
	}


	protected function checkRecipientExists()
	{
		$this->checkExists();
	}
}