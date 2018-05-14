<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * The <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> enumeration defines the attributes of tracking permission logs that can be used for the ordering of result sets.
 *
 * @see Inx_Api_TrackingPermission_TrackingPermissionLogQuery::sort()
 * @since API 1.18.0
 */
final class Inx_Api_TrackingPermission_TrackingPermissionLogAttribute
{
	private static $ID = null;
	private static $RECIPIENT_ID = null;
	private static $LIST_ID = null;
	private static $TIMESTAMP = null;
	private static $UNKNOWN = null;

	/**
	 * Attribute for ordering by tracking permission log ID
	 */
	public static final function ID()
	{
		if(self::$ID === null)
			self::$ID = new Inx_Api_TrackingPermission_TrackingPermissionLogAttribute(0);

		return self::$ID;
	}

	/**
	 * Attribute for ordering by list ID
	 */
	public static final function LIST_ID()
	{
		if(self::$LIST_ID === null)
			self::$LIST_ID = new Inx_Api_TrackingPermission_TrackingPermissionLogAttribute(1);

		return self::$LIST_ID;
	}

	/**
	 * Attribute for ordering by recipient ID
	 */
	public static final function RECIPIENT_ID()
	{
		if(self::$RECIPIENT_ID === null)
			self::$RECIPIENT_ID = new Inx_Api_TrackingPermission_TrackingPermissionLogAttribute(2);

		return self::$RECIPIENT_ID;
	}

	/**
	 * Attribute for ordering by timestamp.
	 */
	public static final function TIMESTAMP()
	{
		if(self::$TIMESTAMP === null)
			self::$TIMESTAMP = new Inx_Api_TrackingPermission_TrackingPermissionLogAttribute(3);

		return self::$TIMESTAMP;
	}

	/**
	 * Attribute for unknown ordering, not a legal attribute for sorting
	 */
	public static final function UNKNOWN()
	{
		if(self::$UNKNOWN === null)
			self::$UNKNOWN = new Inx_Api_TrackingPermission_TrackingPermissionLogAttribute(-1);

		return self::$UNKNOWN;
	}


	private $id;

	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i>. The ID is used for transmission purposes and should
	 * not be used inside client code.
	 *
	 * @return int the ID of the <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i>
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> corresponding to the given <i>id</i>. If the ID is
	 * unknown, the <i>UNKNOWN</i> type will be returned. The ID is used for transmission purposes and should not
	 * be used inside client code.
	 *
	 * @param int $iId the ID of the <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> to retrieve.
	 * @return int the <i>Inx_Api_TrackingPermission_TrackingPermissionLogAttribute</i> corresponding to the given ID.
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
		return array(self::ID(), self::RECIPIENT_ID(), self::LIST_ID(), self::TIMESTAMP(), self::UNKNOWN());
	}
}

