<?php
/**
 *  Magento Inxmail Module
 *
 *  @link http://flagbit.de
 *  @link https://www.inxmail.de/
 *  @author Flagbit GmbH
 *  @copyright Copyright © 2018 Inxmail GmbH
 *  @license Licensed under the Open Software License version 3.0 (https://opensource.org/licenses/OSL-3.0)
 */

/**
 * @category               Module Block
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          29/07/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Block_Adminhtml_System_Config_Form_Field_Universal_Select extends Mage_Core_Block_Html_Select {


    public function setInputName($value)
    {
        return $this->setName($value);
    }

}
