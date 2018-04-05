<?php

class Inx_Apiimpl_Rendering_GeneralMailingRendererImpl extends Inx_Apiimpl_Rendering_AbstractRenderer
    implements Inx_Api_Rendering_GeneralMailingRenderer
{
    protected $_service;

    public function __construct(Inx_Apiimpl_SessionContext $sc)
    {
        parent::__construct($sc);
        $this->_service = $sc->getService(Inx_Apiimpl_SessionContext::GENERAL_MAILING_SERVICE);
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
        return new Inx_Apiimpl_Rendering_ContentImpl($remoteRef, $buildResult);
    }

    protected function createBuildException(stdClass $buildResult)
    {
        $error = $this->createRenderError($buildResult->errors);
        return new Inx_Api_Rendering_BuildException($buildResult->errorEmail, $error);
    }

    protected function createParseException(stdClass $parseResult)
    {
        $errorData = $parseResult->errors;
        $errors = array();

        foreach ($errorData as $i => $data)
        {
            $errors[$i] = $this->createRenderError($data);
        }

        return new Inx_Api_Rendering_ParseException($errors);
    }

    private function createRenderError(stdClass $data)
    {
        return new Inx_Api_Rendering_RenderError($data->errorType, $data->mailPart, $data->beginLine, $data->endLine,
            $data->beginColumn, $data->endColumn, Inx_Apiimpl_TConvert::TArrToArr($data->msgArgs));
    }
}
