<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * The <i>Inx_Api_Sending_SendingHistoryManager</i> enables read-only access to data regarding the sendings of mailings.
 * This data can be accessed through the <i>Inx_Api_Sending_Sending</i> business object, which represents a sending of a
 * mailing to a set  of recipients. Each sending may contain many individual sendings, corresponding to the sending of
 * the mailing to one specific recipient. This individual sending data can be accessed through a
 * <i>Inx_Api_Sending_IndividualSendingRowSet</i>. A regular mailing is usually only sent once. A trigger mailing on the
 * other hand, may be sent many times.
 * <p/>
 * <b>Query criteria</b>
 * <p/>
 * The following criteria can be used to retrieve sendings:
 * <ul>
 * <li>The ID of the sending:
 * <ul>
 * <li><i>get($iSendingId)</i></li>
 * </ul>
 * </li>
 * <li>The ID of the sent mailing:
 * <ul>
 * <li><i>findSendingsByMailing($iMailingId)</i></li>
 * <li><i>findPastSendingsByMailing($iMailingId, $sStart, $sEnd)</i></li>
 * <li><i>findLastSendingForMailing($iMailingId)</i></li>
 * </ul>
 * </li>
 * <li>The ID of the recipient being mailed:
 * <ul>
 * <li><i>findSendingsByRecipient($iRecipientId)</i></li>
 * <li><i>findPastSendingsByRecipient($iRecipientId, $sStart, $sEnd)</i></li>
 * <li><i>findLastSendingForRecipient($iRecipientId)</i></li>
 * </ul>
 * </li>
 * <li>The date of the sending:
 * <ul>
 * <li><i>findSendingsByDate($sStart, $sEnd)</i></li>
 * </ul>
 * </li>
 * <li>The date of the last modification of the sending:
 * <ul>
 * <li><i>findModifiedSendings($sSince)</i></li>
 * <li><i>findLastSending()</i></li>
 * </ul>
 * </li>
 * </ul>
 * The following snippet demonstrates how to retrieve all <i>Sending</i>s for a mailing which were processed
 * during the last 30 days:
 *
 * <pre>
 * $sStart = date('c', strtotime('-30 days'));
 * $oSendingHistoryManager = $oSession->getSendingHistoryManager();
 * $oSendings = $oSendingHistoryManager->findPastSendingsByMailing( $iMailingId, $sStart, null );
 * </pre>
 * <p/>
 * <b>Determining future sending dates</b>
 * <p/>
 * It is not possible to retrieve sendings which will be triggered in the future. It is possible though, to retrieve the
 * expected sending dates. Be aware that it is not guaranteed that a sending will be performed at these dates. If at the
 * time at which the sending process is triggered no recipients match the criteria or there are no recipients at all,
 * there will be no actual sending. Also note, that theses dates do not specify the actual point in time at which the
 * first mail is being sent. The mailing has to be prepared for each recipient before the first mail is sent. <br>
 * The following methods return the expected future sending dates:
 * <ul>
 * <li><i>findNextSending($iMailingId)</i></li>
 * <li><i>findFutureSendingsByMailing($iMailingId, $sStart, $sEnd)</i></li>
 * <li><i>findFutureSendingsByDate($sStart, $sEnd)</i></li>
 * </ul>
 * The following snippet show how to find the expected sendings of a mailing for the next 30 days:
 *
 * <pre>
 * $sEnd = date('c', strtotime('+30 days'));
 * $oSendingHistoryManager = $oSession->getSendingHistoryManager();
 * $aDates = $oSendingHistoryManager->findFutureSendingsByMailing( $iMailingId, null, $sEnd );
 * </pre>
 * <p/>
 * <b>Accessing recipient reactions</b>
 * <p/>
 * In addition, there is a shortcut for determining whether a recipient opened or clicked a link in the mailing and
 * whether the sending bounced. This is the equivalent to recipient reactions in the Inxmail Professional client. The
 * following methods can be used to retrieve this information:
 * <ul>
 * <li><i>hasOpened($iRecipientId, $iMailingId)</i></li>
 * <li><i>hasClicked($iRecipientId, $iMailingId)</i></li>
 * <li><i>hasBounced($iRecipientId, $iMailingId)</i></li>
 * <li><i>hasOpenedBetween($iRecipientId, $iMailingId, $sStart, $sEnd)</i></li>
 * <li><i>hasClickedBetween($iRecipientId, $iMailingId, $sStart, $sEnd)</i></li>
 * <li><i>hasBouncedBetween($iRecipientId, $iMailingId, $sStart, $sEnd)</i></li>
 * </ul>
 * The methods without date parameters only consider the last sending of the specified mailing, whereas the methods with
 * date parameters consider all sendings of the specified mailing which were processed during the given time period.
 * Both date parameters are optional. Omitting both parameters will take every sending of the mailing into
 * consideration.
 * <p/>
 * The following example demonstrates how to determine whether a recipient has opened a mail of the last sending and any
 * sending of a given mailing:
 *
 * <pre>
 * $oSendingHistoryManager = $oSession->getSendingHistoryManager();
 * $blOpenedLastSending = $oSendingHistoryManager->hasOpened( $iRecipientId, $iMailingId );
 * $blOpenedAnySending = $oSendingHistoryManager->hasOpenedBetween( $iRecipientId, $iMailingId, null, null );
 * </pre>
 * <p/>
 * <b>Note:</b> All of the methods of this manager require the user right <i>Inx_Api_UserRights::MAILING_FEATURE_USE</i>.
 * All methods except for those which return date values require the user rights <i>Inx_Api_UserRights::RECIPIENT_VIEW</i>
 * and <i>Inx_Api_UserRights::RECIPIENT_USE_SYSTEM</i>. In addition, the methods which return recipient reactions (i.e.
 * <i>hasOpened($iRecipientId, $iMailingId)</i>) require the activation of the 'Condition on recipient reaction'
 * administration list property.
 * <p/>
 * For more information on <i>Sending</i>s, see the <i>Inx_Api_Sending_Sending</i> documentation.
 *
 * @see Inx_Api_Sending_Sending
 * @since API 1.11.1
 * @author chge, 25.04.2013
 */
interface Inx_Api_Sending_SendingHistoryManager extends Inx_Api_ROBOManager
{

    /**
     * Returns an <i>Inx_Api_ROBOResultSet</i> containing all sendings of the specified mailing.
     *
     * @param int $iMailingId the ID of the mailing whose sendings shall be retrieved.
     * @return Inx_Api_ROBOResultSet A <i>ROBOResultSet</i> containing all sendings of the specified mailing.
     */
    public function findSendingsByMailing($iMailingId);

    /**
     * Returns an <i>Inx_Api_ROBOResultSet</i> containing all sendings to the specified recipient.
     *
     * @param int $iRecipientId the ID of the recipient whose sendings shall be retrieved.
     * @return Inx_Api_ROBOResultSet A <i>ROBOResultSet</i> containing all sendings to the specified recipient.
     */
    public function findSendingsByRecipient($iRecipientId);

    /**
     * Returns an <i>Inx_Api_ROBOResultSet</i> containing all sendings which were performed during the specified
     * time span.
     *
     * @param string $sStart the start date of the sending must be greater or equal to this date to be included in the
     *      result set. The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @param string $sEnd the end date of the sending must be less or equal to this date to be included in the result
     *      set. The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @return Inx_Api_ROBOResultSet A <i>ROBOResultSet</i> containing all sendings which were performed during the
     *      specified time span.
     */
    public function findSendingsByDate($sStart = null, $sEnd = null);

    /**
     * Returns an <i>Inx_Api_ROBOResultSet</i> containing all sendings of the specified mailing which were performed
     * during the specified time span.
     *
     * @param int $iMailingId the ID of the mailing whose sendings shall be retrieved.
     * @param string $sStart the start date of the sending must be greater or equal to this date to be included in the
     *      result set. The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @param string $sEnd the end date of the sending must be less or equal to this date to be included in the result
     *      set. The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @return Inx_Api_ROBOResultSet A <i>ROBOResultSet</i> containing all sendings of the specified mailing which were
     *      performed during the specified time span.
     */
    public function findPastSendingsByMailing($iMailingId, $sStart = null, $sEnd = null);

    /**
     * Returns an <i>Inx_Api_ROBOResultSet</i> containing all sendings to the specified recipient which were performed
     * during the specified time span.
     *
     * @param int $iRecipientId the ID of the recipient whose sendings shall be retrieved.
     * @param string $sStart the start date of the sending must be greater or equal to this date to be included in the
     *      result set. The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @param string $sEnd the end date of the sending must be less or equal to this date to be included in the result
     *      set. The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @return Inx_Api_ROBOResultSet A <i>ROBOResultSet</i> containing all sendings to the specified recipient which
     *      were performed during the specified time span.
     */
    public function findPastSendingsByRecipient($iRecipientId, $sStart = null, $sEnd = null);

    /**
     * Returns a list of the next expected sendings performed by the Inxmail Professional server. The end date
     * <b>must</b> be specified because otherwise there might be an infinite amount of sending dates. Therefore,
     * omitting the end date will trigger an <i>Inx_Api_NullPointerException</i>. The start date may be omitted,
     * in which case it will be set to the current date.
     * <p/>
     * Be aware that it is not guaranteed that a sending will be performed at these dates. If at the time at which the
     * sending process is triggered no recipients match the criteria or there are no recipients at all, there will be no
     * actual sending. Also note, that theses dates do not specify the actual point in time at which the first mail is
     * being sent. The mailing has to be prepared for each recipient before the first mail is sent.
     *
     * @param string $sStart the start date, inclusively. The date has to be specified as ISO-8601 formatted datetime
     *      string. May be <i>null</i>, in which case it will be set to the current date.
     * @param string $sEnd the end date, inclusively. The date has to be specified as ISO-8601 formatted datetime string.
     *      May not be <i>null</i>.
     * @return array A list of the next expected sendings performed by the Inxmail Professional server.
     * @throws Inx_Api_NullPointerException if the end date is not specified.
     */
    public function findFutureSendingsByDate($sStart, $sEnd);

    /**
     * Returns a list of the next expected sendings of the given mailing. The end date <b>must</b> be specified because
     * otherwise there might be an infinite amount of sending dates. Therefore, omitting the end date will trigger an
     * <i>Inx_Api_NullPointerException</i>. The start date may be omitted, in which case it will be set to the current date.
     * <p/>
     * Be aware that it is not guaranteed that a sending will be performed at these dates. If at the time at which the
     * sending process is triggered no recipients match the criteria or there are no recipients at all, there will be no
     * actual sending. Also note, that theses dates do not specify the actual point in time at which the first mail is
     * being sent. The mailing has to be prepared for each recipient before the first mail is sent.
     *
     * @param int $iMailingId the ID of the mailing whose expected sending dates shall be retrieved.
     * @param string $sStart the start date, inclusively. The date has to be specified as ISO-8601 formatted datetime
     *      string. May be <i>null</i>, in which case it will be set to the current date.
     * @param string $sEnd the end date, inclusively. The date has to be specified as ISO-8601 formatted datetime string.
     *      May not be <i>null</i>.
     * @return array A list of the next expected sendings performed by the Inxmail Professional server.
     * @throws Inx_Api_NullPointerException if the end date is not specified.
     */
    public function findFutureSendingsByMailing($iMailingId, $sStart, $sEnd);

    /**
     * Returns an <i>Inx_Api_ROBOResultSet</i> containing all sendings which have been modified since the specified date.
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
     * This list is not concluding. The reference date must be specified. Omitting the reference date will trigger an
     * <i>Inx_Api_NullPointerException</i>.
     *
     * @param string $sSince the reference date, inclusively. The date has to be specified as ISO-8601 formatted datetime
     *      string. May not be <i>null</i>
     * @return Inx_Api_ROBOResultSet A <i>ROBOResultSet</i> containing all sendings which have been modified since the
     *      specified date.
     * @throws Inx_Api_NullPointerException if the reference date is not specified.
     */
    public function findModifiedSendings($sSince);

    /**
     * Returns the next expected send date of the specified mailing.
     * <p/>
     * Be aware that it is not guaranteed that a sending will be performed at these dates. If at the time at which the
     * sending process is triggered no recipients match the criteria or there are no recipients at all, there will be no
     * actual sending. Also note, that theses dates do not specify the actual point in time at which the first mail is
     * being sent. The mailing has to be prepared for each recipient before the first mail is sent.
     *
     * @param int $iMailingId the ID of the mailing for which the next send date shall be retrieved.
     * @return string The next expected send Date of the specified mailing as ISO-8601 formatted datetime string.
     */
    public function findNextSending($iMailingId);

    /**
     * Returns the <i>Inx_Api_Sending_Sending</i> object for the last sending of the specified mailing, if any.
     *
     * @param int $iMailingId the ID of the mailing whose last sending shall be retrieved.
     * @return Inx_Api_Sending_Sending The <i>Sending</i> object for the last sending of the specified mailing, if any,
     *      <i>null</i> otherwise.
     */
    public function findLastSendingForMailing($iMailingId);

    /**
     * Returns the <i>Inx_Api_Sending_Sending</i> object for the last sending to the specified recipient, if any.
     *
     * @param int $iRecipientId the ID of the recipient whose last sending shall be retrieved.
     * @return Inx_Api_Sending_Sending The <i>Sending</i> object for the last sending to the specified recipient, if any,
     *         <i>null</i> otherwise.
     */
    public function findLastSendingForRecipient($iRecipientId);

    /**
     * Returns the <i>Inx_Api_Sending_Sending</i> object for the last sending, if any.
     *
     * @return Inx_Api_Sending_Sending The <i>Sending</i> object for the last sending, if any, <i>null</i> otherwise.
     */
    public function findLastSending();

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient has opened a mail of the last sending
     * of the specified mailing.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @param int $iMailingId the ID of the mailing.
     * @return bool <i>true</i> if the specified recipient has opened a mail of the last sending of the specified
     *         mailing, <i>false</i> otherwise.
     */
    public function hasOpened($iRecipientId, $iMailingId);

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient has clicked a link of a mail of the
     * last sending of the specified mailing.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @param int $iMailingId the ID of the mailing.
     * @return bool <i>true</i> if the specified recipient has clicked a link of a mail of the last sending of the
     *         specified mailing, <i>false</i> otherwise.
     */
    public function hasClicked($iRecipientId, $iMailingId);

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient caused a bounce during the last sending
     * of the specified mailing.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @param int $iMailingId the ID of the mailing.
     * @return bool <i>true</i> if the specified recipient caused a bounce during the last sending of the specified
     *         mailing, <i>false</i> otherwise.
     */
    public function hasBounced($iRecipientId, $iMailingId);

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient has opened a mail of any sending of the
     * specified mailing which were performed during the given time span. If both date parameters are omitted, each
     * sending of the specified mailing will be taken into consideration.
     * <p/>
     * <b>Important note:</b> The date parameters do not refer to the date of the opening of the mail. They
     * refer to the sending of the mailing.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @param int $iMailingId the ID of the mailing.
     * @param string $sStart the start date of the sending must be greater or equal to this date to be considered.
     *      The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @param string $sEnd the start date of the sending must be less than this date to be considered. The date has
     *      to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @return bool <i>true</i> if the specified recipient has opened a mail of any sending of the specified mailing
     *         which were performed during the given time span, <i>false</i> otherwise.
     */
    public function hasOpenedBetween($iRecipientId, $iMailingId, $sStart, $sEnd);

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient has clicked a link of a mail of any
     * sending of the specified mailing which were performed during the given time span. If both date parameters are
     * omitted, each sending of the specified mailing will be taken into consideration.
     * <p/>
     * <b>Important note:</b> The date parameters do not refer to the date of the click. They refer to the
     * sending of the mailing.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @param int $iMailingId the ID of the mailing.
     * @param string $sStart the start date of the sending must be greater or equal to this date to be considered.
     *      The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @param string $sEnd the start date of the sending must be less than this date to be considered. The date has
     *      to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @return bool <i>true</i> if the specified recipient has clicked a link of a mail of any sending of the specified
     *         mailing which were performed during the given time span, <i>false</i> otherwise.
     */
    public function hasClickedBetween($iRecipientId, $iMailingId, $sStart, $sEnd);

    /**
     * Returns a <i>bool</i> indicating whether the specified recipient caused a bounce during any sending of
     * the specified mailing which were performed during the given time span. If both date parameters are omitted, each
     * sending of the specified mailing will be taken into consideration.
     * <p/>
     * <b>Important note:</b> The date parameters do not refer to the date of the bounce. They refer to the
     * sending of the mailing.
     *
     * @param int $iRecipientId the ID of the recipient.
     * @param int $iMailingId the ID of the mailing.
     * @param string $sStart the start date of the sending must be greater or equal to this date to be considered.
     *      The date has to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @param string $sEnd the start date of the sending must be less than this date to be considered. The date has
     *      to be specified as ISO-8601 formatted datetime string. May be <i>null</i>.
     * @return bool <i>true</i> if the specified recipient caused a bounce during any sending of the specified mailing
     *         which were performed during the given time span, <i>false</i> otherwise.
     */
    public function hasBouncedBetween($iRecipientId, $iMailingId, $sStart, $sEnd);
}
