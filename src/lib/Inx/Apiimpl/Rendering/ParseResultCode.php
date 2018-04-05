<?php

final class Inx_Apiimpl_Rendering_ParseResultCode
{
    private static $PARSE_SUCCESSFUL = null;
    private static $PARSE_EXCEPTION = null;
    private static $MAILING_NOT_FOUND = null;
    private static $SENDING_NOT_FOUND = null;
    private static $SENDING_NOT_APPLICABLE = null;
    private static $UNKNOWN = null;

    public static final function PARSE_SUCCESSFUL()
    {
        if (self::$PARSE_SUCCESSFUL === null)
            self::$PARSE_SUCCESSFUL = new Inx_Apiimpl_Rendering_ParseResultCode(1);

        return self::$PARSE_SUCCESSFUL;
    }

    public static final function PARSE_EXCEPTION()
    {
        if (self::$PARSE_EXCEPTION === null)
            self::$PARSE_EXCEPTION = new Inx_Apiimpl_Rendering_ParseResultCode(2);

        return self::$PARSE_EXCEPTION;
    }

    public static final function MAILING_NOT_FOUND()
    {
        if (self::$MAILING_NOT_FOUND === null)
            self::$MAILING_NOT_FOUND = new Inx_Apiimpl_Rendering_ParseResultCode(3);

        return self::$MAILING_NOT_FOUND;
    }

    public static final function SENDING_NOT_FOUND()
    {
        if (self::$SENDING_NOT_FOUND === null)
            self::$SENDING_NOT_FOUND = new Inx_Apiimpl_Rendering_ParseResultCode(4);

        return self::$SENDING_NOT_FOUND;
    }

    public static final function SENDING_NOT_APPLICABLE()
    {
        if (self::$SENDING_NOT_APPLICABLE === null)
            self::$SENDING_NOT_APPLICABLE = new Inx_Apiimpl_Rendering_ParseResultCode(5);

        return self::$SENDING_NOT_APPLICABLE;
    }

    public static final function UNKNOWN()
    {
        if (self::$UNKNOWN === null)
            self::$UNKNOWN = new Inx_Apiimpl_Rendering_ParseResultCode(-1);

        return self::$UNKNOWN;
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function byId($iId)
    {
        foreach (self::values() as $value)
        {
            if ($value->getId() === $iId)
                return $value;
        }

        return self::UNKNOWN();
    }

    public static function values()
    {
        return array(self::PARSE_SUCCESSFUL(), self::PARSE_EXCEPTION(), self::MAILING_NOT_FOUND(),
            self::SENDING_NOT_FOUND(), self::SENDING_NOT_APPLICABLE(), self::UNKNOWN());
    }
}
