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

namespace Foxycom\Adroll\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Adroll module observer
 *
 */
class SuccessPageViewObserver implements ObserverInterface
{
    /**
     * Adroll data
     *
     * @var \Foxycom\Adroll\Helper\Data
     */
    protected $_adrollData = null;

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    
    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\LayoutInterface $layout
     * @param \Foxycom\Adroll\Helper\Data $adrollData
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Foxycom\Adroll\Helper\Data $adrollData
    ) {
        $this->_adrollData = $adrollData;
        $this->_layout = $layout;
        $this->_storeManager = $storeManager;
    }

    /**
     * Add order information into GA block to render on checkout success pages
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
    	if (!$this->_adrollData->isAdrollEnabled()) {
    		return $this;
    	}
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = $this->_layout->getBlock('adroll_tracking');
        if ($block) {
            $block->setOrderIds($orderIds);
        }
    }
}