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

// @codingStandardsIgnoreFile

namespace Foxycom\Adroll\Helper;

use Magento\Store\Model\Store;

/**
 * Adroll data helper
 *
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Config paths for using throughout the code
     */
    const XML_PATH_ACTIVE = 'foxycom/adroll/enabled';

    const XML_PATH_ADV_ID = 'foxycom/adroll/adroll_adv';

    const XML_PATH_PIX_ID = 'foxycom/adroll/adroll_pix';
    
    /**
     * Whether Adroll is ready to use
     *
     * @param null|string|bool|int|Store $store
     * @return bool
     */
    public function isAdrollEnabled($store = null)
    {
        $advId = $this->scopeConfig->getValue(self::XML_PATH_ADV_ID, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
        $pixId = $this->scopeConfig->getValue(self::XML_PATH_PIX_ID, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
        return $advId && $pixId && $this->scopeConfig->isSetFlag(self::XML_PATH_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }
}