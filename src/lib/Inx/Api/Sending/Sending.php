<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * An <i>Inx_Api_Sending_Sending</i> represents a sending of a mailing to a set of recipients. Each sending may contain many
 * individual sendings, corresponding to the sending of the mailing to one specific recipient. A regular mailing is
 * usually only sent once. A trigger mailing on the other hand, may be sent many times. To retrieve <i>Sending</i>
 * objects, use the <i>Inx_Api_Sending_SendingHistoryManager</i>.
 * <p>
 * <b>Accessible sending data</b>
 * <p>
 * The following data regarding sendings can be accessed:
 * <ul>
 * <li>The ID of the mailing being sent</li>
 * <li>The ID of the list containing the mailing</li>
 * <li>The IDs of the recipients who have been mailed</li>
 * <li>The start date of the sending</li>
 * <li>The end date of the sending</li>
 * <li>The date of the last modification to the sending</li>
 * <li>The state of the sending</li>
 * <li>The type of the mailing being sent</li>
 * <li>The total size of the sending in bytes</li>
 * <li>The mailing and protocol state</li>
 * </ul>
 * <p>
 * You can fetch accumulated report data of a sending using the <i>getReportData()</i> method. Be aware that
 * this method performs a separate server call. The <i>Inx_Api_Sending_SendingReport</i> object contains the following data:
 * <ul>
 * <li>The number of mailings which have been opened</li>
 * <li>The number of recipients who clicked on any link of the mailing</li>
 * <li>The number of sent mails, including those which bounced</li>
 * <li>The number of sent mails, excluding those which bounced</li>
 * <li>The number of bounced mails</li>
 * <li>The number of mails which have not been sent</li>
 * <li>The average mail size</li>
 * <li>The <i>Inx_Api_GeneralMailing_GeneralMailing</i> corresponding to this sending</li>
 * </ul>
 * <p>
 * <b>Alternatives for accessing sending recipients</b>
 * <p>
 * If you need to know, for example, which recipients opened the mailing, you should retrieve an
 * <i>Inx_Api_Sending_IndividualSendingRowSet</i> or an <i>Inx_Api_Sending_SendingRecipientRowSet</i>:
 * <ul>
 * <li>The <i>Inx_Api_Sending_IndividualSendingRowSet</i> allows to determine whether a recipient opened a mail, clicked
 * on a link or caused a bounce and gives detailed information regarding the state of this individual sending.</li>
 * <li>In addition, the <i>Inx_Api_Sending_SendingRecipientRowSet</i> gives access to recipient meta data, mainly recipient
 * attributes (columns in Inxmail Professional). The access is read-only though.</li>
 * <li>To manipulate the recipients, use the <i>findRecipients($oRecipientContext)</i> method to get a fully featured
 * <i>Inx_Api_Recipient_RecipientRowSet</i>. This row set will contain no reaction data though.</li>
 * </ul>
 * If you need to consider the reaction of the recipients <i>and</i> need to manipulate them, you have to do this in two
 * stages:
 * <ol>
 * <li>Collect the relevant recipient IDs using <i>findIndividualSendings()</i></li>
 * <li>Call <i>Inx_Api_Recipient_RecipientContext::findByIds($aRecipientIds)</i> to manipulate these recipients</li>
 * </ol>
 * The following example demonstrates how to determine all recipients who opened the sent mail and set a date flag for
 * these recipients:
 *
 * <pre>
 * $oSendingHistoryManager = $oSession->getSendingHistoryManager();
 * $oLastSending = $oSendingHistoryManager->findLastSendingForMailing( $iMailingId );
 * $oIndividualSendings = $oLastSending->findIndividualSendings();
 *
 * $aRecipientIds = array();
 *
 * while( $oIndividualSendings->next() )
 * {
 *   if( $oIndividualSendings->hasOpened() )
 *   {
 *     $aRecipientIds[] = $oIndividualSendings->getRecipientId();
 *   }
 * }
 *
 * $oIndividualSendings->close();
 *
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oLastOpening = $oRecipientContext->getMetaData()->getUserAttribute( 'LastOpening' );
 * $oRecipients = $oRecipientContext->findByIds( $aRecipientIds );
 *
 * $oNow = strtotime('now');
 *
 * while( $oRecipients->next() )
 * {
 *   $oRecipients->updateDatetime( $oLastOpening, $oNow );
 *   $oRecipients->commitRowUpdate();
 * }
 *
 * $oRecipients->close();
 * </pre>
 *
 * For more information on how to retrieve <i>Sending</i>s, see the {@link SendingHistoryManager} documentation.
 *
 * @see Inx_Api_Sending_SendingReport
 * @see Inx_Api_Sending_SendingHistoryManager
 * @since API 1.11.1
 * @author chge, 29.04.2013
 */
interface Inx_Api_Sending_Sending extends Inx_Api_ReadOnlyBusinessObject
{
    /**
     * Returns the ID of the mailing being sent.
     *
     * @return int The ID of the mailing being sent.
     */
    public function getMailingId();

    /**
     * Returns the ID of the list containing the mailing being sent.
     *
     * @return int The ID of the list containing the mailing being sent.
     */
    public function getListId();

    /**
     * Returns the start date of this sending. Please note, that this date does not specify the actual point in time at
     * which the first mail is being sent. The mailing has to be prepared for each recipient before the first mail is
     * sent.
     * <br>
     * The start date is returned as ISO-8601 formatted datetime string.
     *
     * @return string The start date of the sending.
     */
    public function getStartDate();

    /**
     * Returns the end date of this sending. This date corresponds to the end of the sending of the last mail.
     * <br>
     * The end date is returned as ISO-8601 formatted datetime string.
     *
     * @return string The end date of the sending.
     */
    public function getEndDate();

    /**
     * Returns the date when this sending has been modified last.
     * <br>
     * The modification date is returned as ISO-8601 formatted datetime string.
     * <p>
     * The following events are considered as modifications:
     * <ul>
     * <li>The sending has been triggered (created)</li>
     * <li>The sending has been started</li>
     * <li>The sending has been ended</li>
     * <li>A mail of the sending has been sent to a recipient</li>
     * <li>A recipient of the sending opened the mail</li>
     * <li>A recipient of the sending clicked a link of the mail</li>
     * <li>A recipient of the sending caused a bounce</li>
     * <li>The mailing has been deleted</li>
     * <li>The sending protocol (individual sendings) has been deleted</li>
     * </ul>
     * This list is not concluding.
     *
     * @return string The date when this sending has been modified last.
     */
    public function getModificationDate();

    /**
     * Returns the state of this sending.
     *
     * @return Inx_Api_Sending_SendingState The state of this sending.
     */
    public function getState();

    /**
     * Returns the type of the mailing being sent.
     *
     * @return Inx_Api_Sending_SendingMailingType The type of the mailing being sent.
     */
    public function getType();

    /**
     * Returns the total size of the sending in bytes. This is the accumulation of the size of all sent mails.
     *
     * @return int The total size of the sending in bytes.
     */
    public function getTotalSize();

    /**
     * Returns an <i>Inx_Api_Sending_SendingReport</i> object containing accumulated report data regarding this
     * sending. Be aware that this method performs a separate server call.
     *
     * @return Inx_Api_Sending_SendingReport a <i>SendingReport</i> object containing accumulated report data
     *         regarding this sending.
     * @since API 1.11.5
     */
    public function getReportData();

    /**
     * Returns a <i>bool</i> indicating whether the protocol for this sending has been deleted. After the
     * protocol has been deleted it is not possible to determine how a specific recipient reacted on the mail.
     *
     * @return bool <i>true</i> if the protocol has been deleted, <i>false</i> otherwise.
     */
    public function isProtocolDeleted();

    /**
     * Returns a <i>bool</i> indicating whether the mailing sent by this sending has been deleted.
     *
     * @return bool <i>true</i> if the mailing sent by this sending has been deleted, <i>false</i> otherwise.
     */
    public function isMailingDeleted();

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient opened the mail sent by this sending.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @return bool <i>true</i> if the recipient opened the mail, <i>false</i> otherwise.
     */
    public function hasOpened($iRecipientId);

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient clicked a link of the mail sent by this
     * sending.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @return bool <i>true</i> if the recipient clicked any link of the mail, <i>false</i> otherwise.
     */
    public function hasClicked($iRecipientId);

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient caused a bounce during the sending of
     * the mail.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @return bool <i>true</i> if the recipient caused a bounce during the sending of the mail, <i>false</i>
     *         otherwise.
     */
    public function hasBounced($iRecipientId);

    /**
     * Returns the <i>Inx_Api_GeneralMailing_GeneralMailing</i> corresponding to this sending. A <i>null</i> value is
     * returned if the mailing type of the sending is not compatible with
     * <i>Inx_Api_GeneralMailing_GeneralMailingManager</i> or if the corresponding
     * <i>Inx_Api_GeneralMailing_GeneralMailing</i> could not be found (e.g. the object was deleted). Be aware that this
     * method performs a separate server call.
     *
     * @return Inx_Api_GeneralMailing_GeneralMailing the <i>GeneralMailing</i> of the sending, or null.
     */
    public function findGeneralMailing();

    /**
     * Returns an <i>Inx_Api_Sending_IndividualSendingRowSet</i> containing data related to the sending of mails to individual
     * recipients. The <i>Inx_Api_Sending_IndividualSendingRowSet</i> can be used to determine whether a recipient opened the
     * mail, clicked a link of the mail or caused a bounce and what the sending state is.
     * <p>
     * Use this method if you are interested in the reaction of a couple of recipients and don't need to access their
     * meta data. If you are only interested in the reaction of one or a few recipients use <i>hasOpened($iRecipientId)</i>,
     * <i>hasClicked($iRecipientId)</i> and <i>hasBounced($iRecipientId)</i>. If you need to access recipient meta data
     * (i.e. recipient column data and status), use <i>findSendingRecipients($oRc, $aAttrs)</i> instead.
     *
     * @return Inx_Api_Sending_IndividualSendingRowSet An <i>IndividualSendingRowSet</i> containing data related to the sending
     * of mails to individual recipients.
     */
    public function findIndividualSendings();

    /**
     * Returns an <i>Inx_Api_Sending_SendingRecipientRowSet</i> containing data related to the sending of mails to individual
     * recipients, including meta date of these recipients. The <i>Inx_Api_Sending_SendingRecipientRowSet</i> can be used to
     * determine whether a recipient opened the mail, clicked a link of the mail or caused a bounce and what the sending
     * state is. It may also be used to access meta data (i.e. recipient column data and status) of the recipient. The
     * access is read-only.
     * <p>
     * Use this method if you are interested in the reaction of a couple of recipients and need access to their meta
     * data. If you are only interested in the reaction of one or a few recipients use <i>hasOpened($iRecipientId)</i>,
     * <i>hasClicked($iRecipientId)</i> and <i>hasBounced($iRecipientId)</i>. If you do not need to access recipient meta data
     * (i.e. recipient column data and status), use <i>findIndividualSendings()</i> instead.<br>
     * If you need to manipulate recipients use <i>findRecipients($oRc)</i> to get a fully featured
     * <i>Inx_Api_Recipient_RecipientRowSet</i>. This row set contains no information on the sending though.
     *
     * @param Inx_Api_Recipient_RecipientContext $oRc the <i>RecipientContext</o> used to fetch the recipient meta data.
     * @param array $aAttrs the <i>Inx_Api_Recipient_Attribute</i>s which shall be fetched for later retrieval.
     * @return Inx_Api_Sending_SendingRecipientRowSet A <i>SendingRecipientRowSet</i> containing data related to the sending
     *      of mails to individual recipients, including meta date of these recipients.
     * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext<i> is provided.
     */
    public function findSendingRecipients(Inx_Api_Recipient_RecipientContext $oRc, $aAttrs);

    /**
     * Returns an <i>Inx_Api_Recipient_RecipientRowSet</i> containing recipient meta data (i.e. recipient column data and
     * status). This row set allows the manipulation of recipients but contains no information on the sending.  Be aware 
     * that any recipients which are not existing anymore (with respect to their ID) are not included in the result.
     * <p>
     * Use this method if you are not interested in the reaction of the recipients or need to manipulate them. If you
     * need to consider the reaction of the recipients, use <i>findIndividualSendings()<i> or
     * <i>findSendingRecipients($oRc, $aAttrs)</i>, depending on whether you need to access recipient meta data.<br>
     * If you need to consider the reaction of the recipients <i>and</i> need to manipulate them, you have to do this in
     * two stages:
     * <ol>
     * <li>Collect the relevant recipient IDs using {@link #findIndividualSendings()}</li>
     * <li>Call {@link RecipientContext#findByIds(int[])} to manipulate these recipients</li>
     * </ol>
     *
     * @param rc the <i>RecipientContext</i> used to fetch the recipients.
     * @return A <i>RecipientRowSet</i> containing recipient meta data (i.e. recipient column data and status).
     * @throws NullPointerException if no <i>RecipientContext</i> is provided.
     */
    public function findRecipients(Inx_Api_Recipient_RecipientContext $oRc);
    
    /**
     * Returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing all clicks on links in the mailing of this sending. 
     * The returned row set contains data about the related clicks and is read only. The returned data can also
     * contain attribute information about the recipients that performed these clicks.
     *
     * @param Inx_Api_Recipient_RecipientContext $oRc the <i>RecipientContext</o> used to fetch the recipient meta data.
     * @param array $aAttrs the <i>Inx_Api_Recipient_Attribute</i>s which shall be fetched for later retrieval.
     *      Parameter may be null. Also see <i>Inx_Api_Recipient_RecipientMetaData</i>.
     * @return Inx_Api_DataAccess_ClickDataRowSet A <i>ClickDataRowSet</i> containing clicks related to the sending
     *      of mails to individual recipients, including meta data of these recipients.
     * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext<i> is provided.
     */
    public function findClicks(Inx_Api_Recipient_RecipientContext $oRc, $aAttrs);
}
