<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * The <i>Inx_Api_Sending_SendingMailingType</i> enumeration defines the types of mailings which may be sent.
 *
 * @see Inx_Api_Sending_Sending::getType()
 * @since API 1.11.1
 * @author chge, 29.04.2013
 */
final class Inx_Api_Sending_SendingMailingType
{
    private static $MASS_MAILING = null;
    private static $SINGLE_MAILING = null;
    private static $TIME_TRIGGER_MAILING = null;
    private static $SEQUENCE_MAILING = null;
    private static $SPLIT_TEST_MAILING = null;
    private static $UNKNOWN = null;

    /**
     * The MASS_MAILING type is used for regular newsletter mailings.
     *
     * @return Inx_Api_Sending_SendingMailingType the MASS_MAILING type.
     */
    public static final function MASS_MAILING()
    {
        if (null === self::$MASS_MAILING)
            self::$MASS_MAILING = new Inx_Api_Sending_SendingMailingType(1);

        return self::$MASS_MAILING;
    }

    /**
     * The SINGLE_MAILING type is used for mailings which are sent to only one recipient, e.g. subscription and action
     * mailings.
     *
     * @return Inx_Api_Sending_SendingMailingType the SINGLE_MAILING type.
     */
    public static final function SINGLE_MAILING()
    {
        if (null === self::$SINGLE_MAILING)
            self::$SINGLE_MAILING = new Inx_Api_Sending_SendingMailingType(2);

        return self::$SINGLE_MAILING;
    }

    /**
     * The TIME_TRIGGER_MAILING type is used for time trigger mailings, e.g. birthday and interval mailing.
     *
     * @return Inx_Api_Sending_SendingMailingType the TIME_TRIGGER_MAILING type.
     */
    public static final function TIME_TRIGGER_MAILING()
    {
        if (null === self::$TIME_TRIGGER_MAILING)
            self::$TIME_TRIGGER_MAILING = new Inx_Api_Sending_SendingMailingType(3);

        return self::$TIME_TRIGGER_MAILING;
    }

    /**
     * The SEQUENCE_MAILING type is used for sequence mailings.
     *
     * @return Inx_Api_Sending_SendingMailingType the SEQUENCE_MAILING type.
     */
    public static final function SEQUENCE_MAILING()
    {
        if (null === self::$SEQUENCE_MAILING)
            self::$SEQUENCE_MAILING = new Inx_Api_Sending_SendingMailingType(4);

        return self::$SEQUENCE_MAILING;
    }

    /**
     * The SPLIT_TEST_MAILING type is used for split test mailings.
     *
     * @return Inx_Api_Sending_SendingMailingType the SPLIT_TEST_MAILING type.
     */
    public static final function SPLIT_TEST_MAILING()
    {
        if (null === self::$SPLIT_TEST_MAILING)
            self::$SPLIT_TEST_MAILING = new Inx_Api_Sending_SendingMailingType(5);

        return self::$SPLIT_TEST_MAILING;
    }

    /**
     * The UNKNOWN type indicates a version mismatch between API and server.
     *
     * @return Inx_Api_Sending_SendingMailingType the UNKNOWN type.
     */
    public static final function UNKNOWN()
    {
        if (null === self::$UNKNOWN)
            self::$UNKNOWN = new Inx_Api_Sending_SendingMailingType(-1);

        return self::$UNKNOWN;
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }

    /**
     * Returns the ID of the <i>SendingMailingTypeicode>. The ID is used for transmission purposes and should not be
     * used inside client code.
     *
     * @return int the ID of the <i>SendingMailingType</i>.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the <i>SendingMailingType</i> corresponding to the given id. If the id is unknown, the
     * <i>UNKNOWN</i> type will be returned. The ID is used for transmission purposes and should not be used
     * inside client code.
     *
     * @param int $iId the ID of the <i>SendingMailingType</i> to retrieve.
     * @return Inx_Api_Sending_SendingMailingType the <i>SendingMailingType</i> corresponding to the given ID.
     */
    public static function byId($iId)
    {
        foreach (self::values() as $type)
        {
            if ($type->getId() === $iId)
                return $type;
        }

        return self::UNKNOWN();
    }

    /**
     * Returns all valid <i>SendingMailingType</i>s.
     *
     * @return array All valid <i>SendingMailingType</i>s.
     */
    public static function values()
    {
        return array(self::MASS_MAILING(), self::SINGLE_MAILING(), self::TIME_TRIGGER_MAILING(),
            self::SEQUENCE_MAILING(), self::SPLIT_TEST_MAILING(), self::UNKNOWN());
    }
}
