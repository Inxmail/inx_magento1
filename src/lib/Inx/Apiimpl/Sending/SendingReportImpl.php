<?php
class Inx_Apiimpl_Sending_SendingReportImpl implements Inx_Api_Sending_SendingReport
{
	private $_oSending;

	private $_oData;


	public function __construct( Inx_Api_Sending_Sending $oSending, stdClass $oData )
	{
		$this->_oSending = $oSending;
		$this->_oData = $oData;
	}


	public function getOpenedCount()
	{
		return $this->_oData->opened;
	}


	public function getClickedCount()
	{
		return $this->_oData->clicked;
	}


	public function getSentCountIncludingBounces()
	{
		return $this->_oData->sentIncludingBounces;
	}


	public function getSentCountExcludingBounces()
	{
		return $this->_oData->sentExcludingBounces;
	}


	public function getBouncedCount()
	{
		return $this->_oData->bounced;
	}


	public function getNotSentCount()
	{
		return $this->_oData->notSent;
	}


	public function getAverageMailSize()
	{
		if( $this->getSentCountIncludingBounces() == 0 )
			return 0; // if sent count is zero, average mail size must be zero, too

		return $this->_oSending->getTotalSize() / $this->getSentCountIncludingBounces();
	}
}