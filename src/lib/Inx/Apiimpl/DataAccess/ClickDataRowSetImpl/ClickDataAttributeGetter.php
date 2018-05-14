<?php
abstract class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetter implements Inx_Apiimpl_Recipient_AttributeGetter
{
	protected $_iTypedIndex;

	private static $_oFactory;


	protected function __construct( $iTypedIndex )
	{
		$this->_iTypedIndex = $iTypedIndex;
	}


	public static function getFactory()
	{
                if(null === self::$_oFactory)
                    self::$_oFactory = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_ClickDataAttributeGetterFactory();
		return self::$_oFactory;
	}


	public function getDatetime( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getTime( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getString( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getDouble( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getDate( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getInteger( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getBoolean( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}
}