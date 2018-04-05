<?php
/**
 * @package Inxmail
 * @subpackage TrackingPermission
 */

/**
 * The <i>TrackingPermissionState</i> enumeration defines to what extend a recipient may be tracked.
 *
 * In this case, tracking refers to the ability to determine which recipient clicked on which link to enable
 * further personalization and followup mailings.
 *
 * @since API 1.14.1
 */
final class Inx_Api_TrackingPermission_TrackingPermissionState
{
	private static $GRANTED = null;
	private static $DENIED = null;
	private static $UNKNOWN = null;

    /**
	 * Indicates that the tracking permission has been granted,
	 * which means the recipient gave permission to evaluate which links she clicked on.
	 */
	public static final function GRANTED()
	{
		if(self::$GRANTED === null)
			self::$GRANTED = new Inx_Api_TrackingPermission_TrackingPermissionState(1);

		return self::$GRANTED;
	}

    /**
	 * Indicates that the tracking permission has been denied,
	 * which means the recipient disallowed evaluating which links she clicked on.
	 */
	public static final function DENIED()
	{
		if(self::$DENIED === null)
			self::$DENIED = new Inx_Api_TrackingPermission_TrackingPermissionState(0);

		return self::$DENIED;
	}

    /**
	 * Indicates a version mismatch between API and server
	 */
	public static final function UNKNOWN()
	{
		if(self::$UNKNOWN === null)
			self::$UNKNOWN = new Inx_Api_TrackingPermission_TrackingPermissionState(-1);

		return self::$UNKNOWN;
	}


	private $id;

	private function __construct( $iId )
	{
		$this->id = $iId;
	}


    /**
	 * Returns the ID of the <i>TrackingPermissionState</i>.
	 *
	 * @return the ID of the <i>TrackingPermissionState</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


    /**
	 * Returns the <i>Inx_Api_TrackingPermission_TrackingPermissionState</i> corresponding to the given id.
	 *
	 * If the id is unknown, the <i>UNKNOWN</i> state will be returned.
	 *
	 * @param int $iId the ID of the <i>TrackingPermissionState</i> to retrieve.
	 * @return Inx_Api_TrackingPermission_TrackingPermissionState the <i>TrackingPermissionState</i> corresponding to the given ID.
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
		return array(self::GRANTED(), self::DENIED(), self::UNKNOWN());
	}
}
