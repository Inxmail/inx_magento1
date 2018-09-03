<?php
class Inx_Apiimpl_Sending_SendingRecipientAttributeGetterFactory 
    implements Inx_Apiimpl_Recipient_AttributeGetterFactory
{
        public function createAttributeGetter( Inx_Api_Recipient_Attribute $oAttr, $iTypedIndex )
        {
                $g = null;
		switch( $oAttr->getDataType() )
		{
			case Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN:
				$g = new Inx_Apiimpl_Sending_AttributeGetter_Boolean($iTypedIndex);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DATE:
				$g = new Inx_Apiimpl_Sending_AttributeGetter_Date($iTypedIndex);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME:
				$g = new Inx_Apiimpl_Sending_AttributeGetter_DateTime($iTypedIndex);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE:
				$g = new Inx_Apiimpl_Sending_AttributeGetter_Double($iTypedIndex);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER:
				$g = new Inx_Apiimpl_Sending_AttributeGetter_Integer($iTypedIndex);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_STRING:
				$g = new Inx_Apiimpl_Sending_AttributeGetter_String($iTypedIndex);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_TIME:
				$g = new Inx_Apiimpl_Sending_AttributeGetter_Time($iTypedIndex);
				break;
		}
		return $g;
        }
}