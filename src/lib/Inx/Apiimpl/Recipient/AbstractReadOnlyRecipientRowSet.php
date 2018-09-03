<?php
abstract class Inx_Apiimpl_Recipient_AbstractReadOnlyRecipientRowSet extends Inx_Apiimpl_Util_AbstractInxRowSet 
    implements Inx_Api_Recipient_ReadOnlyRecipientRowSet
{
	protected $_oRecipientContext;
        
        protected $_aAttrGetterMapping;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, $sRemoteRefId, $iRowCount, array $aInitialBulk,
                $sTypeName, Inx_Api_Recipient_RecipientContext $oRecipientManager, array $aAttributes, array $aTypedIndices, 
                Inx_Apiimpl_Recipient_AttributeGetterFactory $oAttributeGetterFactory )
	{
		parent::__construct( $oSc, $sRemoteRefId, $iRowCount, $aInitialBulk, $sTypeName );
                
		$this->_oRecipientContext = $oRecipientManager;
                $this->_aAttrGetterMapping = array();
                
                if( $aAttributes != null )
                {
                    for($i = 0; $i < sizeof($aAttributes); $i++)
                    {
                        $attr = $aAttributes[$i];

                        $getter = $oAttributeGetterFactory->createAttributeGetter($attr, $aTypedIndices[$i]);
                        $this->_aAttrGetterMapping[$attr->getId()] = $getter;
                    }
                }
	}


	public function getBoolean( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getBoolean( $this->_oCurrentObject );
	}


	public function getInteger( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getInteger( $this->_oCurrentObject );
	}


	public function getDouble( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getDouble( $this->_oCurrentObject );
	}


	public function getDate( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getDate( $this->_oCurrentObject );
	}


	public function getTime( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getTime( $this->_oCurrentObject );
	}


	public function getDatetime( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getDatetime( $this->_oCurrentObject );
	}


	public function getString( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getString( $this->_oCurrentObject );
	}


	public function getObject( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )->getObject( $this->_oCurrentObject );
	}


	public function getContext()
	{
		return $this->_oRecipientContext;
	}


	public function getMetaData()
	{
		return $this->_oRecipientContext->getMetaData();
	}


	protected function checkReadAccess( Inx_Api_Recipient_Attribute $oAttr )
	{
		$this->checkRecipientExists();

		if( $oAttr->getContext() == $this->_oRecipientContext )
                {
                    $ret = $this->_aAttrGetterMapping[$oAttr->getId()];
                    if($ret == null)
                        throw new Inx_Api_IllegalArgumentException('attribute not in fetch profile');
                    return $ret;
                }

		throw new Inx_Api_IllegalStateException( 'wrong context' );
	}


	protected abstract function checkRecipientExists();
}