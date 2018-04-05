<?php
class Inx_Apiimpl_Sending_AttributeGetter_Double 
        extends Inx_Apiimpl_Sending_SendingRecipientAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct( $iTypedIndex );
        }


        public function getObject( $oData )
        {
                return $this->getDouble( $oData );
        }


        public function getDouble( $oData )
        {
                return Inx_Apiimpl_TConvert::convert( $oData->doubleData[$this->_iTypedIndex] );
        }
}