<?php
abstract class Inx_Apiimpl_Util_AbstractInsertionRowSet extends Inx_Apiimpl_Util_AbstractManipulationRowSet 
    implements Inx_Api_InsertionRowSet
{
	protected $_blInsertMode = false;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, $sRemoteRefId, $iRowCount, $aInitialBulk,
			$sTypeName, $iAttrCount )
	{
		parent::__construct( $oSc, $sRemoteRefId, $iRowCount, $aInitialBulk, $sTypeName, $iAttrCount );
	}


	public function moveToInsertRow()
	{
		$this->_blInsertMode = true;
		$this->_iCurrentRow = $this->_iRowCount;

		$this->_oOriginObject = null;
		$this->_oCurrentObject = $this->createNewObject();

                $num = sizeof($this->_aChangedAttrs);
                $this->_aChangedAttrs = ($num > 0) ? array_fill(0, $num, false) : array();
	}


	public function next()
	{
		if( $this->_blInsertMode )
			return false;

		return parent::next();
	}


	public function previous()
	{
		if( $this->_blInsertMode )
			return false;

		return parent::previous();
	}


	public function rollbackRowUpdate()
	{
		if( $this->_blInsertMode )
		{
			$this->_blInsertMode = false;
			if( $this->_iCurrentRow < 0 || $this->_iCurrentRow >= $this->_iRowCount )
			{
				$this->_oCurrentObject = null;
				$this->_oOriginObject = null;
			}
			else
			{
				parent::rollbackRowUpdate();
			}
		}
		else
		{
			parent::rollbackRowUpdate();
		}
	}


	protected abstract function createNewObject();
}