<?php

/**
 * @package Inxmail
 * @subpackage SplitTestMailing
 */

/**
 * A <i>Inx_Api_SplitTestMailing_SplitTestMailing</i> object represents a split test mailing in Inxmail. It provides common mailing
 * attributes and also the corresponding split test id.
 *
 * @since API 1.13.1
 */
interface Inx_Api_SplitTestMailing_SplitTestMailing extends Inx_Api_BusinessObject
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
     * Returns the <i>Inx_Api_SplitTest_SplitTest</i> this mailing belongs to. A <i>null</i> value is returned if the
     * corresponding split test could not be found (e.g. no split test was linked with this split test mailing).
     *
     * @return Inx_Api_SplitTest_SplitTest the <i>SplitTest</i> this mailing belongs to or null.
     */
    public function getSplitTest();

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
