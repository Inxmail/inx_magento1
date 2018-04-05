<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * The <i>Inx_Api_Sending_IndividualSendingRowSet</i> gives information regarding the reaction of recipients to sendings.
 * Use this kind of row set to determine whether a recipient opened a mailing, clicked a link of that mailing or caused a
 * bounce. It is also possible to inspect the state of the sending. It is not possible though, to access recipient meta data
 * (i.e. recipient column data and status) or to manipulate recipients.
 *
 * @see Inx_Api_Sending_Sending::findIndividualSendings()
 * @since API 1.11.1
 * @author chge, 29.04.2013
 */
interface Inx_Api_Sending_IndividualSendingRowSet extends Inx_Api_InxRowSet
{

    /**
     * Returns the ID of the recipient.
     *
     * @return int The ID of the recipient.
     * @throws Inx_Api_DataException if no row is selected (i.e. you forgot to call next()).
     */
    public function getRecipientId();

    /**
     * Returns a <i>bool</i> indicating whether the currently selected recipient caused a bounce.
     *
     * @return bool <i>true</i> if the currently selected recipient caused a bounce, <i>false</i> otherwise.
     * @throws Inx_Api_DataException if no row is selected (i.e. you forgot to call next()).
     */
    public function hasBounced();

    /**
     * Returns a <i>bool</i> indicating whether the currently selected recipient opened the mail.
     *
     * @return bool <i>true</i> if the currently selected recipient opened the mail, <i>false</i> otherwise.
     * @throws Inx_Api_DataException if no row is selected (i.e. you forgot to call next()).
     */
    public function hasOpened();

    /**
     * Returns a <i>bool</i> indicating whether the currently selected recipient clicked any link of the mail.
     *
     * @return bool <i>true</i> if the currently selected recipient clicked any link of the mail, <i>false</i>
     *         otherwise.
     * @throws Inx_Api_DataException if no row is selected (i.e. you forgot to call next()).
     */
    public function hasClicked();

    /**
     * Returns the state of the sending to the currently selected recipient.
     *
     * @return Inx_Api_Sending_IndividualSendingState The state of the sending to the currently selected recipient.
     * @throws Inx_Api_DataException if no row is selected (i.e. you forgot to call next()).
     */
    public function getState();
}
