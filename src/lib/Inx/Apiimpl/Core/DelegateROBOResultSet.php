<?php
class Inx_Apiimpl_Core_DelegateROBOResultSet extends Inx_Apiimpl_Core_AbstractROBOResultSet
{
	private $_oDelegate;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, Inx_Apiimpl_Core_ROBOResultSetDelegate $oDelegate, 
                $sRemoteRefId, $iSize, $aFirstChunk )
	{
		parent::__construct( $oSc, $sRemoteRefId, $iSize, $aFirstChunk );
		$this->_oDelegate = $oDelegate;
	}


	protected function fetchBOs( $iIndex, $iDirection )
	{
		return $this->_oDelegate->fetchBOs( $this->_remoteRef(), $iIndex, $iDirection );
	}
}