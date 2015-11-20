<?php
class Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_DoubleGetter 
    extends Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_SubscriptionLogEntryAttributeGetter
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