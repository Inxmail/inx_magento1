<?php

class Inx_Apiimpl_TriggerMailing_TriggerMailingRendererTestRecipientImpl extends Inx_Apiimpl_TriggerMailing_TriggerMailingRendererImpl
{

    public function __construct(Inx_Apiimpl_SessionContext $sc)
    {
        parent::__construct($sc);
    }

    protected function callBuild(stdClass $cxt, $sRefId, $iRecipientId, $iPreferredMailType)
    {
        return $this->_service->buildMailForTestRecipient($cxt, $sRefId, $iRecipientId, $iPreferredMailType);
    }
}
