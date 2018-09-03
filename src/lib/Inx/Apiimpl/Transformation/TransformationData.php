<?php

/**
 * Description of TransformationData
 *
 * @author sveh, 16.06.2015
 */
class Inx_Apiimpl_Transformation_TransformationData
{
    /**
     *
     * @var int
     */
    private $id;
    
    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @var string
     */
    private $xslt;
    
    /**
     *
     * @var DateTime
     */
    private $creationDatetime;
    
    /**
     *
     * @var DateTime
     */
    private $modificationDatetime;
    
    
    
    
    /**
     * 
     * @return int
     */
    function getId() {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * 
     * @return string
     */
    function getXslt() {
        return $this->xslt;
    }

    /**
     * 
     * @return DateTime
     */
    function getCreationDatetime() {
        return $this->creationDatetime;
    }

    /**
     * 
     * @return DateTime
     */
    function getModificationDatetime() {
        return $this->modificationDatetime;
    }

    /**
     * 
     * @param int $id
     * @return Inx_Apiimpl_Transformation_TransformationData
     */
    function setId($id) {
        $this->id = $id;
        
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return Inx_Apiimpl_Transformation_TransformationData
     */
    function setName($name) {
        $this->name = $name;
        
        return $this;
    }

    /**
     * 
     * @param string $xslt
     * @return Inx_Apiimpl_Transformation_TransformationData
     */
    function setXslt($xslt) {
        $this->xslt = $xslt;
        
        return $this;
    }

    /**
     * 
     * @param DateTime $creationDatetime
     * @return Inx_Apiimpl_Transformation_TransformationData
     */
    function setCreationDatetime(DateTime $creationDatetime) {
        $this->creationDatetime = $creationDatetime;
        
        return $this;
    }

    /**
     * 
     * @param DateTime $modificationDatetime
     * @return Inx_Apiimpl_Transformation_TransformationData
     */
    function setModificationDatetime(DateTime $modificationDatetime) {
        $this->modificationDatetime = $modificationDatetime;
        
        return $this;
    }
    
    /**
     * Converts a StdClass to {@link Inx_Apiimpl_Transformation_TransformationData}.
     * 
     * The SOAP-Client will produce a StdClass as response.
     * 
     * @param stdClass $data
     * @return Inx_Apiimpl_Transformation_TransformationData|null
     */
    public static function convertStdClassToTransformationData( stdClass $data )
    {        
        $oData = new Inx_Apiimpl_Transformation_TransformationData();
        
        if( !isset( $data->id ) || 
            !isset( $data->name ) || 
            !isset( $data->xslt ) || 
            !isset( $data->modificationDatetime ) )
            return null;
        
        if( $data->id !== null )
            $oData->setId( $data->id );
        
        if( $data->name !== null )
            $oData->setName( $data->name );
        
        if( $data->xslt !== null )
            $oData->setXslt( $data->xslt );
        
        if( $data->creationDatetime !== null && $data->creationDatetime->value !== null )
        {
            $dateTime = Inx_Apiimpl_TConvert::stringToDateTime( $data->creationDatetime->value );
            $oData->setCreationDatetime( $dateTime );
        }
        
        if( $data->modificationDatetime !== null && $data->modificationDatetime->value !== null )
        {
            $dateTime = Inx_Apiimpl_TConvert::stringToDateTime( $data->modificationDatetime->value );
            $oData->setModificationDatetime( $dateTime );
        }
        
        return $oData;
    }
    
    /**
     * Converts a {@link Inx_Apiimpl_Transformation_TransformationData} to StdClass.
     * 
     * The SOAP-Client need to get a StdClass to handle it.
     * 
     * @param Inx_Apiimpl_Transformation_TransformationData $oData
     * @return stdClass
     */
    public static function convertTransformationDataToStdClass( Inx_Apiimpl_Transformation_TransformationData $oData )
    {        
        $data = new stdClass();
        
        $data->id = $oData->getId();
        $data->name = $oData->getName();
        $data->xslt = $oData->getXslt();
        
        if( $oData->getCreationDatetime() !== null )
        {
            $data->creationDatetime = new stdClass();
            $data->creationDatetime->value = Inx_Apiimpl_TConvert::DateTimeToString( $oData->getCreationDatetime() );
        }
        if( $oData->getModificationDatetime() !== null )
        {
            $data->modificationDatetime = new stdClass();
            $data->modificationDatetime->value = Inx_Apiimpl_TConvert::DateTimeToString( $oData->getModificationDatetime() );
        }
        
        return $data;
    }


}
