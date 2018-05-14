<?php
/**
 * @package Inxmail
 * @subpackage Transformation
 */
/**
 * This class defines a transformation.
 * Transformations are XSLT resources and used to convert datasource contents in another format or presentation.
 * 
 * <p>
 * You can update only the XSLT content of the transformation. Its name is not changable.
 * <p>
 * The following snippet shows how to create a transformation:
 * 
 * <pre>
 * $oTransformationManager = $oSession->getTransformationManager();
 * $oTransformation = $oTransformationManager->createTransformation( &quot;Name Of Transformation&quot; );
 * 
 * $sXslt = &quot;&lt;pseudo xslt&gt;&lt;transform&gt;&lt;something&gt;text text&lt;/something&gt;&lt;/transform&gt;&lt;/pseudo xslt&gt;&quot;;
 * 
 * $oTransformation->updateXSLT( $sXslt );
 * $oTransformation->commitUpdate();
 * </pre>
 * <p>
 * For an example on how to retrieve existing transformations, see the <i>In_Api_Transformation_TransformationManager</i> documentation.
 * 
 * @see In_Api_Transformation_TransformationManager
 * @since API 1.13.1
 * @author sveh, 16.06.2015
 * @package Inxmail
 * @subpackage Transformation
 */
interface Inx_Api_Transformation_Transformation extends Inx_Api_BusinessObject
{
	
	/**
	 * Constant for the xslt attribute. Used by the <i>Inx_Api_UpdateException</i> to indicate the error source.
	 *
	 * @see Inx_Api_UpdateException::getErrorSource()
	 */
	const ATTRIBUTE_XSLT = 0;
	
	
	/**
	 * Returns the name of the transformation resource
	 *
	 * @return string The name of the transformation resource
	 */
	public function getName();
	
	
	/**
	 * Returns the XSLT of the transformation resource
	 *
	 * @return string The XSLT of the transformation resource
	*/
	public function getXslt();
	
	
	/**
	 * Returns the date of creation for the transformation resource
	 *
	 * @return DateTime the date of creation of the transformation resource
	*/
	public function getCreationDatetime();
	
	
	/**
	 * Returns the date of last modification for the transformation resource
	 *
	 * @return DateTime the date of last modification of the transformation resource
	*/
	public function getModificationDatetime();
	
	
	/**
	 * Set the XSLT for this {@link Inx_Api_Transformation_Transformation} resource
	 *
	 * @param string xslt The XSLT of the {@link Inx_Api_Transformation_Transformation} resource
	 * @return the {@link Inx_Api_Transformation_Transformation} resource
	*/
	public function updateXslt( $sXslt );
}
