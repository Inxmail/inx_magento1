<?php

/**
 * MailingRendererImpl
 *
 * @version $Revision: 19494 $ $Date: 2010-12-14 10:11:12 +0100 (Di, 14 Dez 2010) $ $Author: sbn $
 */
class Inx_Apiimpl_TriggerMailing_TriggerMailingRendererImpl extends Inx_Apiimpl_Rendering_AbstractRenderer
    implements Inx_Api_TriggerMail_TriggerMailingRenderer
{
    protected $_service;

    public function __construct(Inx_Apiimpl_SessionContext $sc)
    {
        parent::__construct($sc);
        $this->_service = $this->_sessionContext->getService(Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE);
    }

    public function parse($iMailingId, Inx_Api_TriggerMail_BuildMode $buildMode, $iSendingId = null)
    {
        $generalBuildMode = $this->toGeneralBuildMode($buildMode);
        parent::parse($iMailingId, $generalBuildMode, $iSendingId);
    }

    public function build($iRecipientId, Inx_Api_TriggerMail_TriggerMailingContentType $preferredMailType = null)
    {
        if (null === $preferredMailType)
        {
            $preferredMailType = Inx_Api_TriggerMail_TriggerMailingContentType::SYSTEM();
        }

        $generalContentType = $this->toGeneralContentType($preferredMailType);
        return parent::build($iRecipientId, $generalContentType);
    }

    protected function createParseException(stdClass $parseResult)
    {
        $errorData = $parseResult->errors;
        $errors = array();

        for ($i = 0; $i < sizeof($errorData); $i++)
        {
            $errors[$i] = $this->createRenderError($errorData[$i]);
        }

        return new Inx_Api_TriggerMail_ParseException($errors);
    }

    protected function createBuildException(stdClass $buildResult)
    {
        $error = $this->createRenderError($buildResult->errors);
        return new Inx_Api_TriggerMail_BuildException($buildResult->errorEmail, $error);
    }

    private function createRenderError(stdClass $data)
    {
        return new Inx_Api_TriggerMail_RenderError($data->errorType, $data->mailPart, $data->beginLine, $data->endLine,
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
        return new Inx_Apiimpl_TriggerMailing_TriggerMailContentImpl($remoteRef, $buildResult);
    }

    private function toGeneralBuildMode(Inx_Api_TriggerMail_BuildMode $buildMode)
    {
        return Inx_Api_Rendering_BuildMode::byId($buildMode->getId());
    }

    private function toGeneralContentType(Inx_Api_TriggerMail_TriggerMailingContentType $contentType)
    {
        switch ($contentType)
        {
            case Inx_Api_TriggerMail_TriggerMailingContentType::HTML_TEXT():
                return Inx_Api_Rendering_ContentType::HTML_TEXT();

            case Inx_Api_TriggerMail_TriggerMailingContentType::PLAIN_TEXT():
                return Inx_Api_Rendering_ContentType::PLAIN_TEXT();

            case Inx_Api_TriggerMail_TriggerMailingContentType::MULTIPART():
                return Inx_Api_Rendering_ContentType::MULTIPART();

            // that's what the server side does with it anyway
            case Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_HTML_TEXT():
            case Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_PLAIN_TEXT():
            case Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_MULTIPART():
            case Inx_Api_TriggerMail_TriggerMailingContentType::SYSTEM():
                return Inx_Api_Rendering_ContentType::SYSTEM();

            default:
                return Inx_Api_Rendering_ContentType::UNKNOWN();
        }
    }
}
