<?php
interface Inx_Apiimpl_Core_ROBOResultSetDelegate
{
	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection );
}