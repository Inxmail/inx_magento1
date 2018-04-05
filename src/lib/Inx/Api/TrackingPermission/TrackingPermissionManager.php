<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

 /**
  * The <i>Inx_Api_TrackingPermission_TrackingPermissionManager</i> manages tracking permissions.
  *
  * The <i>Inx_Api_TrackingPermission_TrackingPermissionManager</i> can be used to perform the following tasks:
  * <ul>
  * <li>Retrieve tracking permissions</li>
  * <li>Grant a tracking permission</li>
  * <li>Revoke a tracking permission</li>
  * </ul>
  * <p>
  * <b>Tracking permission retrieval</b>
  * <p>
  * Tracking permissions can be retrieved via a <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>.
  * A query object can be created by calling the method
  * <i>createQuery()</i>. This will create a new query object without any preset filter. In order to find specific
  * mailings, the corresponding filters have to be added to the query before executing it. For an example on how to do
  * so, see the <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> documentation.
  * <p>
  * The following snippet shows how to create and execute a query that retrieves all tracking permissions in the system:
  * <pre>
  * $oTrackingPermissionManager = $oSession->getTrackingPermissionManager();
  * $oTrackingPermissionQuery = $oTrackingPermissionManager->createQuery();
  * $oSet = $oTrackingPermissionQuery->executeQuery();
  * foreach ($oSet as $oTrackingPermission) {
  *   echo $oTrackingPermission->getRecipientId() . ", " . $oTrackingPermission->getListId() . PHP_EOL;
  * }
  * $oSet->close();
  * </pre>
  * This provides the same result as a call to <i>selectAll()</i>.
  * <p>
  * <b>Grant or revoke tracking permission</b>
  * <p>
  * The following snippet shows how to grant a tracking permission for the recipient with ID 2 on the list with ID 5.
  * To revoke a tracking permission the code
  * is very similar, just use the <i>revokeTrackingPermission</i> instead.
  * <pre>
  * $oTrackingPermissionManager = $oSession->getTrackingPermissionManager();
  * $oTrackingPermissionManager->grantTrackingPermission(2, 5);
  * </pre>
  *
  * @see Inx_Api_TrackingPermission_TrackingPermission
  * @see Inx_Api_TrackingPermission_TrackingPermissionQuery
  * @since 1.17.0
  */
interface Inx_Api_TrackingPermission_TrackingPermissionManager extends Inx_Api_BOManager
{
    /**
     * Creates and initializes a new <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> object without any query filter.
     *
     * @return Inx_Api_TrackingPermission_TrackingPermissionQuery a new initialized <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>
     */
    public function createQuery();

    /**
     * Grants a tracking permission for the specified recipient on the specified list.
     *
     * @param int $iRecipientId the ID of the recipient
     * @param int $iListId the ID of the list
     * @throws Inx_Api_UpdateException if the request cannot be completed, for example because the recipient was not found
     */
    public function grantTrackingPermission( $iRecipientId, $iListId );

    /**
     * Revokes a tracking permission for the specified recipient on the specified list.
     *
     * @param int $iRecipientId the ID of the recipient
     * @param int $iListId the ID of the list
     * @throws Inx_Api_UpdateException if the request cannot be completed, for example because the recipient was not found
     */
    public function revokeTrackingPermission( $iRecipientId, $iListId );
}
