<?php

/**
 * MailingRendererImpl
 *
 * @version $Revision: 6324 $ $Date: 2007-05-16 11:28:15 +0000 (Mi, 16 Mai 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_Mailing_MailingRendererTestRecipientImpl extends Inx_Apiimpl_Mailing_MailingRendererImpl
{

    public function __construct(Inx_Apiimpl_SessionContext $oSc)
    {
        parent::__construct($oSc);
    }

    protected function callBuild(stdClass $cxt, $sRefId, $iRecipientId, $iPreferredMailType)
    {
        return $this->_service->buildMailForTestRecipient($cxt, $sRefId, $iRecipientId, $iPreferredMailType);
    }
}
