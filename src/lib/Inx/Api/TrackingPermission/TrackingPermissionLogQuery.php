<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * The <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i> object is used for constructing and executing tracking permission log queries.
 *
 * The following filters can be defined:
 * <ul>
 * <li>List ids</li>
 * <li>Recipient ids</li>
 * <li>Start date</li>
 * <li>End date</li>
 * <li>After id</li>
 * </ul>
 * <p>
 * The defined filters are additive (logical AND) but allow any field value if undefined. In addition, the query can
 * define a result ordering by any <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i>.
 * The methods implement a fluent API and thus can be chained.
 * It is possible to set each filter multiple times, but each subsequent set call will overwrite the previous
 * configuration of this filter.
 * <p>
 * <b>Important note:</b> The Inxmail Professional server will terminate any <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i>
 * request that produces an overall result size of over a hundred million tracking permissions log entries, by default. Any request with a result size
 * above this threshold will result in a server-side <i>RuntimeException</i>.
 * <p>
 * An empty <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i> object can be obtained from the <i>Inx_Api_TrackingPermission_TrackingPermissionManager</i>.
 * The following snippet shows how to construct and execute a query for all tracking permissions log entries referring to a particular list,
 * ordered ascending by recipient id:
 * <pre>
 * $oTrackingPermissionManager = $oSession->getTrackingPermissionManager();
 * $oQuery = $oTrackingPermissionManager->createLogQuery()
 *   ->listIds( array(5) )
 *   ->sort( Inx_Api_TrackingPermission_TrackingPermissionLogAttribute::RECIPIENT_ID(), Inx_Api_Order::ASC );
 *
 * $oSet = $oQuery->executeQuery();
 * while( $oSet->next() )
 * {
 *   //retrieve some information from the row set.
 * }
 * </pre>
 *
 * @since 1.18.0
 */
interface Inx_Api_TrackingPermission_TrackingPermissionLogQuery
{
    /**
     * Sets the filter for recipient IDs. The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i> will provide tracking permissions
     * log entries referring to the given recipients only. Any previously set recipient filter will be overwritten.
     * If <i>null</i> or an empty array is provided, this will reset the recipient filter.
     * Invalid or inexistent recipientIds will be included in the query. The resultset will be empty if there had been no
     * valid recipient ID.
     *
     * @param array $aRecipientIds the IDs of the recipients to be set as filter
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i>
     */
    public function recipientIds(array $aRecipientIds = null );

    /**
     * Sets the filter for list IDs. The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i> will provide tracking permissions
     * log entries referring to the given lists only. Any previously set list filter will be overwritten.
     * If <i>null</i> or an empty array is provided, this will reset the list filter.
     * Invalid or inexistent listIds will be included in the query. The resultset will be empty if there had been no
     * valid list ID.
     *
     * @param array $aListIds the IDs of the lists to be set as filter
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i>
     */
    public function listIds(array $aListIds );

    /**
     * Assigns an after filter (start date), overwriting any existing after filters, including those imposed by between
     * filters. The result will only contain tracking permission changes performed after or at the given date.
     *
     * If <i>null</i> is provided, this will reset the after filter.
     *
     * @param string $sDate the date by which the result shall be filtered, inclusively. The date has to be formatted as an ISO 8601 date string.
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogQuery this query.
     */
    public function after( $sDate );

    /**
     * Assigns a before filter (end date), overwriting any existing before filters, including those imposed by between
     * filters. The result will only contain tracking permission changes performed before or at the given date.
     *
     * If <i>null</i> is provided, this will reset the before filter.
     *
     * @param string $sDate the date by which the result shall be filtered, inclusively. The date has to be formatted as an ISO 8601 date string.
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogQuery this query.
     */
    public function before( $sDate );

    /**
     * Assigns a between filter (start and end date), overwriting any existing before, after and between filters. The
     * result will only contain tracking permission changes performed after or at the given start date and before or at the given end date.
     *
     * If <i>null</i> is provided, this will reset the before and after filter.
     *
     * @param string $sStart the start date by which the result shall be filtered, inclusively. The date has to be formatted as an ISO 8601 date string.
     * @param string $sEnd   the end date by which the result shall be filtered, inclusively. The date has to be formatted as an ISO 8601 date string.
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogQuery this query.
     */
    public function between( $sStart, $sEnd );

    /**
     * Sets the filter for the tracking permission log ID. The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i> will provide tracking permissions
     * log entries having a greater ID than the given ID (exclusive) only. Any previously set ID filter will be overwritten.
     *
     * This filter can be used for periodic synchronization of the tracking permission log to ensure that there is
     * neither an overlap nor any missed log entries between synchronizations. To do so, the last ID of the previous
     * synchronization becomes the input of this filter. Be aware that for this way of synchronizing log entries, the
     * result must be ordered by <i>TrackingPermissionLogAttribute::ID</i>. This is the recommended way of
     * synchronizing the tracking permission log with other systems.
     *
     * If <i>null</i> is provided, this will reset the after ID filter.
     *
     * @param int $iId the ID to be set as filter
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i>
     */
    public function afterId( $iId );

    /**
     * Sets ordering attribute and ordering direction.
     *
     * The resulting <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i> will be ordered by
     * the provided <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> in the specified <i>Inx_Api_Order</i>. Any
     * previously set ordering will be overwritten.
     *
     * If <i>null</i> is provided as <i>$oAttribute</i>, this will cause a <i>Inx_Api_NullPointerException</i>.
     *
     * If no sorting is specified, the result will be ordered by <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute::ID</i> in
     * <i>Inx_Api_Order::ASC</i> order.
     *
     * @param Inx_Api_TrackingPermission_TrackingPermissionLogAttribute $oAttribute the <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> to be ordered by
     * @param int $iOrderType the <i>Inx_Api_Order</i> direction
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogQuery the modified <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i>
     * @throws Inx_Api_IllegalArgumentException if the provided <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> is
     *             <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute::UNKNOWN</i> or if the provided <i>$iOrderType</i> is invalid
     * @throws Inx_Api_NullPointerException if the provided <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> is <i>null</i>
     */
    public function sort( Inx_Api_TrackingPermission_TrackingPermissionLogAttribute $oAttribute, $iOrderType );

    /**
     * Executes this <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i>.
     *
     * Returns a <i>Inx_Api_TrackingPermission_TrackingPermissionLogEntryRowSet</i> in the specified order
     * containing all tracking permission log entries, that pass all specified filters.
     * <p>
     * Unspecified filters are ignored, any value will pass for their fields. All specified filters are combined with a
     * logical AND.
     *
     * @return Inx_Api_TrackingPermission_TrackingPermissionLogEntryRowSet A <i>Inx_Api_TrackingPermission_TrackingPermissionLogEntryRowSet</i> containing all tracking permission log entries, that pass all specified filters
     */
    public function executeQuery();
}
