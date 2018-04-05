<?php
/**
 * @package Inxmail
 * @subpackage GeneralMailing
 */

/**
 * The <i>Inx_Api_GeneralMailing_MailingType</i> enumeration defines the types of general mailings which may be queried.
 *
 * @see Inx_Api_GeneralMailing_GeneralMailing::getMailingType()
 * @since API 1.11.10
 */
final class Inx_Api_GeneralMailing_MailingType
{
    private static $REGULAR_MAILING = null;
    private static $ACTION_MAILING = null;
    private static $TIME_TRIGGER_MAILING = null;
    private static $SUBSCRIPTION_TRIGGER_MAILING = null;
    private static $SPLIT_TEST_MAILING = null;
    private static $SEQUENCE_MAILING = null;
    private static $UNKNOWN = null;

	/**
	 * The <i>REGULAR_MAILING</i> type is used for regular newsletter mailings.
	 */
    public static final function REGULAR_MAILING()
    {
            if(null === self::$REGULAR_MAILING)
                    self::$REGULAR_MAILING = new Inx_Api_GeneralMailing_MailingType(0);

            return self::$REGULAR_MAILING;
    }

	/**
	 * The <i>ACTION_MAILING</i> type is used for action trigger mailings.
	 */
    public static final function ACTION_MAILING()
    {
            if(null === self::$ACTION_MAILING)
                    self::$ACTION_MAILING = new Inx_Api_GeneralMailing_MailingType(1);

            return self::$ACTION_MAILING;
    }

	/**
	 * The <i>TIME_TRIGGER_MAILING</i> type is used for time trigger mailings, e.g. birthday and interval mailing.
	 */
    public static final function TIME_TRIGGER_MAILING()
    {
            if(null === self::$TIME_TRIGGER_MAILING)
                    self::$TIME_TRIGGER_MAILING = new Inx_Api_GeneralMailing_MailingType(2);

            return self::$TIME_TRIGGER_MAILING;
    }

	/**
	 * The <i>SUBSCRIPTION_TRIGGER_MAILING</i> type is used for subscription and unsubscription trigger mailings,
	 * e.g. welcome and verification mailing.
	 */
    public static final function SUBSCRIPTION_TRIGGER_MAILING()
    {
            if(null === self::$SUBSCRIPTION_TRIGGER_MAILING)
                    self::$SUBSCRIPTION_TRIGGER_MAILING = new Inx_Api_GeneralMailing_MailingType(3);

            return self::$SUBSCRIPTION_TRIGGER_MAILING;
    }

	/**
	 * The <i>SPLIT_TEST_MAILING</i> type is used for split test mailings.
	 */
    public static final function SPLIT_TEST_MAILING()
    {
            if(null === self::$SPLIT_TEST_MAILING)
                    self::$SPLIT_TEST_MAILING = new Inx_Api_GeneralMailing_MailingType(4);

            return self::$SPLIT_TEST_MAILING;
    }

	/**
	 * The <i>SEQUENCE_MAILING</i> type is used for sequence mailings.
	 */
    public static final function SEQUENCE_MAILING()
    {
            if(null === self::$SEQUENCE_MAILING)
                    self::$SEQUENCE_MAILING = new Inx_Api_GeneralMailing_MailingType(5);

            return self::$SEQUENCE_MAILING;
    }

	/**
	 * The <i>UNKNOWN</i> type indicates a version mismatch between API and server.
	 */
    public static final function UNKNOWN()
    {
            if(null === self::$UNKNOWN)
                    self::$UNKNOWN = new Inx_Api_GeneralMailing_MailingType(-1);

            return self::$UNKNOWN;
    }

    private $id;

    private function __construct( $iId )
    {
            $this->id = $iId;
    }


	/**
	 * Returns the ID of the <i>Inx_Api_GeneralMailing_MailingType</i>.
	 * The ID is used for transmission purposes and should not be used inside client code.
	 *
	 * @return int the ID of the <i>Inx_Api_GeneralMailing_MailingType</i>.
	 */
    public function getId()
    {
            return $this->id;
    }


	/**
	 * Returns the <i>Inx_Api_GeneralMailing_MailingType</i> corresponding to the given $iId.
	 * If the ID is unknown, the <i>UNKNOWN</i> type will be returned.
	 * The ID is used for transmission purposes and should not be used inside client code.
	 *
	 * @param int $iId the ID of the <i>Inx_Api_GeneralMailing_MailingType</i> to retrieve.
	 * @return Inx_Api_GeneralMailing_MailingType the <i>Inx_Api_GeneralMailing_MailingType</i> corresponding to the given ID.
	 */
    public static function byId( $iId )
    {
            foreach( self::values() as $type )
            {
                    if( $type->getId() === $iId )
                            return $type;
            }

            return self::UNKNOWN();
    }

	/**
	 * Returns an array of <i>Inx_Api_GeneralMailing_MailingType</i> IDs corresponding to the given <i>Inx_Api_GeneralMailing_MailingType</i> array.
	 * The IDs are used for transmission purposes and should not be used inside client code.
	 *
	 * @param array $types an array of <i>Inx_Api_GeneralMailing_MailingType</i> to determine the IDs from
	 * @return array an array of <i>Inx_Api_GeneralMailing_MailingType</i> IDs
	 */
    public static function mailingTypeToIdArray( array $types = null )
	{
	    if( empty( $types ) )
		    return array();

	    $result = array();

	    for( $i = 0; $i < sizeof( $types ); $i++ )
	    {
		    $result[$i] = $types[$i]->getId();
	    }

	    return $result;
    }

    /**
     * Returns an array containing all available <i>Inx_Api_GeneralMailing_MailingType</i>s including UNKNOWN.
     * 
     * @return array an array containing all available <i>Inx_Api_GeneralMailing_MailingType</i>s including UNKNOWN.
     */
    public static function values()
    {
            return array(self::REGULAR_MAILING(), self::ACTION_MAILING(), self::TIME_TRIGGER_MAILING(),
                self::SUBSCRIPTION_TRIGGER_MAILING(), self::SPLIT_TEST_MAILING(), self::SEQUENCE_MAILING(),
                self::UNKNOWN());
    }
}
?>
