<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * The <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> enumeration defines the attributes of tracking permissions that can be used for
 * the ordering of result sets.
 *
 * It is also used in <i>Inx_Api_UpdateException</i> to specify the error source.
 *
 * @see Inx_Api_TrackingPermission_TrackingPermissionQuery::sort()
 * @since API 1.17.0
 */
final class Inx_Api_TrackingPermission_TrackingPermissionAttribute
{
	private static $TRACKING_PERMISSION_ID = null;
	private static $LIST_ID = null;
	private static $RECIPIENT_ID = null;
	private static $UNKNOWN = null;


    /**
     * Attribute for ordering by tracking permission ID
     */
	public static final function TRACKING_PERMISSION_ID()
	{
		if(self::$TRACKING_PERMISSION_ID === null)
			self::$TRACKING_PERMISSION_ID = new Inx_Api_TrackingPermission_TrackingPermissionAttribute(0);

		return self::$TRACKING_PERMISSION_ID;
	}

    /**
     * Attribute for ordering by list ID
     */
	public static final function LIST_ID()
	{
		if(self::$LIST_ID === null)
			self::$LIST_ID = new Inx_Api_TrackingPermission_TrackingPermissionAttribute(1);

		return self::$LIST_ID;
	}

    /**
     * Attribute for ordering by recipient ID
     */
	public static final function RECIPIENT_ID()
	{
		if(self::$RECIPIENT_ID === null)
			self::$RECIPIENT_ID = new Inx_Api_TrackingPermission_TrackingPermissionAttribute(2);

		return self::$RECIPIENT_ID;
	}

    /**
     * Attribute for unknown ordering, not a legal attribute for sorting
     */
	public static final function UNKNOWN()
	{
		if(self::$UNKNOWN === null)
			self::$UNKNOWN = new Inx_Api_TrackingPermission_TrackingPermissionAttribute(-1);

		return self::$UNKNOWN;
	}


	private $id;

	private function __construct( $iId )
	{
		$this->id = $iId;
	}

    /**
     * Returns the ID of the <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i>.
     *
     * The ID is used for transmission purposes and should not be used inside client code.
     *
     * @return int the ID of the <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i>
     */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Returns the <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> corresponding to the given <i>id</i>.
	 *
	 * If the ID is unknown, the <i>UNKNOWN</i> type will be returned. The ID is used for transmission purposes and should not
	 * be used inside client code.
	 *
	 * @param int $iId the ID of the <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> to retrieve.
	 * @return Inx_Api_TrackingPermission_TrackingPermissionAttribute the <i>Inx_Api_TrackingPermission_TrackingPermissionAttribute</i> corresponding to the given ID.
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
		return array(self::TRACKING_PERMISSION_ID(), self::LIST_ID(), self::RECIPIENT_ID(), self::UNKNOWN());
	}
}
