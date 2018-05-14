<?php

class Inx_Apiimpl_Rendering_AttachmentImpl implements Inx_Api_Rendering_Attachment
{
    /**
     * @var Inx_Apiimpl_RemoteRef
     */
    protected $_rendererRef;
    protected $_data;

    public function __construct(Inx_Apiimpl_RemoteRef $rendererRef, stdClass $data)
    {
        $this->_rendererRef = $rendererRef;
        $this->_data = $data;
    }

    public function getName()
    {
        return $this->_data->name;
    }

    public function getContentType()
    {
        return $this->_data->contentType;
    }

    public function getSize()
    {
        return $this->_data->size;
    }

    public function getContent()
    {
        try
        {
            $service = $this->_rendererRef->getService(Inx_Apiimpl_SessionContext::GENERAL_MAILING_SERVICE);

            $refId = $service->getInputStream($this->_rendererRef->createCxt(), $this->_rendererRef->refId(),
                $this->_data->streamId);
            return new Inx_Apiimpl_Core_RemoteInputStream($this->_rendererRef->createRemoteRef($refId));
        }
        catch (Inx_Api_RemoteException $x)
        {
            $this->_rendererRef->notify($x);
            return null;
        }
    }
}
