<?php
class Inx_Apiimpl_TrackingPermission_TrackingPermissionResultSet extends Inx_Apiimpl_Core_AbstractBOResultSet
{
    protected $_oService;

    public function __construct( Inx_Apiimpl_SessionContext $oSc, stdClass $oResultSet )
    {
        parent::__construct( $oSc, $oResultSet->remoteRefId, $oResultSet->size,
            Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl::convert( $oSc, $oResultSet->data ) );

        $this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::TRACKING_PERMISSION_SERVICE );
    }

    protected function _removeBOs(  $aIndexRanges ) 
    {
        return $this->_oService->removeBOs( $this->_createCxt(), $this->_refId(), $aIndexRanges );
    }

    protected function _fetchBOs( $iIndex, $iDirection ) 
    {
        return Inx_Apiimpl_TrackingPermission_TrackingPermissionImpl::convert( $this->_remoteRef(), $this->_oService->fetchBOs(
        		$this->_createCxt(), $this->_refId(), $iIndex, $iDirection ) );
    }


}
