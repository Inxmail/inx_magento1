<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * The type of the originator defines where the tracking permission originated from.
 *
 * The identity of the originator depends on the type. See the documentation of the
 * enum types for information about how the identity has to be interpreted.
 *
 * @since API 1.18.0
 */
final class Inx_Api_TrackingPermission_OriginatorType
{
	private static $ACTION = null;
	private static $FORCED_SUBSCRIPTION = null;
	private static $API_IMPORT = null;
	private static $MANUAL_IMPORT = null;
	private static $AUTOMATED_IMPORT = null;
	private static $REMOVED_FROM_LIST = null;
	private static $RPC_API = null;
	private static $CLICK = null;
	private static $EMAIL_SUBSCRIPTION = null;
	private static $EMAIL_UNSUBSCRIPTION = null;
	private static $FORCED_UNSUBSCRIPTION = null;
	private static $SUBSCRIPTION_SERVLET = null;
	private static $SYNC_AGENT = null;
	private static $REST_API = null;
	private static $USER_UNSUBSCRIPTION = null;
	private static $REMOVED_FROM_SYSTEM = null;
	private static $LIST_REMOVED = null;
	private static $TRACKING_PERMISSION_LINK = null;
	private static $USER_MANUAL_CHANGE = null;
	private static $RPC_API_SUBSCRIPTION = null;
	private static $RPC_API_TRACKING_PERMISSION_MANAGER = null;
	private static $REMOVED_ORPHANED = null;
	private static $UNKNOWN = null;


	/**
	 * The tracking permission originated from an action.
	 *
	 * The identity of the originator is the action id (see <i>Inx_Api_Action_ActionManager#get(int)</i>).
	 */
	public static final function ACTION()
	{
		if(self::$ACTION === null)
			self::$ACTION = new Inx_Api_TrackingPermission_OriginatorType(1);

		return self::$ACTION;
	}

	/**
	 * The tracking permission originated from a forced subscription.
	 *
	 * The identity of the originator is the id of the user who forced the subscription.
	 */
	public static final function FORCED_SUBSCRIPTION()
	{
		if(self::$FORCED_SUBSCRIPTION === null)
			self::$FORCED_SUBSCRIPTION = new Inx_Api_TrackingPermission_OriginatorType(2);

		return self::$FORCED_SUBSCRIPTION;
	}

	/**
	 * The tracking permission originated from a Inxmail Professional REST API import.
	 *
	 * The identity of the originator is the integration name.
	 */
	public static final function API_IMPORT()
	{
		if(self::$API_IMPORT === null)
			self::$API_IMPORT = new Inx_Api_TrackingPermission_OriginatorType(3);

		return self::$API_IMPORT;
	}

	/**
	 * The tracking permission originated from a manual import.
	 *
	 * The identity of the originator is the id of the user who triggered the import.
	 */
	public static final function MANUAL_IMPORT()
	{
		if(self::$MANUAL_IMPORT === null)
			self::$MANUAL_IMPORT = new Inx_Api_TrackingPermission_OriginatorType(4);

		return self::$MANUAL_IMPORT;
	}

	/**
	 * The tracking permission originated from an automated import.
	 *
	 * The identity of the originator is the import automation ID.
	 */
	public static final function AUTOMATED_IMPORT()
	{
		if(self::$AUTOMATED_IMPORT === null)
			self::$AUTOMATED_IMPORT = new Inx_Api_TrackingPermission_OriginatorType(5);

		return self::$AUTOMATED_IMPORT;
	}

	/**
	 * The tracking permission was deleted because the recipient was removed from the list.
	 *
	 * The originator has no identity.
	 */
	public static final function REMOVED_FROM_LIST()
	{
		if(self::$REMOVED_FROM_LIST === null)
			self::$REMOVED_FROM_LIST = new Inx_Api_TrackingPermission_OriginatorType(6);

		return self::$REMOVED_FROM_LIST;
	}

	/**
	 * The tracking permission originated from the Inxmail Professional API.
	 *
	 * The identity of the originator is the user id of the Inxmail Professional API user.
	 */
	public static final function RPC_API()
	{
		if(self::$RPC_API === null)
			self::$RPC_API = new Inx_Api_TrackingPermission_OriginatorType(7);

		return self::$RPC_API;
	}

	/**
	 * The tracking permission originated from a click on a link.
	 *
	 * The originator has no identity.
	 */
	public static final function CLICK()
	{
		if(self::$CLICK === null)
			self::$CLICK = new Inx_Api_TrackingPermission_OriginatorType(8);

		return self::$CLICK;
	}

	/**
	 * The tracking permission originated from a subscription via email.
	 *
	 * The originator has no identity.
	 */
	public static final function EMAIL_SUBSCRIPTION()
	{
		if(self::$EMAIL_SUBSCRIPTION === null)
			self::$EMAIL_SUBSCRIPTION = new Inx_Api_TrackingPermission_OriginatorType(9);

		return self::$EMAIL_SUBSCRIPTION;
	}

	/**
	 * The tracking permission was removed because the recipient was unsubscribed by a email unsubscription.
	 *
	 * The originator has no identity.
	 */
	public static final function EMAIL_UNSUBSCRIPTION()
	{
		if(self::$EMAIL_UNSUBSCRIPTION === null)
			self::$EMAIL_UNSUBSCRIPTION = new Inx_Api_TrackingPermission_OriginatorType(10);

		return self::$EMAIL_UNSUBSCRIPTION;
	}

	/**
	 * The tracking permission was removed because the recipient was unsubscribed by a forced unsubscription.
	 *
	 * The identity of the originator is the id of the user who forced the unsubscription.
	 */
	public static final function FORCED_UNSUBSCRIPTION()
	{
		if(self::$FORCED_UNSUBSCRIPTION === null)
			self::$FORCED_UNSUBSCRIPTION = new Inx_Api_TrackingPermission_OriginatorType(11);

		return self::$FORCED_UNSUBSCRIPTION;
	}

	/**
	 * The tracking permission originated from the subscription servlet.
	 *
	 * The originator has no identity.
	 */
	public static final function SUBSCRIPTION_SERVLET()
	{
		if(self::$SUBSCRIPTION_SERVLET === null)
			self::$SUBSCRIPTION_SERVLET = new Inx_Api_TrackingPermission_OriginatorType(12);

		return self::$SUBSCRIPTION_SERVLET;
	}

	/**
	 * The tracking permission originated from the sync agent.
	 *
	 * The identity of the originator is the sync source.
	 */
	public static final function SYNC_AGENT()
	{
		if(self::$SYNC_AGENT === null)
			self::$SYNC_AGENT = new Inx_Api_TrackingPermission_OriginatorType(13);

		return self::$SYNC_AGENT;
	}

	/**
	 * The tracking permission originated from the Inxmail Professional REST API.
	 *
	 * The identity of the originator is the integration name.
	 */
	public static final function REST_API()
	{
		if(self::$REST_API === null)
			self::$REST_API = new Inx_Api_TrackingPermission_OriginatorType(14);

		return self::$REST_API;
	}

	/**
	 * The tracking permission was removed because the recipient was unsubscribed by an Inxmail Professional user.
	 *
	 * The identity of the originator is the id of the user who did the unsubscription.
	 */
	public static final function USER_UNSUBSCRIPTION()
	{
		if(self::$USER_UNSUBSCRIPTION === null)
			self::$USER_UNSUBSCRIPTION = new Inx_Api_TrackingPermission_OriginatorType(16);

		return self::$USER_UNSUBSCRIPTION;
	}

	/**
	 * The tracking permission was removed because the recipient was removed from the system.
	 *
	 * The originator has no identity.
	 */
	public static final function REMOVED_FROM_SYSTEM()
	{
		if(self::$REMOVED_FROM_SYSTEM === null)
			self::$REMOVED_FROM_SYSTEM = new Inx_Api_TrackingPermission_OriginatorType(17);

		return self::$REMOVED_FROM_SYSTEM;
	}

	/**
	 * The tracking permission was removed because the list was removed.
	 *
	 * The originator has no identity.
	 */
	public static final function LIST_REMOVED()
	{
		if(self::$LIST_REMOVED === null)
			self::$LIST_REMOVED = new Inx_Api_TrackingPermission_OriginatorType(18);

		return self::$LIST_REMOVED;
	}

	/**
	 * The tracking permission originated from a click on a tracking permission link.
	 *
	 * The identity of the originator is the ID of the tracking permission link.
	 */
	public static final function TRACKING_PERMISSION_LINK()
	{
		if(self::$TRACKING_PERMISSION_LINK === null)
			self::$TRACKING_PERMISSION_LINK = new Inx_Api_TrackingPermission_OriginatorType(19);

		return self::$TRACKING_PERMISSION_LINK;
	}

	/**
	 * The tracking permission was changed manually by an Inxmail Professional user.
	 *
	 * The identity of the originator is the id of the user who did the manual change.
	 */
	public static final function USER_MANUAL_CHANGE()
	{
		if(self::$USER_MANUAL_CHANGE === null)
			self::$USER_MANUAL_CHANGE = new Inx_Api_TrackingPermission_OriginatorType(20);

		return self::$USER_MANUAL_CHANGE;
	}

	/**
	 * The tracking permission originated from a subscription via Inxmail Professional API, e.g. the <i>Inx_Api_Subscription_SubscriptionManager</i>.
	 *
	 * The identity of the originator is the id of the Inxmail Professional API user.
	 */
	public static final function RPC_API_SUBSCRIPTION()
	{
		if(self::$RPC_API_SUBSCRIPTION === null)
			self::$RPC_API_SUBSCRIPTION = new Inx_Api_TrackingPermission_OriginatorType(21);

		return self::$RPC_API_SUBSCRIPTION;
	}

	/**
	 * The tracking permission originated from the <i>Inx_Api_TrackingPermission_TrackingPermissionManager</i>.
	 *
	 * The identity of the originator is the id of the Inxmail Professional API user.
	 */
	public static final function RPC_API_TRACKING_PERMISSION_MANAGER()
	{
		if(self::$RPC_API_TRACKING_PERMISSION_MANAGER === null)
			self::$RPC_API_TRACKING_PERMISSION_MANAGER = new Inx_Api_TrackingPermission_OriginatorType(22);

		return self::$RPC_API_TRACKING_PERMISSION_MANAGER;
	}

	/**
	 * The tracking permission was removed because the referenced list no longer supports tracking permissions without subscription.
	 *
	 * The originator has no identity.
	 */
	public static final function REMOVED_ORPHANED()
	{
		if(self::$REMOVED_ORPHANED === null)
			self::$REMOVED_ORPHANED = new Inx_Api_TrackingPermission_OriginatorType(23);

		return self::$REMOVED_ORPHANED;
	}

	/**
	 * Type is unknown.
	 */
	public static final function UNKNOWN()
	{
		if(self::$UNKNOWN === null)
			self::$UNKNOWN = new Inx_Api_TrackingPermission_OriginatorType(-1);

		return self::$UNKNOWN;
	}


	private $id;

	private function __construct( $iId )
	{
		$this->id = $iId;
	}

	/**
	 * Returns the ID of the <i>Inx_Api_TrackingPermission_OriginatorType</i>. The ID is used for transmission purposes and should
	 * not be used inside client code.
	 *
	 * @return int the ID of the <i>Inx_Api_TrackingPermission_OriginatorType</i>
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Returns the <i>Inx_Api_TrackingPermission_OriginatorType</i> corresponding to the given <i>id</i>. If the ID is
	 * unknown, the <i>UNKNOWN</i> type will be returned. The ID is used for transmission purposes and should not
	 * be used inside client code.
	 *
	 * @param int $iId the ID of the <i>Inx_Api_TrackingPermission_OriginatorType</i> to retrieve.
	 * @return int the <i>Inx_Api_TrackingPermission_OriginatorType</i> corresponding to the given ID.
	 */
	public static function byId( $iId )
	{
		foreach( self::values() as $value )
		{
			if( $value->getId() === $iId )
				return $value;
		}

		return self::UNKNOWN();
	}


	public static function values()
	{
		return array(self::ACTION(), self::FORCED_SUBSCRIPTION(), self::API_IMPORT(), self::MANUAL_IMPORT(), self::AUTOMATED_IMPORT(), self::REMOVED_FROM_LIST(), self::RPC_API(), self::CLICK(), self::EMAIL_SUBSCRIPTION(), self::EMAIL_UNSUBSCRIPTION(), self::FORCED_UNSUBSCRIPTION(), self::SUBSCRIPTION_SERVLET(), self::SYNC_AGENT(), self::REST_API(), self::USER_UNSUBSCRIPTION(), self::REMOVED_FROM_SYSTEM(), self::LIST_REMOVED(), self::TRACKING_PERMISSION_LINK(), self::USER_MANUAL_CHANGE(), self::RPC_API_SUBSCRIPTION(), self::RPC_API_TRACKING_PERMISSION_MANAGER(), self::REMOVED_ORPHANED(), self::UNKNOWN());
	}
}
