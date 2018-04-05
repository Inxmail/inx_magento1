<?php

abstract class Inx_Apiimpl_Rendering_AbstractRenderer
{
    /**
     * @var Inx_Apiimpl_SessionContext
     */
    protected $_sessionContext;

    /**
     * @var Inx_Apiimpl_RemoteRef
     */
    protected $_remoteRef;

    /**
     * @var Inx_Apiimpl_Rendering_RendererState
     */
    protected $_state;

    protected function __construct(Inx_Apiimpl_SessionContext $sc)
    {
        $this->_sessionContext = $sc;
        $this->_state = Inx_Apiimpl_Rendering_RendererState::NOT_INITIALIZED();
    }

    public function parse($iMailingId, Inx_Api_Rendering_BuildMode $buildMode, $iSendingId = null)
    {
        try
        {
            $this->_state = Inx_Apiimpl_Rendering_RendererState::NOT_INITIALIZED();

            if ($buildMode == Inx_Api_Rendering_BuildMode::UNKNOWN())
                throw new Inx_Api_IllegalArgumentException("illegal build mode: " . $buildMode->getId());

            $result = null;

            if (!is_null($iSendingId) && $iSendingId != -1)
            {
                $result = $this->callParseWithSendingId($this->_sessionContext->createCxt(), $iMailingId, $iSendingId,
                    $buildMode->getId());
            }
            else
            {
                $result = $this->callParse($this->_sessionContext->createCxt(), $iMailingId, $buildMode->getId());
            }

            $resultCode = $this->extractParseResultCode($result);

            switch ($resultCode)
            {
                case Inx_Apiimpl_Rendering_ParseResultCode::PARSE_SUCCESSFUL():
                    $this->_state = Inx_Apiimpl_Rendering_RendererState::PARSED();
                    $this->_remoteRef = $this->extractRemoteRef($result);
                    return;

                case Inx_Apiimpl_Rendering_ParseResultCode::PARSE_EXCEPTION():
                    $this->_state = Inx_Apiimpl_Rendering_RendererState::PARSE_FAILED();
                    throw $this->createParseException($result);

                case Inx_Apiimpl_Rendering_ParseResultCode::MAILING_NOT_FOUND():
                    throw new Inx_Api_APIException("mailing not found: $iMailingId");

                case Inx_Apiimpl_Rendering_ParseResultCode::SENDING_NOT_FOUND():
                    throw new Inx_Api_APIException("sending not found: $iSendingId");

                case Inx_Apiimpl_Rendering_ParseResultCode::SENDING_NOT_APPLICABLE():
                    throw new Inx_Api_APIException("sending $iSendingId not applicable for rendering of mailing $iMailingId");

                default:
                    throw new Inx_Api_IllegalArgumentException("illegal parse result code: $resultCode->getId()");
            }
        }
        catch (Inx_Api_RemoteException $x)
        {
            $this->_sessionContext->notify($x);
        }
    }

    public function build($iRecipientId, Inx_Api_Rendering_ContentType $preferredMailType = null)
    {
        try
        {
            if ($this->_state != Inx_Apiimpl_Rendering_RendererState::PARSED())
                throw new Inx_Api_IllegalStateException("the parsing must be successful");

            if ($preferredMailType == Inx_Api_Rendering_ContentType::UNKNOWN())
                throw new Inx_Api_IllegalArgumentException("the UNKNOWN content type is illegal");

            $result = null;

            if (!is_null($preferredMailType))
            {
                $result = $this->callBuild($this->_remoteRef->createCxt(), $this->_remoteRef->refId(), $iRecipientId,
                    $preferredMailType->getId());
            }
            else
            {
                $result = $this->callBuild($this->_remoteRef->createCxt(), $this->_remoteRef->refId(), $iRecipientId,
                    Inx_Api_Rendering_ContentType::SYSTEM()->getId());
            }

            $resultCode = $this->extractBuildResultCode($result);

            if ($resultCode == Inx_Apiimpl_Rendering_BuildResultCode::BUILD_EXCEPTION())
            {
                throw $this->createBuildException($result);
            }
            else
            {
                return $this->createContent($this->_remoteRef, $result);
            }
        }
        catch (Inx_Api_RemoteException $x)
        {
            $this->_sessionContext->notify($x);
            return null;
        }
    }

    public function close()
    {
        if ($this->_remoteRef == null)
            return;

        $this->_remoteRef->release(false);
    }

    protected abstract function callParse(stdClass $cxt, $iMailingId, $iBuildModeId);

    protected abstract function callParseWithSendingId(stdClass $cxt, $iMailingId, $iSendingId, $iBuildModeId);

    protected abstract function extractParseResultCode(stdClass $parseResult);

    protected abstract function extractRemoteRef(stdClass $parseResult);

    protected abstract function callBuild(stdClass $cxt, $sRefId, $iRecipientId, $iPreferredMailType);

    protected abstract function extractBuildResultCode(stdClass $buildResult);

    protected abstract function createContent(Inx_Apiimpl_RemoteRef $remoteRef, stdClass $buildResult);

    protected abstract function createBuildException(stdClass $buildResult);

    protected abstract function createParseException(stdClass $parseResult);
}
