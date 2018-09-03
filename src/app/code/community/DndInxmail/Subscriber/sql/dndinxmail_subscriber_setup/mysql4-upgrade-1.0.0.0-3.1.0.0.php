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
 * @category               Module SQL setup
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('newsletter/subscriber'), "email_bounced", "SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0'");

$installer->endSetup();
