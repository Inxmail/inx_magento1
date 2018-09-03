<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * A <i>Inx_Api_TrackingPermission_TrackingPermissionLogEntryRowSet</i> is used to access rows of tracking permission log resulting from a query.
 * The following data can be retrieved:
 * <p>
 * <ul>
 * <li><i>Tracking permission log id</i>: the unique identifier of the tracking permission log entry.
 * <li><i>Tracking permission state</i>: the {@link TrackingPermissionState} to which the tracking permission was changed.
 * <li><i>Timestamp</i>: the point in time when the tracking permission was changed.
 * <li><i>Recipient id</i>: the unique identifier of the recipient whose tracking permission was changed.
 * <li><i>List id</i>: the unique identifier of the list on which the tracking permission was changed.
 * <li><i>Originator</i>: the origin of the tracking permission change.
 * </ul>
 * <p>
 * For information on how to navigate through a <i>Inx_Api_TrackingPermission_TrackingPermissionLogEntryRowSet</i>, see the <i>Inx_Api_InxRowSet</i> documentation.
 * <p>
 * For an example on how to query tracking permission log entries, see the <i>Inx_Api_TrackingPermission_TrackingPermissionLogQuery</i> documentation.
 *
 * @see Inx_Api_TrackingPermission_TrackingPermissionState
 * @see Inx_Api_TrackingPermission_TrackingPermissionLogQuery
 * @see Inx_Api_TrackingPermission_Originator
 * @since API 1.18.0
 */
interface Inx_Api_TrackingPermission_TrackingPermissionLogEntryRowSet extends Inx_Api_InxRowSet
{
	/**
	 * Returns the unique identifier of the tracking permission log entry.
	 *
	 * @return int the unique identifier of the tracking permission log entry.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getId();


	/**
	 * Returns the <i>Inx_Api_TrackingPermission_TrackingPermissionState</i> to which the tracking permission was changed.
	 *
	 * @return Inx_Api_TrackingPermission_TrackingPermissionState the <i>Inx_Api_TrackingPermission_TrackingPermissionState</i> to which the tracking permission was changed.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getNewState();


	/**
	 * Returns the point in time when the tracking permission was changed.
	 *
	 * @return string the point in time when the tracking permission was changed. The date will be returned as ISO 8601 formatted date string.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getTimestamp();


	/**
	 * Returns the unique identifier of the recipient whose tracking permission was changed.
	 *
	 * @return int the unique identifier of the recipient whose tracking permission was changed.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getRecipientId();


	/**
	 * Returns the unique identifier of the list on which the tracking permission was changed.
	 *
	 * @return int the unique identifier of the list on which the tracking permission was changed.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getListId();


	/**
	 * Returns the origin of the tracking permission change.
	 *
	 * @return Inx_Api_TrackingPermission_Originator the origin of the tracking permission change.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getOriginator();
}
