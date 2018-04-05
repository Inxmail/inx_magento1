<?php
/**
 * 
 * 
 * @author sbn, 17.01.2007
 * @copyright Inxmail GmbH
 * @version $Revision:$ $Date:$ $Author:$
 */
class Inx_Apiimpl_DataAccess_LinkDataRowSetImpl
                 extends Inx_Apiimpl_Util_AbstractInxRowSet implements Inx_Api_DataAccess_LinkDataRowSet
{
        private $_oService;

	public function __construct( Inx_Apiimpl_SessionContext $sc, $oResult )
	{
		parent::__construct( $sc, $oResult->remoteRefId, $oResult->rowCount, $oResult->data, 'link' );
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::DATAACCESS4_SERVICE );
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getActionId()
	{
		$this->checkExists();
		return $this->_oCurrentObject->actionId;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkId() 
	{
		$this->checkExists();
		return $this->_oCurrentObject->linkId;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkName()
	{
		$this->checkExists();
		return Inx_Apiimpl_TConvert::convert($this->_oCurrentObject->linkName);
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkType()
	{
		$this->checkExists();
		return $this->_oCurrentObject->linkType;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkUrl()
	{
		$this->checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentObject->linkUrl );
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getMailingId()
	{
		$this->checkExists();
		return $this->_oCurrentObject->mailing;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function isPermanent()
	{
		$this->checkExists();
		return $this->_oCurrentObject->permanent;
	}

	protected function doFetch($oCxt, $sRemoteRefId, $iIndex, $iDirection) 
        {
            return $this->_oService->fetchLink( $oCxt, $sRemoteRefId, $iIndex, $iDirection );
        }
}
