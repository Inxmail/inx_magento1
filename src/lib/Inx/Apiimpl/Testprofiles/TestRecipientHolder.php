<?php
class Inx_Apiimpl_Testprofiles_TestRecipientHolder
{
	private $_oRecipientData;

	private $_oOriginalRecipientData;


	public function __construct( stdClass $oRecipientData = null, stdClass $oCreateNewRecipientData = null )
	{
                if(is_null($oCreateNewRecipientData))
                {
                    $this->_oRecipientData = $oRecipientData;
                    $this->createORecipientData();
                }
                else
                {
                    $this->_oRecipientData = new stdClass();
                    $this->_oOriginalRecipientData = $oCreateNewRecipientData;
                }
	}


	private function createORecipientData()
	{
                $this->_oOriginalRecipientData = new stdClass();
                
                if(isset($this->_oRecipientData->booleanData))
                    $this->_oOriginalRecipientData->booleanData = $this->_oRecipientData->booleanData;
                if(isset($this->_oRecipientData->dateData))
                    $this->_oOriginalRecipientData->dateData = $this->_oRecipientData->dateData;
                if(isset($this->_oRecipientData->datetimeData))
                    $this->_oOriginalRecipientData->datetimeData = $this->_oRecipientData->datetimeData;
                if(isset($this->_oRecipientData->doubleData))
                    $this->_oOriginalRecipientData->doubleData = $this->_oRecipientData->doubleData;
                if(isset($this->_oRecipientData->integerData))
                    $this->_oOriginalRecipientData->integerData = $this->_oRecipientData->integerData;
                if(isset($this->_oRecipientData->stringData))
                    $this->_oOriginalRecipientData->stringData = $this->_oRecipientData->stringData;
                if(isset($this->_oRecipientData->timeData))
                    $this->_oOriginalRecipientData->timeData = $this->_oRecipientData->timeData;
                if(isset($this->_oRecipientData->id))
                    $this->_oOriginalRecipientData->id = $this->_oRecipientData->id;
	}


	public function getRecipient()
	{
		return $this->_oOriginalRecipientData;
	}


	public function getTestrecipientData()
	{
		return $this->_oRecipientData;
	}
}