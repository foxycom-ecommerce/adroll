<?php
/**
 * Foxycom - eCommerce solutions
 *
 * Adroll
 *
 * @author    Foxycom <support@foxycom.com>
 * @package   Foxycom_Adroll
 * @copyright Copyright (c) 2017 Foxycom (https://foxycom.com)
 * @license   https://foxycom.com/license/osl-30
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Foxycom\Adroll\Test\Integration;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\ObjectManager;

class AdrollModuleConfigTest extends \PHPUnit_Framework_TestCase
{
	private $_moduleName = 'Foxycom_Adroll';
	
    public function testTheModuleIsRegistered()
    {
        $registrar = new ComponentRegistrar();
        $this->assertArrayHasKey($this->_moduleName, $registrar->getPaths(ComponentRegistrar::MODULE));
    }

    public function testTheModuleIsConfiguredAndEnabledInRealEnv()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = ObjectManager::getInstance();

        $directoryList = $objectManager->create(DirectoryList::class, ['root' => BP]);
        $reader = $objectManager->create(DeploymentConfig\Reader::class, ['dirList' => $directoryList]);
        $deploymentConfig = $objectManager->create(DeploymentConfig::class, ['reader' => $reader]);

        /** @var ModuleList $moduleList */
        $moduleList = $objectManager->create(ModuleList::class, ['config' => $deploymentConfig]);

        $this->assertTrue($moduleList->has($this->_moduleName), 'The module is enabled in real env.');
    }
}