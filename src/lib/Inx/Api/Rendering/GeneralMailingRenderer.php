<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * The <i>Inx_Api_Rendering_GeneralMailingRenderer</i> is used to generate mail content of the following mailing types
 * using the API:
 * <ol>
 * <li>Regular mailing</li>
 * <li>Action mailing</li>
 * <li>Time trigger mailing</li>
 * <li>Subscription trigger mailing</li>
 * <li>Split test mailing</li>
 * <li>Sequence mailing</li>
 * </ol>
 * The main use of the class will be to generate personalized previews of mailings. The class can also be used to render
 * mailings that can be sent using a different mail sender. Be aware that in this case the mail sending rate would
 * decrease enormously.
 * <p>
 * To preview a mailing, acquire a <i>Inx_Api_Rendering_GeneralMailingRenderer</i> from the
 * <i>Inx_Api_Rendering_GeneralMailingRenderer</i>. Each mailing needs to be
 * parsed before building it. The following snippet shows how to build a mail for a given recipient:
 *
 * <pre>
 * $oRenderer = $oSession->getGeneralMailingManager()->createRenderer();
 * $oRenderer->parse( $oMailing->getId(), Inx_Api_Rendering_BuildMode::NORMAL() );
 * $oContent = $oRenderer->build( $iRecipientId );
 * </pre>
 * <p>
 * <i>Inx_Api_Rendering_GeneralMailingRenderer</i> can handle the following different build modes:
 * <ol>
 * <li><i>Inx_Api_Rendering_BuildMode::PREVIEW()</i></li>
 * <li><i>Inx_Api_Rendering_BuildMode::ALTERNATIVEVIEW_ACTIVE()</i></li>
 * <li><i>Inx_Api_Rendering_BuildMode::ALTERNATIVEVIEW_INACTIVE()</i></li>
 * <li><i>Inx_Api_Rendering_BuildMode::NORMAL()</i></li>
 * <li><i>Inx_Api_Rendering_BuildMode::ARCHIVE()</i></li>
 * <li><i>Inx_Api_Rendering_BuildMode::ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS()</i></li>
 * <li><i>Inx_Api_Rendering_BuildMode::NEWSLETTER_SIMPLE_LINKS()</i></li>
 * </ol>
 * <p>
 * <b>Note:</b> A <i>Inx_Api_Rendering_GeneralMailingRenderer</i> object <b>must</b> be closed once it is not needed
 * anymore to prevent memory leaks and other potentially harmful side effects.
 *
 * @see Inx_Api_Rendering_Content
 * @see Inx_Api_GeneralMailing_GeneralMailingManager::createRenderer()
 * @see Inx_Api_GeneralMailing_GeneralMailingManager::createRendererForTestRecipient()
 * @since API 1.11.10
 */
interface Inx_Api_Rendering_GeneralMailingRenderer
{

    /**
     * Prepares the mailing for a preview of a specific sending. It checks the mail integrity (syntax errors, references
     * to orphaned elements, ... ).<br/>
     * Errors will be listed in the <i>Inx_Api_Rendering_ParseException</i>
     * <p>
     * The mailing ID and sending ID are supposed to be valid (existing mailing and sending). The following rules apply
     * to the value of the sending ID parameter:
     * <ul>
     * <li>If the value is -1 or omitted, the mailing is parsed without sending specific information or content.</li>
     * <li>If the value refers to a non existing sending, an <i>Inx_Api_APIException</i> will be thrown.</li>
     * <li>If the value refers to a sending which is not applicable (e.g. a sending of a different mailing than the one
     * specified by the mailing ID parameter), an <i>Inx_Api_APIException</i> will be thrown.</li>
     * </ul>
     *
     * @param int $iMailingId the ID of the mailing to be parsed.
     * @param Inx_Api_Rendering_BuildMode $buildMode the mode of the build.
     * <i>Inx_Api_Rendering_BuildMode::UNKNOWN()</i> is not allowed.
     * @param int $iSendingId the ID of the sending, may be omitted.
     *
     * @throws Inx_Api_Rendering_ParseException if any syntax error is present in the mail.
     * @throws Inx_Api_APIException if the mailing ID or the sending ID are no longer valid, or the sending is not
     * applicable.
     * @throws Inx_Api_IllegalArgumentException if the build mode is not valid.
     */
    public function parse($iMailingId, Inx_Api_Rendering_BuildMode $buildMode, $iSendingId = null);

    /**
     * Generates the personalized mail content (recipient address, subject, HTML and/or plain text, ...) of the last
     * parsed mailing for the specified recipient and in the specified content type.<br/>
     * If the recipient ID <i>-2</i> is provided, a non existing recipient is used with the email address
     * <i>"unknown@unknown.invalid"</i>, the ID <i>0</i> and no other attribute set.
     *
     * @param int $iRecipientId the ID of the recipient for which the mail shall be personalized.
     * @param Inx_Api_Rendering_ContentType $preferredContentType the content type that should be used for building the
     *  mailing. If it is not supported by the mailing, the default content type of the mailing will be used i.e. the
     *  format of the mailing. May be omitted in which case the system default - which is equivalent to the mailing
     *  format - will be used.
     * @return Inx_Api_Rendering_Content the personalized content of the mail.
     *
     * @throws Inx_Api_Rendering_BuildException if the recipient could not be found, or the building failed.
     * @throws Inx_Api_IllegalStateException if no mailing has been parsed yet or if the last parsing was unsuccessful.
     * @throws Inx_Api_IllegalArgumentException if $preferredContentType is invalid.
     */
    public function build($iRecipientId, Inx_Api_Rendering_ContentType $preferredContentType = null);

    /**
     * Closes this <i>Inx_Api_Rendering_GeneralMailingRenderer</i> and releases any server resources associated with
     * this object. An <i>Inx_Api_Rendering_GeneralMailingRenderer</i> object <b>must</b> be closed once it is not
     * needed anymore to prevent memory leaks and other potentially harmful side effects.
     */
    public function close();
}
