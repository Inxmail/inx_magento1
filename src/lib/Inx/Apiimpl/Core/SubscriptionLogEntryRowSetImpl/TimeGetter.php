<?php
class Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_TimeGetter 
    extends Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_SubscriptionLogEntryAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct($iTypedIndex);
        }


        public function getObject( $oData )
        {
                return $this->getTime( $oData );
        }


        public function getTime( $oData )
        {
                return Inx_Apiimpl_TConvert::convert( $oData->timeData[$this->_iTypedIndex] );
        }
}