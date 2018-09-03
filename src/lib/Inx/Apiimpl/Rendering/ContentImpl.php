<?php

class Inx_Apiimpl_Rendering_ContentImpl implements Inx_Api_Rendering_Content
{
    private $_result;

    /**
     * @var array() of Inx_Api_Rendering_Attachment
     */
    private $_attachments;

    /**
     * @var array() of Inx_Api_Rendering_Attachment
     */
    private $_embeddedImages;

    /**
     * @var array() of string -> string
     */
    private $_header;

    /**
     * @var array() of Inx_Api_Rendering_HeaderField
     */
    private $_headerList;

    public function __construct(Inx_Apiimpl_RemoteRef $rendererRef, stdClass $result)
    {
        $this->_result = $result;

        $this->_attachments = $this->createAttachments($rendererRef, $result->attachments);
        $this->_embeddedImages = $this->createAttachments($rendererRef, $result->embeddedImages);

        $headers = $result->headers;
        $this->_header = $this->createHeaderInfo($headers);
        $this->_headerList = $this->createHeaderList($headers);
    }

    private static function createAttachments(Inx_Apiimpl_RemoteRef $rendererRef, array $ad = null)
    {
        if ($ad == null)
            return array();

        $attachments = array();

        foreach ($ad as $attachmentData)
        {
            $attachments[] = new Inx_Apiimpl_Rendering_AttachmentImpl($rendererRef, $attachmentData);
        }

        return $attachments;
    }

    private static function createHeaderInfo(array $headers = null)
    {
        if ($headers == null)
            return array();

        $result = array();

        foreach ($headers as $headerData)
        {
            $result[$headerData->name] = $headerData->value;
        }

        return $result;
    }

    private static function createHeaderList(array $headers = null)
    {
        if ($headers == null)
            return array();

        $result = array();

        foreach ($headers as $headerData)
        {
            $result[] = new Inx_Api_Rendering_HeaderField($headerData->name, $headerData->value);
        }

        return $result;
    }

    public function getContentType()
    {
        return Inx_Api_Rendering_ContentType::byId($this->_result->mailType);
    }

    public function getHtmlText()
    {
        return Inx_Apiimpl_TConvert::convert($this->_result->mailPartHtmlText);
    }

    public function getPlainText()
    {
        return Inx_Apiimpl_TConvert::convert($this->_result->mailPartPlainText);
    }

    public function getSubject()
    {
        return Inx_Apiimpl_TConvert::convert($this->_result->mailPartSubject);
    }

    public function getSenderAddress()
    {
        return Inx_Apiimpl_TConvert::convert($this->_result->mailPartSender);
    }

    public function getReplyToAddress()
    {
        return Inx_Apiimpl_TConvert::convert($this->_result->mailPartReplyTo);
    }

    public function getBounceAddress()
    {
        return Inx_Apiimpl_TConvert::convert($this->_result->mailPartBounce);
    }

    public function getRecipientAddress()
    {
        return Inx_Apiimpl_TConvert::convert($this->_result->mailPartRecipient);
    }

    public function getAttachments()
    {
        return $this->_attachments;
    }

    public function getEmbeddedImages()
    {
        return $this->_embeddedImages;
    }

    public function getHeader()
    {
        return $this->_header;
    }

    public function getMultipleHeaders()
    {
        return $this->_headerList;
    }
}
