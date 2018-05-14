<?php
interface Inx_Apiimpl_Recipient_AttributeGetter
{
	public function getTime( $oSource );


	public function getString( $oSource );


	public function getDouble( $oSource );


	public function getDate( $oSource );


	public function getObject( $oSource );


	public function getInteger( $oSource );


	public function getBoolean( $oSource );


	public function getDatetime( $oSource );
}