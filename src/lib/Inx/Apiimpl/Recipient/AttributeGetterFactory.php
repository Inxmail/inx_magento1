<?php
interface Inx_Apiimpl_Recipient_AttributeGetterFactory
{
	public function createAttributeGetter( Inx_Api_Recipient_Attribute $oAttr, $iTypedIndex );
}