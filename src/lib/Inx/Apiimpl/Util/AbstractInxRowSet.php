<?php
abstract class Inx_Apiimpl_Util_AbstractInxRowSet extends Inx_Apiimpl_RemoteObject 
        implements Inx_Api_InxRowSet
{
	protected $_iRowCount;

	protected $_oBuffer = null;

	protected $_iCurrentRow = -1;

	protected $_iLastAccessedIndex = -1;

	protected $_oCurrentObject;

	protected $_sTypeName;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, $sRemoteRefId, $iRowCount, 
                $aInitialBulk, $sTypeName )
	{
		parent::__construct( $oSc, $sRemoteRefId );
		$this->_iRowCount = $iRowCount;
		$this->_sTypeName = $sTypeName;
                $this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();

		if( !empty($aInitialBulk) )
		{
			// set the first bulk, beginning at index 0.
			$this->_oBuffer->setBuffer( 0, $aInitialBulk );
		}
	}


	public function beforeFirstRow()
	{
		$this->_iCurrentRow = -1;
		$this->_oCurrentObject = null;
	}


	public function afterLastRow()
	{
		$this->_iCurrentRow = $this->_iRowCount;
		$this->_oCurrentObject = null;
	}


	public function setRow( $iRow )
	{
		if( $iRow < 0 || $iRow >= $this->_iRowCount )
			throw new Inx_Api_IndexOutOfBoundsException( "Index: " . $iRow . ", Size: " . $this->_iRowCount );
		$this->_iCurrentRow = $iRow;
		$this->fetchRowData();
	}


	public function getRow()
	{
		return $this->_iCurrentRow;
	}


	public function next()
	{
		if( $this->_iCurrentRow >= $this->_iRowCount - 1 )
			return false;

		$this->_iCurrentRow++;
		$this->fetchRowData();
		return true;
	}


	public function previous()
	{
		if( $this->_iCurrentRow < 1 )
			return false;

		$this->_iCurrentRow--;
		$this->fetchRowData();
		return true;
	}


	public function getRowCount()
	{
		return $this->_iRowCount;
	}


	public function close()
	{
		$this->_release( true );
	}


	protected function checkExists()
	{
		if( $this->_iCurrentRow == -1 && $this->_oCurrentObject == null )
			throw new Inx_Api_DataException( "No row selected - Please call next() before retrieving data" );

		if( $this->_oCurrentObject == null )
			throw new Inx_Api_DataException( $this->_sTypeName . " deleted" );
	}


	protected function fetchRowData()
	{
		$this->_oCurrentObject = null;

		try
		{
			$this->_oCurrentObject = $this->_oBuffer->getObject( $this->_iCurrentRow );
		}
		catch( Inx_Apiimpl_Util_IndexException $x )
		{
			try
			{
				if( $this->_iCurrentRow >= $this->_iLastAccessedIndex )
				{
					$this->_oBuffer->setBuffer( $this->_iCurrentRow, $this->doFetch( $this->_createCxt(), 
                                            $this->_refId(), $this->_iCurrentRow, Inx_Apiimpl_Constants::FETCH_FORWARD_DIRECTION ) );
				}
				else
				{
					$data = $this->doFetch( $this->_createCxt(), $this->_refId(), $this->_iCurrentRow, 
                                            Inx_Apiimpl_Constants::FETCH_BACKWARD_DIRECTION );
					$this->_oBuffer->setBuffer( $this->_iCurrentRow - count($data) + 1, $data );
				}
                                
				$this->_iLastAccessedIndex = $this->_iCurrentRow;
			}
			catch( Inx_Api_RemoteException $rx )
			{
				$this->_notify( $rx );
			}
			try
			{
				$this->_oCurrentObject = $this->_oBuffer->getObject( $this->_iCurrentRow );
			}
			catch( Inx_Apiimpl_Util_IndexException $ix )
			{
				throw new Inx_Api_APIException( "implementation error in AbstractInxRowSet", $ix );
			}
		}
	}


	protected abstract function doFetch( $oCxt, $sRemoteRefId, $iIndex, $iDirection );
}