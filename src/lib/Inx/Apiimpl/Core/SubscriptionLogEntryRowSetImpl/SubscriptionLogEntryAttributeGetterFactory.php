<?php
class Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_SubscriptionLogEntryAttributeGetterFactory 
    implements Inx_Apiimpl_Recipient_AttributeGetterFactory
{
        public function createAttributeGetter( Inx_Api_Recipient_Attribute $oAttr, $iTypedIndex )
        {
                $getter = null;
                switch( $oAttr->getDataType() )
                {
                        case Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN:
                                $getter = new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_BooleanGetter( $iTypedIndex );
                                break;
                        case Inx_Api_Recipient_Attribute::DATA_TYPE_DATE:
                                $getter = new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_DateGetter( $iTypedIndex );
                                break;
                        case Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME:
                                $getter = new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_DateTimeGetter( $iTypedIndex );
                                break;
                        case Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE:
                                $getter = new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_DoubleGetter( $iTypedIndex );
                                break;
                        case Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER:
                                $getter = new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_IntegerGetter( $iTypedIndex );
                                break;
                        case Inx_Api_Recipient_Attribute::DATA_TYPE_STRING:
                                $getter = new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_StringGetter( $iTypedIndex );
                                break;
                        case Inx_Api_Recipient_Attribute::DATA_TYPE_TIME:
                                $getter = new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_TimeGetter( $iTypedIndex );
                                break;
                }
                return $getter;
        }
}