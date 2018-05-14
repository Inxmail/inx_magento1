<?php
class Inx_Apiimpl_Sending_AttributeGetter_Integer 
        extends Inx_Apiimpl_Sending_SendingRecipientAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct( $iTypedIndex );
        }


        public function getObject( $oData )
        {
                return $this->getInteger( $oData );
        }


        public function getInteger( $oData )
        {
                return Inx_Apiimpl_TConvert::convert( $oData->integerData[$this->_iTypedIndex] );
        }
}