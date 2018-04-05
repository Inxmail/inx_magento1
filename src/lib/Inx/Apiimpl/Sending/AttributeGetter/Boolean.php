<?php
class Inx_Apiimpl_Sending_AttributeGetter_Boolean 
        extends Inx_Apiimpl_Sending_SendingRecipientAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct( $iTypedIndex );
        }


        public function getObject( $oData )
        {
                return $this->getBoolean( $oData );
        }


        public function getBoolean( $oData )
        {
                return Inx_Apiimpl_TConvert::convert( $oData->booleanData[$this->_iTypedIndex] );
        }
}