<?php
class Inx_Apiimpl_TriggerMailing_TriggerMailingResultSet extends Inx_Apiimpl_Core_AbstractBOResultSet
{
	protected $service;
        
        protected $triggerMailingManager;


	public function __construct( Inx_Apiimpl_SessionContext $sc, stdClass $resultSet, 
                Inx_Apiimpl_TriggerMailing_TriggerMailingManagerImpl $triggerMailingManager )
	{
                parent::__construct( $sc, $resultSet->remoteRefId, $resultSet->size, 
                    Inx_Apiimpl_TriggerMailing_TriggerMailingImpl::convert( $sc, $resultSet->data, 
                            $triggerMailingManager ) );

		$this->service = $sc->getService( Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE );
                $this->triggerMailingManager = $triggerMailingManager;
	}


	protected function _removeBOs( $aIndexRanges )
	{
		return $this->service->removeBOs( $this->_createCxt(), $this->_refId(), $aIndexRanges );
	}


	protected function _fetchBOs( $iIndex, $iDirection )
	{
		return Inx_Apiimpl_TriggerMailing_TriggerMailingImpl::convert( $this->_remoteRef(), 
                        $this->service->fetchBOs( $this->_createCxt(), $this->_refId(), $iIndex, $iDirection ), 
                        $this->triggerMailingManager );
	}
}