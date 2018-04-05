<?php

final class Inx_Apiimpl_Rendering_RendererState
{
    private static $NOT_INITIALIZED = null;
    private static $PARSE_FAILED = null;
    private static $PARSED = null;

    public static final function NOT_INITIALIZED()
    {
        if (self::$NOT_INITIALIZED === null)
            self::$NOT_INITIALIZED = new Inx_Apiimpl_Rendering_RendererState(1);

        return self::$NOT_INITIALIZED;
    }

    public static final function PARSE_FAILED()
    {
        if (self::$PARSE_FAILED === null)
            self::$PARSE_FAILED = new Inx_Apiimpl_Rendering_RendererState(2);

        return self::$PARSE_FAILED;
    }

    public static final function PARSED()
    {
        if (self::$PARSED === null)
            self::$PARSED = new Inx_Apiimpl_Rendering_RendererState(3);

        return self::$PARSED;
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }
}
