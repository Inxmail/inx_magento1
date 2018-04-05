<?php
/**
 * @package Inxmail
 * @subpackage GeneralMailing
 */
/**
 * The <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i> enumeration defines the attributes of general mailings that can be used for the ordering of result sets.
 *
 * @see Inx_Api_GeneralMailing_GeneralMailingQuery::sort()
 * @since API 1.11.10
 */
final class Inx_Api_GeneralMailing_GeneralMailingAttribute
{
	private static $MAILING_ID = null;
	private static $MAILING_TYPE = null;
	private static $LIST_ID = null;
	private static $NAME = null;
	private static $SUBJECT = null;
	private static $CREATION_DATE = null;
	private static $MODIFICATION_DATE = null;
	private static $UNKNOWN = null;


	/**
	 * Attribute for ordering by mailing ID
	 */
	public static final function MAILING_ID()
	{
		if(null === self::$MAILING_ID)
			self::$MAILING_ID = new Inx_Api_GeneralMailing_GeneralMailingAttribute(0);

		return self::$MAILING_ID;
	}

	/**
	 * Attribute for ordering by mailing type
	 */
	public static final function MAILING_TYPE()
	{
		if(null === self::$MAILING_TYPE)
			self::$MAILING_TYPE = new Inx_Api_GeneralMailing_GeneralMailingAttribute(1);

		return self::$MAILING_TYPE;
	}

	/**
	 * Attribute for ordering by the mailing list ID
	 */
	public static final function LIST_ID()
	{
		if(null === self::$LIST_ID)
			self::$LIST_ID = new Inx_Api_GeneralMailing_GeneralMailingAttribute(2);

		return self::$LIST_ID;
	}

	/**
	 * Attribute for ordering by mailing name
	 */
	public static final function NAME()
	{
		if(null === self::$NAME)
			self::$NAME = new Inx_Api_GeneralMailing_GeneralMailingAttribute(3);

		return self::$NAME;
	}

	/**
	 * Attribute for ordering by mailing subject
	 */
	public static final function SUBJECT()
	{
		if(null === self::$SUBJECT)
			self::$SUBJECT = new Inx_Api_GeneralMailing_GeneralMailingAttribute(4);

		return self::$SUBJECT;
	}

	/**
	 * Attribute for ordering by mailing creation date
	 */
	public static final function CREATION_DATE()
	{
		if(null === self::$CREATION_DATE)
			self::$CREATION_DATE = new Inx_Api_GeneralMailing_GeneralMailingAttribute(5);

		return self::$CREATION_DATE;
	}

	/**
	 * Attribute for ordering by mailing modification date
	 */
	public static final function MODIFICATION_DATE()
	{
		if(null === self::$MODIFICATION_DATE)
			self::$MODIFICATION_DATE = new Inx_Api_GeneralMailing_GeneralMailingAttribute(6);

		return self::$MODIFICATION_DATE;
	}

	/**
	 * Attribute for unknown ordering, not a legal attribute for sorting
	 */
	public static final function UNKNOWN()
	{
		if(null === self::$UNKNOWN)
			self::$UNKNOWN = new Inx_Api_GeneralMailing_GeneralMailingAttribute(-1);

		return self::$UNKNOWN;
	}


	private $id;

	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i>.
	 * The ID is used for transmission purposes and should not be used inside client code.
	 *
	 * @return int the ID of the <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i>
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i> corresponding to the given <i>$iId</i>.
	 * If the ID is unknown, the <i>UNKNOWN</i> type will be returned.
	 * The ID is used for transmission purposes and should not be used inside client code.
	 *
	 * @param int $iId the ID of the <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i> to retrieve.
	 * @return Inx_Api_GeneralMailing_GeneralMailingAttribute the <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i> corresponding to the given ID.
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


    /**
     * Returns an array containing all available <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i>s including UNKNOWN.
     *
     * @return array an array containing all available <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i>s including UNKNOWN.
     */
	public static function values()
	{
		return array(self::MAILING_ID(), self::MAILING_TYPE(), self::LIST_ID(),
                    self::NAME(), self::SUBJECT(), self::CREATION_DATE(), self::MODIFICATION_DATE(), self::UNKNOWN());
	}
}
