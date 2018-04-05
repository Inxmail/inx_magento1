<?php
class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DateGetter 
    extends Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
            parent::__construct( $iTypedIndex );
        }


        public function getObject( $oData )
        {
                return $this->getDate( $oData );
        }


        public function getDate( $oData )
        {
                return Inx_Apiimpl_TConvert::convert( $oData->dateData[$this->_iTypedIndex] );
        }
}