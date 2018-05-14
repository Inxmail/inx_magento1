<?php
class Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_DateTimeGetter 
    extends Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_SubscriptionLogEntryAttributeGetter
{
        public function __construct( $iTypedIndex )
        {
                parent::__construct($iTypedIndex);
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