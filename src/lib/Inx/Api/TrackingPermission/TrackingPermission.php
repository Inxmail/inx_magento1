<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * A <i>Inx_Api_TrackingPermission_TrackingPermission</i> object represents a tracking permission which was granted by a recipient.
 *
 * For an example on how to retrieve tracking permissions, see the <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> documentation.
 *
 * @since 1.17.0
 */
interface Inx_Api_TrackingPermission_TrackingPermission extends Inx_Api_BusinessObject
{
    /**
     * Returns the id of the tracking permission.
     *
     * @return int the id of the tracking permission
     */
    public function getId();

    /**
     * Returns the id of the recipient who granted the tracking permission.
     *
     * @return int the id of the recipient
     */
    public function getRecipientId();

    /**
     * Returns the id of the list to which the tracking permission was granted.
     *
     * @return int the id of the list
     */
    public function getListId();

    /**
     * There is no update allowed on tracking permissions. So this method will always throw an <i>Inx_Api_UpdateException</i>.
     *
     * @throws Inx_Api_UpdateException will always be thrown
     */
    public function commitUpdate();
}
