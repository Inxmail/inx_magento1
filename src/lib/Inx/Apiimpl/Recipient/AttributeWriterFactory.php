<?php
interface Inx_Apiimpl_Recipient_AttributeWriterFactory
{
	public function createAttributeWriter( Inx_Api_Recipient_Attribute $oAttr, $iTypedIndex );
}