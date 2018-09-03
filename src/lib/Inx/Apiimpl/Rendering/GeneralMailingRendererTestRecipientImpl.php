<?php
class Inx_Apiimpl_Rendering_GeneralMailingRendererTestRecipientImpl extends Inx_Apiimpl_Rendering_GeneralMailingRendererImpl
{
	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		parent::__construct($sc);
	}


	protected function callBuild( stdClass $cxt, $sRefId, $iRecipientId, $iPreferredMailType )
	{
		return $this->_service->buildMailForTestRecipient( $cxt, $sRefId, $iRecipientId, $iPreferredMailType );
	}
}