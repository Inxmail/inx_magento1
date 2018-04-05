<?php

class Inx_Apiimpl_Transformation_TransformationManagerImpl implements Inx_Api_Transformation_TransformationManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
    /**
     * @var Inx_Apiimpl_AbstractSession
     */
    private $session;
    
    /**
     * TransformationService
     */
    private $service;
    
    public function __construct( Inx_Apiimpl_AbstractSession $session )
    {
        $this->session = $session;
        $this->service = $session->getService( Inx_Apiimpl_SessionContext::TRANSFORMATION_SERVICE );
    }
    
    /**
     * 
     * @param string $sName
     * @return Inx_Apiimpl_Transformation_TransformationImpl
     */
    public function createTransformation($sName) {
        $transformationData = new Inx_Apiimpl_Transformation_TransformationData();
        $transformationData->setName( $sName );
        
        $transformation = new Inx_Apiimpl_Transformation_TransformationImpl( $this->session, $transformationData);
        return $transformation;
    }

    /**
     * @param int $iId
     * @return Inx_Apiimpl_Transformation_TransformationImpl
     * @throws Inx_Api_DataException
     */
    public function get($iId)
    {
        if (!is_int($iId))
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected');
        
        try
        {
            /* @var $data stdClass */
            $data = $this->service->get( $this->session->createCxt(), $iId );
            
            if( $data === null )
                throw new Inx_Api_DataException( "No transformation found for id: ".$iId );
            
            /* @var $oData Inx_Apiimpl_Transformation_TransformationData */
            $oData = Inx_Apiimpl_Transformation_TransformationData::convertStdClassToTransformationData($data);
            
            return new Inx_Apiimpl_Transformation_TransformationImpl( $this->session, $oData );
        } 
        catch (Inx_Api_RemoteException $x)
        {
            $this->session->notify( $x );
            return null;
        }
    }

    /**
     * @return Inx_Apiimpl_Core_DelegateBOResultSet
     */
    public function selectAll() {
        try
        {
            $rs = $this->service->selectAll( $this->session->createCxt() );
            
            return new Inx_Apiimpl_Core_DelegateBOResultSet(
                    $this->session, 
                    $this, 
                    $rs->remoteRefId, 
                    $rs->size, 
                    Inx_Apiimpl_Transformation_TransformationImpl::convertArray(
                            $this->session, 
                            $rs->data
                            )
                    );
        }
        catch (Inx_Api_RemoteException $x)
        {
            $this->session->notify($x);
            return null;
        }
    }
    
    public function fetchBOs(Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection) {
        return Inx_Apiimpl_Transformation_TransformationImpl::convertArray(
                $oResultSetRef, 
                $this->service->fetch( 
                        $oResultSetRef->createCxt(), 
                        $oResultSetRef->refId(), 
                        $iIndex, 
                        $iDirection
                        )
                );
    }
    
    /**
     * @param int $iId
     * @throws Inx_Api_NotImplementedException
     */
    public function remove($iId) {
        // TODO As requested in XPTA-669 only update() should be implemented first
        throw new Inx_Api_NotImplementedException( "the objects does not support this method yet" );
    }

    /**
     * @param Inx_Apiimpl_RemoteRef $oResultSetRef
     * @param int[] $aIndexRanges
     * @throws Inx_Api_NotImplementedException
     */
    public function removeBOs(Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges) {
        // TODO As requested in XPTA-669 only update() should be implemented first
        throw new Inx_Api_NotImplementedException( "the objects does not support this method yet" );
    }

}