<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * The <i>Inx_Api_Sending_SendingRecipientRowSet</i> gives information regarding the reaction of recipients to sendings.
 * Use this kind of row set to determine whether a recipient opened a mailing, clicked a link of that mailing or caused
 * a bounce. It is also possible to inspect the state of the sending and to access recipient meta data (i.e. recipient
 * column data and status). It is not possible though, to manipulate recipients.
 *
 * @see Inx_Api_Sending_Sending::findSendingRecipients($oRc, $aAttr)
 * @since API 1.11.1
 * @author chge, 29.04.2013
 */
interface Inx_Api_Sending_SendingRecipientRowSet extends Inx_Api_Sending_IndividualSendingRowSet,
 Inx_Api_Recipient_ReadOnlyRecipientRowSet
{

    /**
     * Returns the recipient state (i.e. existent, deleted or unknown).
     *
     * @return Inx_Api_Recipient_RecipientState The recipient state.
     * @throws Inx_Api_DataException if no row is selected (i.e. you forgot to call next()).
     */
    public function getRecipientState();
}
