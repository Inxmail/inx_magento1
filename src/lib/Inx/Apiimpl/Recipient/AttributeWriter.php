<?php
interface Inx_Apiimpl_Recipient_AttributeWriter
{
	public function updateString( $oTarget, array &$aChangedAttrs, $sValue );


	public function updateBoolean( $oTarget, array &$aChangedAttrs, $blValue );


	public function updateInteger( $oTarget, array &$aChangedAttrs, $iValue );


	public function updateDouble( $oTarget, array &$aChangedAttrs, $fValue );


	public function updateDate( $oTarget, array &$aChangedAttrs, $sValue );


	public function updateTime( $oTarget, array &$aChangedAttrs, $sValue );


	public function updateDatetime( $oTarget, array &$aChangedAttrs, $sValue );


	public function updateObject( $oTarget, array &$aChangedAttrs, $sValue );
}