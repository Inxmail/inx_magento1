<?php

/**
 * MailingRendererImpl
 *
 * @version $Revision: 6324 $ $Date: 2007-05-16 11:28:15 +0000 (Mi, 16 Mai 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_Mailing_MailingRendererImpl extends Inx_Apiimpl_Rendering_AbstractRenderer
    implements Inx_Api_Mail_MailingRenderer
{
    protected $_service;

    public function __construct(Inx_Apiimpl_SessionContext $oSc)
    {
        parent::__construct($oSc);
        $this->_service = $this->_sessionContext->getService(Inx_Apiimpl_SessionContext::MAILING7_SERVICE);
    }

    /**
     * Enter description here->->->
     *
     * @param int $iMailingId
     * @param int $iBuildMode
     * @throws Inx_Api_Mail_ParseException
     */
    public function parse($iMailingId, $iBuildMode)
    {
        if (!is_int($iMailingId))
        {
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got ' . gettype($iMailingId));
        }
        if (!is_int($iBuildMode))
        {
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iBuildMode expected, got ' . gettype($iBuildMode));
        }

        $generalBuildMode = Inx_Api_Rendering_BuildMode::byId($iBuildMode);
        parent::parse($iMailingId, $generalBuildMode);
    }

    /**
     * Enter description here->->->
     *
     * @param int $iRecipientId
     * @param int $iPreferredMailType
     * @return Inx_Api_Mail_MailContent
     * @throws Inx_Api_Mail_BuildException
     */
    public function build($iRecipientId, $iPreferredMailType = Inx_Api_Mailing_MailingConstants::MAIL_TYPE_SYSTEM)
    {
        if (!is_int($iRecipientId))
        {
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got ' . gettype($iRecipientId));
        }
        if (!is_int($iPreferredMailType))
        {
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iPreferredMailType expected, got ' . gettype($iPreferredMailType));
        }

        $contentType = $this->toGeneralContentType($iPreferredMailType);
        return parent::build($iRecipientId, $contentType);
    }

    protected function createParseException(stdClass $parseResult)
    {
        $errorData = $parseResult->errors;
        $errors = array();

        for ($i = 0; $i < sizeof($errorData); $i++)
        {
            $errors[$i] = $this->createRenderError($errorData[$i]);
        }

        return new Inx_Api_Mail_ParseException($errors);
    }

    protected function createBuildException(stdClass $buildResult)
    {
        $error = $this->createRenderError($buildResult->errors);
        return new Inx_Api_Mail_BuildException($buildResult->errorEmail, $error);
    }

    private function createRenderError(stdClass $data)
    {
        return new Inx_Api_Mail_RenderError($data->errorType, $data->mailPart, $data->beginLine, $data->endLine,
            $data->beginColumn, $data->endColumn, Inx_Apiimpl_TConvert::TArrToArr($data->msgArgs));
    }

    protected function callParse(stdClass $cxt, $iMailingId, $iBuildModeId)
    {
        return $this->_service->parseMail($cxt, $iMailingId, $iBuildModeId);
    }

    protected function callParseWithSendingId(stdClass $cxt, $iMailingId, $iSendingId, $iBuildModeId)
    {
        return $this->_service->parseMailWithSendingId($cxt, $iMailingId, $iBuildModeId, $iSendingId);
    }

    protected function extractParseResultCode(stdClass $parseResult)
    {
        return Inx_Apiimpl_Rendering_ParseResultCode::byId($parseResult->resultType);
    }

    protected function extractRemoteRef(stdClass $parseResult)
    {
        return $this->_sessionContext->createRemoteRef($parseResult->remoteRefId);
    }

    protected function callBuild(stdClass $cxt, $sRefId, $iRecipientId, $iPreferredMailType)
    {
        return $this->_service->buildMail($cxt, $sRefId, $iRecipientId, $iPreferredMailType);
    }

    protected function extractBuildResultCode(stdClass $buildResult)
    {
        return Inx_Apiimpl_Rendering_BuildResultCode::byId($buildResult->resultType);
    }

    protected function createContent(Inx_Apiimpl_RemoteRef $remoteRef, stdClass $buildResult)
    {
        return new Inx_Apiimpl_Mailing_MailContentImpl($remoteRef, $buildResult);
    }

    private function toGeneralContentType($iPreferredMailType)
    {
        switch ($iPreferredMailType)
        {
            case Inx_Api_Mail_MailContent::MAIL_TYPE_HTML_TEXT:
                return Inx_Api_Rendering_ContentType::HTML_TEXT();

            case Inx_Api_Mail_MailContent::MAIL_TYPE_PLAIN_TEXT:
                return Inx_Api_Rendering_ContentType::PLAIN_TEXT();

            case Inx_Api_Mail_MailContent::MAIL_TYPE_MULTIPART:
                return Inx_Api_Rendering_ContentType::MULTIPART();

            // everything else is mapped to default on the service side
            default:
                return Inx_Api_Rendering_ContentType::SYSTEM();
        }
    }
}
