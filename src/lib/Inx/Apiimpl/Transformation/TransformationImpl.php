<?php
/**
 * @author sveh
 *
 */

class Inx_Apiimpl_Transformation_TransformationImpl implements Inx_Api_Transformation_Transformation
{
    /**
     * @var Inx_Apiimpl_SessionContext
     */
    private $oSession;
    
    /**
     * @var Inx_Apiimpl_Transformation_TransformationData
     */
    private $oData;
    
    /**
     * TransformationService
     */
    private $oService;
    
    /**
     * @var int[]
     */
    private $aChangeAttrs;
    
    
    
    /**
     * @param int $iAttributeIndex
     */
    private function writeAccess( $iAttributeIndex )
    {
        if( $this->aChangeAttrs === null )
            $this->aChangeAttrs = Inx_Apiimpl_TConvert::fixSizeArray( Inx_Apiimpl_Transformation_TransformationConstants::MAX_ATTRIBUTES );
        
        if( $iAttributeIndex < Inx_Apiimpl_Transformation_TransformationConstants::MAX_ATTRIBUTES )
            $this->aChangeAttrs[ $iAttributeIndex ] = true;
    }
    
    /**
     * 
     * @param Inx_Apiimpl_SessionContext $oSession
     * @param stdClass $data
     * @return Inx_Apiimpl_Transformation_TransformationImpl
     */
    public static function convert( Inx_Apiimpl_SessionContext $oSession, stdClass $data )
    {
        if( $data === null )
            return null;
        
        $oData = Inx_Apiimpl_Transformation_TransformationData::convertStdClassToTransformationData($data);
        
        return new Inx_Apiimpl_Transformation_TransformationImpl( $oSession, $oData );
    }
    
    /**
     * 
     * @param Inx_Apiimpl_SessionContext $oSession
     * @param stdClass[] $aData
     * @return Inx_Apiimpl_Transformation_TransformationImpl[]
     */
    public static function convertArray( Inx_Apiimpl_SessionContext $oSession, array $aData )
    {
        if( empty( $aData ) )
            return array();
        
        $aResultData = array();
        
        for( $i=0; $i<count($aData); $i++ )
        {
            if( $aData[$i] !== null )
            {
                $oData = Inx_Apiimpl_Transformation_TransformationData::convertStdClassToTransformationData( $aData[$i] );
                $aResultData[$i] = new Inx_Apiimpl_Transformation_TransformationImpl( $oSession, $oData );
            }
        }
        
        return $aResultData;
    }
    
    /**
     * 
     * @param Inx_Apiimpl_SessionContext $sc
     * @param Inx_Apiimpl_Transformation_TransformationData $oTransformationData
     */
    public function __construct( Inx_Apiimpl_SessionContext $sc, Inx_Apiimpl_Transformation_TransformationData $oTransformationData )
    {        
        $this->oSession = $sc;
        $this->oService = $sc->getService( Inx_Apiimpl_SessionContext::TRANSFORMATION_SERVICE );
        
        if( $oTransformationData instanceof Inx_Apiimpl_Transformation_TransformationData )
            $this->oData = $oTransformationData;
        else
            $this->oData = Inx_Apiimpl_Transformation_TransformationData::convertStdClassToTransformationData ($oTransformationData);
    }
    
    /**
     * 
     * @return int
     */
    public function getId() {
        return $this->oData->getId();
    }
    
    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->oData->getName();
    }
    
    /**
     * 
     * @return string
     */
    public function getXslt() {
        return $this->oData->getXslt();
    }
    
    /**
     * 
     * @return DateTime
     */
    public function getCreationDatetime() {
        return $this->oData->getCreationDatetime();
    }

    /**
     * 
     * @return DateTime
     */
    public function getModificationDatetime() {
        return $this->oData->getModificationDatetime();
    }

    

    public function reload() {
        try
        {
            /* @var $reloadData Inx_Apiimpl_Transformation_TransformationData */
            $reloadData = $this->oService->get( $this->oSession->createCxt(), $this->oData->getId() );
            $this->aChangeAttrs = null;

            if( $reloadData !== null )
                $this->oData = $reloadData;
            else
                throw new Inx_Api_DataException( "transformation has been deleted" );
        }
        catch ( Inx_Api_RemoteException $x )
        {
            $this->oSession->notify( $x );
        }
    }

    /**
     * 
     * @param string $sXslt
     * @return Inx_Apiimpl_Transformation_TransformationImpl
     */
    public function updateXslt($sXslt) {
        $this->writeAccess( Inx_Api_Transformation_Transformation::ATTRIBUTE_XSLT );        
        $this->oData->setXslt( $sXslt );
        return $this;
    }
    
    /**
     * Persists the updates on the {@link Inx_Apiimpl_Transformation_TransformationImpl} object.
     * 
     * @throws Inx_Api_UpdateException
     * @throws Inx_Api_DataException
     */
    public function commitUpdate() {        
        if( $this->oData === null )
            throw new Inx_Api_UpdateException( "transformation is null", Inx_Api_UpdateException::ERROR_TYPE_ILLEGAL_VALUE, Inx_Api_UpdateException::ERROR_SOURCE_NOT_SPECIFIED);
            
        if( $this->oData->getName() === null || empty( $this->oData->getName() ) )
            throw new Inx_Api_UpdateException( "transformation name is null or empty", Inx_Api_UpdateException::ERROR_TYPE_ILLEGAL_VALUE, Inx_Api_UpdateException::ERROR_SOURCE_NOT_SPECIFIED);;
        
        if( $this->oData->getXslt() === null )
            throw new Inx_Api_DataException( "transformation xslt is null" );
        
        if( $this->oData->getModificationDatetime() === null )
        {
            $dateTime = new DateTime();
            $dateTime->setTimezone( new DateTimeZone("Z"));
            $this->oData->setModificationDatetime( $dateTime );
        }
        
        try
        {
            $data = Inx_Apiimpl_Transformation_TransformationData::convertTransformationDataToStdClass($this->oData);
            
            /* @var $transformationDataHolder stdClass */
            $transformationDataHolder = $this->oService->update( $this->oSession->createCxt(), $data, Inx_Apiimpl_TConvert::arrToTArr( $this->aChangeAttrs ) );

            if( $transformationDataHolder->excDesc !== null )
                throw new Inx_Api_UpdateException( $transformationDataHolder->excDesc->msg, $transformationDataHolder->excDesc->type, $transformationDataHolder->excDesc->source );
            
            $this->oData = Inx_Apiimpl_Transformation_TransformationData::convertStdClassToTransformationData( $transformationDataHolder->value );
            $this->aChangeAttrs = null;
            
            if( $this->oData === null )
                throw new Inx_Api_DataException( "transformation is deleted" );
        }
        catch( Inx_Apiimpl_SoapException $se )
        {
            throw new Inx_Api_UpdateException( $se->getMessage(), $se->getCode(), $se->oReturnObj->excDesc->source );
	}
        catch( Inx_Api_RemoteException $x )
        {
            $this->oSession->notify( $x );
	}
    }

}