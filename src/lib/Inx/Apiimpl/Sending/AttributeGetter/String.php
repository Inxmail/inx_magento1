<?php
class Inx_Apiimpl_Sending_AttributeGetter_String 
        extends Inx_Apiimpl_Sending_SendingRecipientAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct( $iTypedIndex );
        }


        public function getObject( $oData )
        {
                return $this->getString( $oData );
        }


        public function getString( $oData )
        {
                return Inx_Apiimpl_TConvert::convert( $oData->stringData[$this->_iTypedIndex] );
        }
}