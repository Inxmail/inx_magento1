<?php

class Inx_Apiimpl_Action_CommandImpl_GrantTrackingPermissionCmd
    extends Inx_Apiimpl_Action_CommandImpl
    implements Inx_Api_Action_GrantTrackingPermissionCommand
{
	public function __construct( $mFirstParam )
	{
		if (is_object($mFirstParam)) {
            return parent::__construct($mFirstParam);
        }
        parent::__construct( Inx_Apiimpl_Action_CommandImpl::createCommandData());
        $this->_oCommandData = new stdClass;
        $this->_oCommandData->type = self::GRANT_TRACKING_PERMISSION_CMD_TYPE;
        $this->_oCommandData->keys = Inx_Apiimpl_TConvert::arrToTArr(array(self::ONE));
        $this->_oCommandData->values = Inx_Apiimpl_TConvert::arrToTArr(
            array(
                (string) $mFirstParam,
            )
        );
	}

    public function getListContextId()
    {
        return $this->getInteger( self::ONE );
    }

    public function toString()
    {
        return "GrantTrackingPermissionCommand - listContextId: " . $this->getInteger( self::ONE );
    }

    public function __toString()
    {
        return $this->toString();
    }
}