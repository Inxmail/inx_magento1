<?php

/**
 * @package Inxmail
 * @subpackage Transformation
 */
/**
 * The <i>Inx_Api_Transformation_TransformationManager</i> can be used to retrieve and create transformations. 
 * Transformations are XSLT resources and used to convert datasource contents in another format or presentation.
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
 * 
 * </p>
 * To retrieve existing transformations, use the <i>selectAll()</i> or <i>get(int)</i> methods provided by this manager. 
 * The following snippet shows how to retrieve all transformations, ordered by their id, and prints out some
 * information regarding these transformations:
 * 
 * <pre>
 * $oTransformationManager = $oSession->getTransformationManager();
 * $oBOResultSet = $oTransformationManager->selectAll();
 * 
 * for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
 * {
 * 	$oTransformation = $oBOResultSet->get( $i );
 * 	echo &quot;Transformation &quot;.$oTransformation->getName().&quot; has the xslt content &quot;.$oTransformation->getXslt().&quot;&#60;br&#62;&quot;;
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * <p>
 * For more information on transformations, see the <i>Inx_Api_Transformation_Transformation</i> documentation.
 * 
 * @see Inx_Api_Transformation_Transformation
 * @since API 1.13.1
 * @author sveh, 16.06.2015
 * @package Inxmail
 * @subpackage Transformation
 */
interface Inx_Api_Transformation_TransformationManager extends Inx_Api_BOManager
{

	/**
	 * Creates a new transformation.  
	 * 
	 * @param string $sName the name of the transformation
	 * @return Inx_Api_Transformation_Transformation a new transformation.
	 */
	public function createTransformation( $sName );

}
