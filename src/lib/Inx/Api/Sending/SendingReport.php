<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * The <i>Inx_Api_Sending_SendingReport</i> object provides accumulated report data for an
 * <i>Inx_Api_Sending_Sending</i>. It can be retrieved using the method
 * <i>Inx_Api_Sending_Sending::getReportData()</i>.
 * <p>
 * The following data can be accessed:
 * <ul>
 * <li>The number of mailings which have been opened</li>
 * <li>The number of recipients who clicked on any link of the mailing</li>
 * <li>The number of sent mails, including those which bounced</li>
 * <li>The number of sent mails, excluding those which bounced</li>
 * <li>The number of bounced mails</li>
 * <li>The number of mails which have not been sent</li>
 * <li>The average mail size</li>
 * </ul>
 *
 * @see Inx_Api_Sending_Sending
 * @since 1.11.5
 * @author chge, 10.07.2014
 */
interface Inx_Api_Sending_SendingReport
{

    /**
     * Returns the number of recipients who opened the mailing.
     *
     * @return int The number of recipients who opened the mailing.
     */
    public function getOpenedCount();

    /**
     * Returns the number of recipients who clicked a link of the mailing.
     *
     * @return int The number of recipients who clicked a link of the mailing.
     */
    public function getClickedCount();

    /**
     * Returns the number of sent mails, including those which bounced.
     *
     * @return int The number of sent mails, including those which bounced.
     */
    public function getSentCountIncludingBounces();

    /**
     * Returns the number of sent mails, excluding those which bounced.
     *
     * @return int The number of sent mails, excluding those which bounced.
     */
    public function getSentCountExcludingBounces();

    /**
     * Returns the number of recipients who caused a bounce.
     *
     * @return int The number of recipients who caused a bounce.
     */
    public function getBouncedCount();

    /**
     * Returns the number of mails which have not yet been sent.
     *
     * @return int The number of mails which have not yet been sent.
     */
    public function getNotSentCount();

    /**
     * Returns the average size of the sent mails in bytes.
     *
     * @return int The average size of the sent mails in bytes.
     */
    public function getAverageMailSize();
}
