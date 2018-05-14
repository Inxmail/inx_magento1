<?php
class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_BooleanGetter 
    extends Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetter
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