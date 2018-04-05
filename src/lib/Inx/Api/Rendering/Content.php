<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * The <i>Inx_Api_Rendering_Content</i> contains the personalized content of a mailing for a specific recipient. The
 * information that can be retrieved from the <i>Inx_Api_Rendering_Content</i> includes:
 * <ul>
 * <li><i>The content type</i>: Inx_Api_Rendering_Content::getContentType()
 * <li><i>Plain/HTML text</i>: Inx_Api_Rendering_Content::getPlainText() and Inx_Api_Rendering_Content::getHtmlText()
 * <li><i>The subject</i>: Inx_Api_Rendering_Content::getSubject()
 * <li><i>The recipient address</i>: Inx_Api_Rendering_Content::getRecipientAddress()
 * <li><i>The sender address</i>: Inx_Api_Rendering_Content::getSenderAddress()
 * <li><i>The bounce and reply addresses</i>: Inx_Api_Rendering_Content::getBounceAddress() and
 * Inx_Api_Rendering_Content::getReplyToAddress()
 * <li><i>Attachments</i>: Inx_Api_Rendering_Content::getAttachments()
 * <li><i>Embedded images</i>: Inx_Api_Rendering_Content::getEmbeddedImages()
 * <li><i>The mail headers</i>: Inx_Api_Rendering_Content::getHeader() or
 * Inx_Api_Rendering_Content::getMultipleHeaders()
 * </ul>
 * A <i>Inx_Api_Rendering_Content</i> object is created by a Inx_Api_Rendering_Content::GeneralMailingRenderer using
 * its <i>build</i> methods.
 *
 * @see Inx_Api_Rendering_GeneralMailingRenderer::build($iRecipientId, $preferredMailType)
 * @since API 1.11.10
 */
interface Inx_Api_Rendering_Content
{

    /**
     * Returns the content type of the mailing.
     *
     * @return Inx_Api_Rendering_ContentType the content type of the mailing.
     */
    public function getContentType();

    /**
     * Returns the HTML text part of the mailing, or <i>null</i> if the <i>Inx_Api_Rendering_ContentType</i> is
     * Inx_Api_Rendering_ContentType::PLAIN_TEXT.
     *
     * @return string the HTML text part of the mailing, if any.
     */
    public function getHtmlText();

    /**
     * Returns the plain text part of the mailing, or <i>null</i> if the <i>Inx_Api_Rendering_ContentType</i> is
     * Inx_Api_Rendering_ContentType::HTML_TEXT.
     *
     * @return string the plain text part of the mailing, if any.
     */
    public function getPlainText();

    /**
     * Returns the subject of the mailing, if any.
     *
     * @return string the subject of the mailing, if any.
     */
    public function getSubject();

    /**
     * Returns the recipient address of the mailing.
     *
     * @return string the recipient address of the mailing.
     */
    public function getRecipientAddress();

    /**
     * Returns the sender address of the mailing.
     *
     * @return string the sender address of the mailing.
     */
    public function getSenderAddress();

    /**
     * Returns the reply address of the mailing. This address will be used for replies.
     *
     * @return string the reply address of the mailing.
     */
    public function getReplyToAddress();

    /**
     * Returns the bounce address of the mailing. This address will be used for bounce messages.
     *
     * @return string the bounce address of the mailing.
     */
    public function getBounceAddress();

    /**
     * Returns all regular attachments (files) of the mailing, or an empty array if there is no attachment.
     *
     * @return array() of Inx_Api_Rendering_Attachment all regular attachments of the mailing, or an empty array.
     */
    public function getAttachments();

    /**
     * Returns all embedded images of the mailing, or an empty array if there is no attachment.
     *
     * @return array() of Inx_Api_Rendering_Attachment all embedded images of the mailing, or an empty array.
     */
    public function getEmbeddedImages();

    /**
     * Returns the header informations of the mailing. The map contains the key/value-pair of the headers and does not
     * contain any <i>null</i> value, neither as key, nor as value. If there is no header, an empty map is returned.
     * <p>
     * Note: This method allows header fields only to be defined once. If a header field is defined multiple times, the
     * last value will be used. If you wish to define header fields multiple times, use the
     * <i>Inx_Api_Rendering_Content::getMultipleHeaders()</i> method instead. Nonetheless, you should be aware that
     * defining the same header field multiple times is discouraged by RFC 5322 as this is an obsolete behavior only
     * permitted by legacy implementations.
     *
     * @return array() of string => string the header information of the mailing.
     */
    public function getHeader();

    /**
     * Returns the header information of the mailing. The list contains <i>Inx_Api_Rendering_HeaderField</i> objects
     * encapsulating the key/value-pairs of the headers. This method allows multiple definitions of the same header
     * field. If there is no header, an empty list is returned.
     * <p>
     * Note: You should be aware that defining the same header field multiple times is discouraged by RFC 5322 as this
     * is an obsolete behavior only permitted by legacy implementations.
     *
     * @return array() of Inx_Api_Rendering_HeaderField the header information of the mailing.
     */
    public function getMultipleHeaders();
}
