<?php
abstract class Inx_Apiimpl_Sending_SendingRecipientAttributeGetter 
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
            if(is_null(self::$_oFactory))
                self::$_oFactory = new Inx_Apiimpl_Sending_SendingRecipientAttributeGetterFactory();
            return self::$_oFactory;
        }


	public function getDatetime( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getTime( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getString( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getDouble( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}


	public function getDate( $oData )
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