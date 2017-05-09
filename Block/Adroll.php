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

namespace Foxycom\Adroll\Block;

/**
 * Adroll Page Block
 */
class Adroll extends \Magento\Framework\View\Element\Template
{
    /**
     * Adroll data
     *
     * @var \Foxycom\Adrol\Helper\Data
     */
    protected $_adrollData = null;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_salesOrderCollection;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection
     * @param \Foxycom\Adrol\Helper\Data $adrollData
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection,
        \Foxycom\Adroll\Helper\Data $adrollData,
        array $data = []
    ) {
        $this->_adrollData = $adrollData;
        $this->_salesOrderCollection = $salesOrderCollection;
        parent::__construct($context, $data);
    }

    /**
     * Get config
     *
     * @param string $path
     * @return mixed
     */
    public function getConfig($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Render information about specified orders and their items
     * @return string|void
     */
    public function getSuccessPageCode()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }

        $collection = $this->_salesOrderCollection->create();
        $collection->addFieldToFilter('entity_id', ['in' => $orderIds]);
        $result = '';
        foreach ($collection as $order) {
        	$result = sprintf(
                "adroll_conversion_value = %s; adroll_currency = '%s'; adroll_custom_data = {'ORDER_ID': '%s', USER_ID:'%s'};",
        		$order->getGrandTotal(),
        		$order->getOrderCurrencyCode(),
        		$order->getIncrementId(),
        		$order->getCustomerEmail()
            );
        }
        
        return $result;
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
}
