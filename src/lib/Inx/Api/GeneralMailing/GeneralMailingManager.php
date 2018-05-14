<?php

/**
 * @package Inxmail
 * @subpackage GeneralMailing
 */

/**
 * The <i>Inx_Api_GeneralMailing_GeneralMailingManager</i> enables read-only access to mailings of various types.
 * These mailings can be accessed through the <i>Inx_Api_GeneralMailing_GeneralMailing</i> business object.
 * <p>
 * In order to create or edit a mailing, the corresponding specialized manager has to be used.
 * This may also be necessary for access to mailing type specific functionality.
 * The specialized managers are:
 * <ul>
 * <li><i>Inx_Api_Mailing_MailingManager</i> for normal mailings
 * <li><i>Inx_Api_TriggerMailing_TriggerMailingManager</i> for trigger mailings
 * </ul>
 * <b>Mailing retrieval</b>
 * Mailings can be retrieved via a <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>.
 * A query object can be created by calling the method <i>createQuery()</i>.
 * This will create a new query object without any preset filter.
 * In order to find specific mailings, the corresponding filters have to be added to the query before executing it.
 * For an example on how to do so, see the <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> documentation.
 * <p>
 * The following snippet shows how to create and execute a query that retrieves all accessible mailings in the system:
 *
 * <pre>
 * $oGeneralMailingManager = $oSession->getGeneralMailingManager();
 * $oGeneralMailingQuery = $oGeneralMailingManager->createQuery();
 *
 * $oROBOResultSet = $oGeneralMailingQuery->executeQuery();
 *
 * foreach( $oROBOResultSet as $oMailing )
 * {
 * 	echo $oMailing->getName()."&#60;br&#62;";
 * }
 *
 * $oROBOResultSet->close();
 * </pre>
 *
 * This provides the same result as a call to <i>selectAll()</i>.
 * <p>
 * <b>Preview generation</b>
 * <p>
 * To create a preview of a mailing, an <i>Inx_Api_Rendering_GeneralMailingRenderer</i> is needed. It can be obtained
 * using <i>createRenderer()</i> or <i>createRendererForTestRecipient()</i>.
 * <p>
 * The following snippet shows how to create an <i>Inx_Api_Rendering_GeneralMailingRenderer</i> and generate a preview
 * of the mailing:
 *
 * <pre>
 * $oManager = $oSession->getGeneralMailingManager();
 * $oRenderer = $oManager->createRenderer();
 * $oRenderer->parse( 1, Inx_Api_Rendering_BuildMode::PREVIEW() );
 * $oContent = $oRenderer->build( $iRecipientId );
 *
 * echo $oContent->getPlainText();
 * </pre>
 *
 * Note: To access mailings, the following api user right is required: <i>Inx_Api_UserRights::MAILING_FEATURE_USE</i>
 *
 * @see Inx_Api_GeneralMailing_GeneralMailing
 * @see Inx_Api_GeneralMailing_GeneralMailingQuery
 * @since API 1.11.10
 */
interface Inx_Api_GeneralMailing_GeneralMailingManager extends Inx_Api_ROBOManager
{

    /**
     * Creates and initializes a new <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> object without any query filter.
     *
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery a new initialized <i>GeneralMailingQuery</i>
     */
    public function createQuery();

    /**
     * Creates a new <i>Inx_Api_Rendering_GeneralMailingRenderer</i> which can be used to render an
     * <i>Inx_Api_GeneralMailing_GeneralMailing</i>.
     *
     * @return Inx_Api_Rendering_GeneralMailingRenderer a new <i>GeneralMailingRenderer</i>.
     */
    public function createRenderer();

    /**
     * Creates a new <i>Inx_Api_Rendering_GeneralMailingRenderer</i> which can be used to render a
     * <i>Inx_Api_GeneralMailing_GeneralMailing</i> personalized with a test recipient instead of an ordinary recipient.
     *
     * @return Inx_Api_Rendering_GeneralMailingRenderer a new <i>GeneralMailingRenderer</i> for test recipients.
     */
    public function createRendererForTestRecipient();
}
