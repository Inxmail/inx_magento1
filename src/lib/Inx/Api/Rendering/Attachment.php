<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * The <i>Inx_Api_Renderig_Attachment</i> object represents a regular attachment or an embedded image of a mailing and
 * is part of the <i>Inx_Api_Rendering_Content</i> object.
 *
 * @see Inx_Api_Rendering_Content::getAttachments()
 * @see Inx_Api_Rendering_Content::getEmbeddedImages()
 * @since API 1.11.10
 */
interface Inx_Api_Rendering_Attachment
{

    /**
     * Returns the file name of a regular attachment or the image identifier of an embedded image. An embedded image is
     * referenced in a message body using an <img> tag, as follows:
     *
     * <pre>
     * 	&lt;img src="cid:Image-Identifier"&gt;
     * </pre>
     *
     * @return string the file name of a regular attachment or the image identifier of an embedded image.
     */
    public function getName();

    /**
     * Returns the MIME type of this attachment, e.g. <i>application/pdf</i> or <i>image/gif</i>.
     *
     * @return string the MIME type of this attachment.
     */
    public function getContentType();

    /**
     * Returns the size of the content of this attachment in bytes.
     *
     * @return int the size of the content of this attachment in bytes.
     */
    public function getSize();

    /**
     * Returns an input stream of the content of this attachment. This method is used to download the content of this
     * attachment.
     *
     * @return Inx_Api_InputStream an input stream of the content of this attachment.
     */
    public function getContent();
}
