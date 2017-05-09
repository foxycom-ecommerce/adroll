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
namespace Foxycom\Adroll\Block\Product;

/**
 * Adroll data product view
 */
class Adroll extends \Magento\Catalog\Block\Product\View\AbstractView
{
	/**
	 * Adroll data
	 *
	 * @var \Foxycom\Adrol\Helper\Data
	 */
	protected $_adrollData = null;
	
	/**
	 * @param \Magento\Catalog\Block\Product\Context $context
	 * @param \Magento\Framework\Stdlib\ArrayUtils $arrayUtils
	 * @param \Foxycom\Adrol\Helper\Data $adrollData
	 * @param array $data
	 */
	public function __construct(
            \Magento\Catalog\Block\Product\Context $context,
            \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
			\Foxycom\Adroll\Helper\Data $adrollData,
			array $data = []
			) {
				$this->_adrollData = $adrollData;
				parent::__construct($context, $arrayUtils, $data);
	}
	/**
	 * Render adroll tracking scripts
	 *
	 * @return string
	 */
	protected function _toHtml()
	{
		if (!$this->_adrollData->isAdrollEnabled()) {
			return '';
		}
	
		return parent::_toHtml();
	}
	
	/**
	 * Render information on product page
	 * @return string|void
	 */
	public function getPdpCode()
	{
		$product = $this->getProduct();
		$result = sprintf(
					"adroll_custom_data = {'product_id':'%s', 'product_group':'%s'};",
					$product->getId(),
					$this->escapeJsQuote($this->_storeManager->getStore()->getFrontendName())
				);
		return $result;
	}
}