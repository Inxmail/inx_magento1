<?php
abstract class Inx_Apiimpl_Util_AbstractManipulationRowSet extends Inx_Apiimpl_Util_AbstractInxRowSet 
        implements Inx_Api_ManipulationRowSet
{
	protected $_oOriginObject = null;

	protected $_aChangedAttrs;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, $sRemoteRefId, $iRowCount, 
                $aInitialBulk, $sTypeName, $iAttrCount )
	{
		parent::__construct( $oSc, $sRemoteRefId, $iRowCount, $aInitialBulk, $sTypeName );
                
		if ($iAttrCount > 0) 
                {
			$this->_aChangedAttrs = array_fill(0, $iAttrCount, false);
		}
	}


	public function beforeFirstRow()
	{
		parent::beforeFirstRow();
		$this->_oOriginObject = null;
	}


	public function afterLastRow()
	{
		parent::afterLastRow();
		$this->_oOriginObject = null;
	}


	public function deleteRow()
	{
		$this->deleteRows( new Inx_Api_IndexSelection( $this->_iCurrentRow ) );
	}


	public function deleteRows( Inx_Api_IndexSelection $oSelection )
	{
                Inx_Apiimpl_Util_SelectionUtils::checkIndex($oSelection, $this->_iRowCount);
                
		try
		{
			$this->_iRowCount = $this->doDelete( $this->_createCxt(), $this->_refId(), 
                            Inx_Apiimpl_Util_SelectionUtils::convertToArray($oSelection) );

			$this->_oBuffer->clear();
			$this->beforeFirstRow();
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_notify( $x );
		}
	}


	public function isRowDeleted()
	{
		return $this->_oCurrentObject == null;
	}


	public function commitRowUpdate()
	{
		$this->checkExists();

		try
		{
			$this->_oCurrentObject = $this->doUpdate( $this->_createCxt(), $this->_refId(), 
                                $this->_oOriginObject, $this->_aChangedAttrs );
			$this->_oOriginObject = null;
			$this->_oBuffer->setBuffer( $this->_iCurrentRow, $this->_oCurrentObject );

			$this->rollbackRowUpdate();
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_notify( $x );
		}
	}


	public function rollbackRowUpdate()
	{
		$this->fetchRowData();
	}


	protected function fetchRowData()
	{
		$this->_oOriginObject = null;
		parent::fetchRowData();
	}


	protected abstract function doDelete( $oSc, $sRemoteRefId, array $aIndices );


	protected abstract function doUpdate( $oSc, $sRemoteRefId, stdClass $oData, array $aChangedAttrs );
}