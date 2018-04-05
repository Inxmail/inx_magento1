<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

 /**
  * The <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> object is used for constructing and executing tracking permission queries.
  *
  * The following filters can be defined:
  * <ul>
  * <li>Tracking permission IDs</li>
  * <li>List ids</li>
  * <li>Recipient ids</li>
  * </ul>
  * The defined filters are additive (logical AND) but allow any field value if undefined. In addition, the query can
  * define a result ordering by any <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i>. The parameters of most methods are arrays, so they
  * support an arbitrary number of values. The methods implement a fluent API and thus can be chained.
  * It is possible to set each filter multiple times, but each subsequent set call will overwrite the previous
  * configuration of this filter.
  * <p>
  * <b>Important note:</b> The Inxmail Professional server will terminate any <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>
  * request that produces an overall result size of over a hundred million tracking permissions, by default. Any request with a result size
  * above this threshold will result in a server-side <i>RuntimeException</i>.
  * <p>
  * An empty <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> object can be obtained from the <i>Inx_Api_TrackingPermission_TrackingPermissionManager</i>.
  * The following snippet shows how to construct and execute a query for all tracking permissions granted to particular list,
  * ordered ascending by recipient id:
  * <pre>
  * $oTrackingPermissionManager = $oSession->getTrackingPermissionManager();
  * $oTrackingPermissionQuery = $oTrackingPermissionManager->createQuery()
  *   ->listIds( array( 5 ) )
  *   ->sort( Inx_Api_TrackingPermission_TrackingPermissionAttribute::RECIPIENT_ID(), Inx_Api_Order::ASC );
  * $oSet = $oTrackingPermissionQuery->executeQuery();
  * foreach ($oSet as $oTrackingPermission) {
  *   echo $oTrackingPermission->getRecipientId() . ", " . $oTrackingPermission->getListId() . PHP_EOL;
  * }
  * $oSet->close();
  * </pre>
  *
  * @since API 1.17.0
  */
interface Inx_Api_TrackingPermission_TrackingPermissionQuery
{
    /**
     * Sets the filter for tracking permission IDs.
     *
     * The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> will provide tracking permissions with the given IDs only.
     * Any previously set tracking permission filter will be overwritten.
     * If <i>null</i> or an empty array is provided, this will reset the tracking permission filter.
     * Invalid or inexistent trackingPermissionIds will be included in the query. The resultset will be empty if there
     * had been no valid tracking permission ID.
     *
     * @param array $aIds the IDs of the tracking permissions to be set as filter
     * @return Inx_Api_TrackingPermission_TrackingPermissionQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>
     */
    public function trackingPermissionIds(array $aIds = null);


	/**
	 * Sets the filter for recipient IDs.
	 *
	 * The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> will provide tracking permissions
	 * granted by the given recipients only. Any previously set recipient filter will be overwritten.
	 * If <i>null</i> or an empty array is provided, this will reset the recipient filter.
	 * Invalid or inexistent recipientIds will be included in the query. The resultset will be empty if there had been no
	 * valid recipient ID.
	 *
	 * @param array $aRecipientIds the IDs of the recipients to be set as filter
	 * @return Inx_Api_TrackingPermission_TrackingPermissionQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>
	 */
    public function recipientIds(array $aRecipientIds = null);


    /**
     * Sets the filter for list IDs.
     *
     * The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> will provide tracking permissions
     * granted to the given lists only. Any previously set list filter will be overwritten.
     * If <i>null</i> or an empty array is provided, this will reset the list filter.
     * Invalid or inexistent listIds will be included in the query. The resultset will be empty if there had been no
     * valid list ID.
     *
     * @param array $aListIds the IDs of the lists to be set as filter
     * @return Inx_Api_TrackingPermission_TrackingPermissionQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>
     */
    public function listIds(array $aListIds = null);


    /**
     * Sets ordering attribute and ordering direction.
     *
     * The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i> will be ordered by
     * the provided <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> in the specified <i>Inx_Api_Order</i>. Any
     * previously set ordering will be overwritten.
     *
     * If <i>null</i> is provided as <i>$oAttribute</i>, this will cause a <i>Inx_Api_NullPointerException</i>.
     *
     * @param Inx_Api_TrackingPermission_TrackingPermissionAttribute $oAttribute the <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> to be ordered by
     * @param int $iOrderType the <i>Inx_Api_Order</i> direction
     * @return Inx_Api_TrackingPermission_TrackingPermissionQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>
     * @throws Inx_Api_IllegalArgumentException if the provided <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> is
     *             <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute::UNKNOWN</i> or if the provided <i>$iOrderType</i> is invalid
     * @throws Inx_Api_NullPointerException if the provided <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> is <i>null</i>
     */
    public function sort(Inx_Api_TrackingPermission_TrackingPermissionAttribute $oAttribute, $iOrderType);


	/**
	 * Executes this <i>Inx_Api_TrackingPermission_TrackingPermissionQuery</i>.
	 *
	 * Returns a <i>Inx_Api_BOResultSet</i> in the specified order
	 * containing all <i>Inx_Api_TrackingPermission_TrackingPermission</i>s, that pass all specified filters.
	 * <p>
	 * Unspecified filters are ignored, any value will pass for their fields. All specified filters are combined with a
	 * logical AND.
	 *
	 * @return Inx_Api_BOResultSet A <i>Inx_Api_BOResultSet</i> containing all <i>Inx_Api_TrackingPermission_TrackingPermission</i>s, that pass all specified filters
	 */
    public function executeQuery();
}
