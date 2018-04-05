<?php
class Inx_Apiimpl_Testprofiles_TestRecipientAttributeAccessor 
    implements Inx_Apiimpl_Recipient_AttributeGetter, Inx_Apiimpl_Recipient_AttributeWriter
{
        /**
         * @var Inx_Apiimpl_Recipient_ContextAttribute
         */
	private $_oDelegate;


	public function __construct( Inx_Apiimpl_Recipient_ContextAttribute $oDelegate )
	{
		$this->_oDelegate = $oDelegate;
	}


	public function getTime( $oSource )
	{
		return $this->_oDelegate->getTime( $oSource->getRecipient() );
	}


	public function getString( $oSource )
	{
		return $this->_oDelegate->getString( $oSource->getRecipient() );
	}


	public function getDouble( $oSource )
	{
		return $this->_oDelegate->getDouble( $oSource->getRecipient() );
	}


	public function getDate( $oSource )
	{
		return $this->_oDelegate->getDate( $oSource->getRecipient() );
	}


	public function getObject( $oSource )
	{
		return $this->_oDelegate->getObject( $oSource->getRecipient() );
	}


	public function getInteger( $oSource )
	{
		return $this->_oDelegate->getInteger( $oSource->getRecipient() );
	}


	public function getBoolean( $oSource )
	{
		return $this->_oDelegate->getBoolean( $oSource->getRecipient() );
	}


	public function getDatetime( $oSource )
	{
		return $this->_oDelegate->getDatetime( $oSource->getRecipient() );
	}


	public function updateString( $oTarget, array &$aChangedAttrs, $sValue )
	{
		$this->_oDelegate->updateString( $oTarget->getRecipient(), $aChangedAttrs, $sValue );
	}


	public function updateBoolean( $oTarget, array &$aChangedAttrs, $blValue )
	{
		$this->_oDelegate->updateBoolean( $oTarget->getRecipient(), $aChangedAttrs, $blValue );
	}


	public function updateInteger( $oTarget, array &$aChangedAttrs, $iValue )
	{
		$this->_oDelegate->updateInteger( $oTarget->getRecipient(), $aChangedAttrs, $iValue );
	}


	public function updateDouble( $oTarget, array &$aChangedAttrs, $fValue )
	{
		$this->_oDelegate->updateDouble( $oTarget->getRecipient(), $aChangedAttrs, $fValue );
	}


	public function updateDate( $oTarget, array &$aChangedAttrs, $sValue )
	{
		$this->_oDelegate->updateDate( $oTarget->getRecipient(), $aChangedAttrs, $sValue );
	}


	public function updateTime( $oTarget, array &$aChangedAttrs, $sValue )
	{
		$this->_oDelegate->updateTime( $oTarget->getRecipient(), $aChangedAttrs, $sValue );
	}


	public function updateDatetime( $oTarget, array &$aChangedAttrs, $sValue )
	{
		$this->_oDelegate->updateDatetime( $oTarget->getRecipient(), $aChangedAttrs, $sValue );
	}


	public function updateObject( $oTarget, array &$aChangedAttrs, $oValue )
	{
		$this->_oDelegate->updateObject( $oTarget->getRecipient(), $aChangedAttrs, $oValue );
	}
}