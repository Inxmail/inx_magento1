<?php
class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetterFactory 
    implements Inx_Apiimpl_Recipient_AttributeGetterFactory
{
    public function createAttributeGetter( Inx_Api_Recipient_Attribute $oAttr, $iTypedIndex )
    {
            $getter = null;
            switch( $oAttr->getDataType() )
            {
                    case Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN:
                            $getter = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_BooleanGetter( $iTypedIndex );
                            break;
                    case Inx_Api_Recipient_Attribute::DATA_TYPE_DATE:
                            $getter = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DateGetter( $iTypedIndex );
                            break;
                    case Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME:
                            $getter = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DateTimeGetter( $iTypedIndex );
                            break;
                    case Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE:
                            $getter = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DoubleGetter( $iTypedIndex );
                            break;
                    case Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER:
                            $getter = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_IntegerGetter( $iTypedIndex );
                            break;
                    case Inx_Api_Recipient_Attribute::DATA_TYPE_STRING:
                            $getter = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_StringGetter( $iTypedIndex );
                            break;
                    case Inx_Api_Recipient_Attribute::DATA_TYPE_TIME:
                            $getter = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_TimeGetter( $iTypedIndex );
                            break;
            }
            return $getter;
    }
}