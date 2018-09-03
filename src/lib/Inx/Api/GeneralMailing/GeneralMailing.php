<?php

/**
 * @package Inxmail
 * @subpackage GeneralMailing
 */

/**
 * A <i>Inx_Api_GeneralMailing_GeneralMailing</i> object represents a mailing of any type in Inxmail. It provides common mailing attributes.
 * <p>
 * For an example on how to retrieve mailings, see the <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> documentation.
 *
 * @since API 1.11.10
 */
interface Inx_Api_GeneralMailing_GeneralMailing extends Inx_Api_ReadOnlyBusinessObject
{

    /**
     * Returns the name of this mailing.
     *
     * @return string the name of this mailing.
     */
    public function getName();

    /**
     * Returns the subject of this mailing.
     *
     * @return string the subject of this mailing.
     */
    public function getSubject();

    /**
     * Returns the ID of the list context this mailing belongs to.
     *
     * @return int the ID of the list context this mailing belongs to.
     */
    public function getListContextId();

    /**
     * Returns the <i>Inx_Api_GeneralMailing_MailingType</i> of this mailing.
     *
     * @return Inx_Api_GeneralMailing_MailingType the <i>Inx_Api_GeneralMailing_MailingType</i> of this mailing.
     */
    public function getMailingType();

    /**
     * Returns the creation date of this mailing.
     *
     * @return string the creation date of this mailing. The date will be returned as an ISO 8601 formatted date string.
     */
    public function getCreationDatetime();

    /**
     * Returns the modification date of this mailing.
     *
     * @return string the modification date of this mailing. The date will be returned as an ISO 8601 formatted date
     * string.
     */
    public function getModificationDatetime();

    /**
     * Returns an <i>Inx_Api_ROBOResultSet</i> containing all sendings of this mailing or empty if it has not yet been
     * sent.
     *
     * @return Inx_Api_ROBOResultSet a <i>ROBOResultSet</i> containing all sendings of this mailing or empty if it has
     * not yet been sent.
     */
    public function findSendings();

    /**
     * Returns the last <i>Inx_Api_Sending_Sending</i> of this mailing, or null if this mailing has not yet been sent.
     *
     * @return Inx_Api_Sending_Sending the last <i>Sending</i> of this mailing, or null.
     */
    public function findLastSending();
}
