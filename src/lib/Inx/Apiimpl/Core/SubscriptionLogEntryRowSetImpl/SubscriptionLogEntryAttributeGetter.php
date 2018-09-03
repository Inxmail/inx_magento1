<?php
abstract class Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_SubscriptionLogEntryAttributeGetter 
    implements Inx_Apiimpl_Recipient_AttributeGetter
{
	protected $_iTypedIndex;

	private static $_oFactory;


	protected function __construct( $iTypedIndex )
	{
            $this->_iTypedIndex = $iTypedIndex;
	}


	public static function getFactory()
	{
		if(null == self::$_oFactory)
                    self::$_oFactory = 
                        new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl_SubscriptionLogEntryAttributeGetterFactory();
                return self::$_oFactory;
	}


	public function getDatetime( $oCurrentEntry )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getTime( $oCurrentEntry )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getString( $oCurrentEntry )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getDouble( $oCurrentEntry )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getDate( $oCurrentEntry )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getInteger( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getBoolean( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}
}