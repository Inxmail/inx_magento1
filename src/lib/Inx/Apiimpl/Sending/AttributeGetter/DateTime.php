<?php
class Inx_Apiimpl_Sending_AttributeGetter_DateTime 
        extends Inx_Apiimpl_Sending_SendingRecipientAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct( $iTypedIndex );
        }


        public function getObject( $oData )
        {
                return $this->getDatetime( $oData );
        }


        public function getDatetime( $oData )
        {
                return Inx_Apiimpl_TConvert::convert( $oData->datetimeData[$this->_iTypedIndex] );
        }
}