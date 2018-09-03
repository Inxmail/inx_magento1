<?php

class Inx_Apiimpl_Action_CommandImpl_TransferTrackingPermissionCmd
    extends Inx_Apiimpl_Action_CommandImpl
    implements Inx_Api_Action_TransferTrackingPermissionCommand
{
	public function __construct( $iTargetListId, $iSourceListId = null )
	{
		if (is_object($iTargetListId)) {
            return parent::__construct($iTargetListId);
        }
        parent::__construct( Inx_Apiimpl_Action_CommandImpl::createCommandData());
        $this->_oCommandData = new stdClass;
        $this->_oCommandData->type = self::TRANSFER_TRACKING_PERMISSION_CMD_TYPE;
        $this->_oCommandData->keys = Inx_Apiimpl_TConvert::arrToTArr(array(self::ONE, self::TWO, self::THREE));

        if(is_null($iSourceListId)){
            $this->_oCommandData->values = Inx_Apiimpl_TConvert::arrToTArr(
            array(
                (string) $iTargetListId,
                 '1',
                null
            )
        );
        }else{
          $this->_oCommandData->values = Inx_Apiimpl_TConvert::arrToTArr(
                    array(
                        (string) $iTargetListId,
                        '0',
                        (string) $iSourceListId
                    )
                );
        }


	}

    public function getTargetListId()
    {
        return $this->getInteger( self::ONE );
    }

    public function getSourceListId()
    {
        return $this->getInteger( self::THREE );
    }

    public function isUseEventSource()
    {
        $bool = $this->getInteger( self::TWO );
        if( $bool==null )
            return false;

        return $bool == 1;
    }

    public function toString()
    {
        return "TransferTrackingPermissionCommand - listContextId: " . $this->getInteger( self::ONE )
            . ", useEventSource: " . $this->getInteger( self::TWO )
            . ", sourceListId: " . $this->getInteger( self::THREE );
    }

    public function __toString()
    {
        return $this->toString();
    }
}