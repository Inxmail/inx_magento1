<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * An <i>Inx_Api_TrackingPermission_Originator</i> represents the origin a tracking permission comes from.
 *
 * @since 1.18.0
 */
interface Inx_Api_TrackingPermission_Originator
{
    /**
     * Returns the type of the <i>Inx_Api_TrackingPermission_Originator</i>.
     *
     * @return Inx_Api_TrackingPermission_Originator the type of the <i>Inx_Api_TrackingPermission_Originator</i>.
     */
    public function getType();

    /**
     * Returns the identity of the <i>Inx_Api_TrackingPermission_Originator</i>.
     *
     * @return string the identity of the <i>Inx_Api_TrackingPermission_Originator</i>.
     */
    public function getIdentity();

    /**
     * Returns the message of the <i>Inx_Api_TrackingPermission_Originator</i>.
     *
     * @return string the message of the <i>Inx_Api_TrackingPermission_Originator</i>.
     */
    public function getMessage();

    /**
     * Returns the determined remote address of the <i>Inx_Api_TrackingPermission_Originator</i>.
     *
     * In the case of subscriptions using the SubscriptionManager, for example,
     * the determined remote address is the IP address of the API client initiating
     * the request.
     *
     * @return string the determined remote address of the <i>Inx_Api_TrackingPermission_Originator</i>.
     */
    public function getDeterminedRemoteAddress();

    /**
     * Returns the supplied remote address of the <i>Inx_Api_TrackingPermission_Originator</i>.
     *
     * In the case of subscriptions using the SubscriptionManager, for example,
     * the supplied remote address is the IP address which was specified by the
     * API client initiating the request which is used to denote the original
     * source.
     *
     * @return string the supplied remote address of the <i>Inx_Api_TrackingPermission_Originator</i>.
     */
    public function getSuppliedRemoteAddress();
}
