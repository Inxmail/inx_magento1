<?php
class Inx_Apiimpl_Sending_IndividualSendingRowSetImpl extends Inx_Apiimpl_Util_AbstractInxRowSet 
        implements Inx_Api_Sending_IndividualSendingRowSet
{
	private $_oService;

	private $_iSendingId;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, $oResult )
	{
		parent::__construct( $oSc, $oResult->remoteRefId, $oResult->rowCount, $oResult->data, 
                        "individual sending data" );
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


	protected function doFetch( $oCxt, $sRemoteRefId, $iIndex, $iDirection )
	{
		return $this->_oService->fetchIndividualSendingData( $oCxt, $sRemoteRefId, $this->_iSendingId, 
                        $iIndex, $iDirection );
	}
}