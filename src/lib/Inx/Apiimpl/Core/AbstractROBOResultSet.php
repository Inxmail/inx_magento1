<?php
abstract class Inx_Apiimpl_Core_AbstractROBOResultSet extends Inx_Apiimpl_RemoteObject 
    implements	Inx_Api_ROBOResultSet
{
	protected $_oBuffer = null;

	protected $_iLastAccessedIndex = -1;

	protected $_iSize;
        
        protected $_iPosition = 0;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, $sRemoteRefId, $iSize, $aFirstChunk )
	{
                $this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();
		parent::__construct( $oSc, $sRemoteRefId );                

		$this->_iSize = $iSize;
                
		if( !empty($aFirstChunk) )
			$this->_oBuffer->setBuffer( 0, $aFirstChunk );
	}


	protected abstract function fetchBOs( $iIndex, $iDirection );


	public function get( $iIndex )
	{
               if (!is_int($iIndex))
               {
                    throw new Inx_Api_IllegalArgumentException('Integer parameter $iIndex expected');
               }
            
		$this->check();
		if( $iIndex < 0 || $iIndex >= $this->_iSize )
                {
			throw new Inx_Api_IndexOutOfBoundsException( "illegal index: " . $iIndex . " / size: " . $this->_iSize );
                }
                
		try
		{
			$bo = $this->_oBuffer->getObject( $iIndex );
                        
			if( $bo != null )
                        {
				return $bo;
                        }
			else
                        {
				throw new Inx_Api_DataException( "ReadOnlyBusinessObject not found" );
                        }
		}
		catch( Inx_Apiimpl_Util_IndexException $x )
		{
			try
			{
				if( $iIndex >= $this->_iLastAccessedIndex )
				{
					$this->_oBuffer->setBuffer( $iIndex, 
                                                $this->fetchBOs( $iIndex, Inx_Apiimpl_Constants::FETCH_FORWARD_DIRECTION ) );
				}
				else
				{
					$data = $this->fetchBOs( $iIndex, Inx_Apiimpl_Constants::FETCH_BACKWARD_DIRECTION );
                                        $this->_oBuffer->setBuffer( $iIndex - count($data) + 1, $data );
				}
                                
				$this->_iLastAccessedIndex = $iIndex;
			}
			catch( Inx_Api_RemoteException $rx )
			{
				$this->_notify( $rx );
			}
			try
			{                            
				$bo = $this->_oBuffer->getObject( $iIndex );
                                
				if( $bo != null )
                                {
					return $bo;
                                }
				else
                                {
					throw new Inx_Api_DataException( "ReadOnlyBusinessObject not found" );
                                }
			}
			catch( Inx_Apiimpl_Util_IndexException $ix )
			{
				throw new Inx_Api_APIException( "implementation error in AbstractROBOResultSet", $ix );
			}
		}
	}


	public function size()
	{
		return $this->_iSize;
	}


	public function close()
	{
		$this->_release( false );
	}


	protected function check()
	{
		if( $this->_isReleased() )
			throw new Inx_Api_APIException( "result set is closed" );
	}


	public function rewind() 
        {
            $this->_iPosition = 0;
        }
        
        
        public function current() 
        {
            return $this->get($this->_iPosition);
        }
        
        
        public function key() 
        {
            return $this->_iPosition;
        }
        
        public function next() 
        {
            ++$this->_iPosition;
        }
        
        public function valid() 
        {
            return $this->_iPosition < $this->_iSize;
        }
}