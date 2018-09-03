<?php
class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_IntegerGetter 
    extends Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetter
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