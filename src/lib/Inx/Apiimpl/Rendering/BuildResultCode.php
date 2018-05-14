<?php

final class Inx_Apiimpl_Rendering_BuildResultCode
{
    private static $BUILD_SUCCESSFUL = null;
    private static $BUILD_EXCEPTION = null;
    private static $UNKNOWN = null;

    public static final function BUILD_SUCCESSFUL()
    {
        if (self::$BUILD_SUCCESSFUL === null)
            self::$BUILD_SUCCESSFUL = new Inx_Apiimpl_Rendering_BuildResultCode(1);

        return self::$BUILD_SUCCESSFUL;
    }

    public static final function BUILD_EXCEPTION()
    {
        if (self::$BUILD_EXCEPTION === null)
            self::$BUILD_EXCEPTION = new Inx_Apiimpl_Rendering_BuildResultCode(2);

        return self::$BUILD_EXCEPTION;
    }

    public static final function UNKNOWN()
    {
        if (self::$UNKNOWN === null)
            self::$UNKNOWN = new Inx_Apiimpl_Rendering_BuildResultCode(-1);

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
        return array(self::BUILD_SUCCESSFUL(), self::BUILD_EXCEPTION(), self::UNKNOWN());
    }
}
