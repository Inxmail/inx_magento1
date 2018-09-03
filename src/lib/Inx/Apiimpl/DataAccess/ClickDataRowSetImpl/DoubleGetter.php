<?php
class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DoubleGetter 
    extends Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct($iTypedIndex);
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