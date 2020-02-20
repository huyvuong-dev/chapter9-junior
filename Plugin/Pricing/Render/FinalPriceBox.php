<?php

namespace Magenest\Chapter9\Plugin\Pricing\Render;

use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Framework\Pricing\SaleableInterface;
use Magento\Framework\View\Element\Template\Context;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
	protected $_scopeConfig;

	protected $_httpContext;

	public function __construct(
		Context $context,
		SaleableInterface $saleableItem,
		PriceInterface $price,
		RendererPool $rendererPool,
		array $data = [],
		SalableResolverInterface $salableResolver = null,
		MinimalPriceCalculatorInterface $minimalPriceCalculator = null,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Framework\App\Http\Context $httpContext
	)
	{
		$this->_scopeConfig = $scopeConfig;
		$this->_httpContext = $httpContext;
		parent::__construct($context, $saleableItem, $price, $rendererPool, $data, $salableResolver, $minimalPriceCalculator);
	}

	protected function wrapResult($html)
	{
		$isLoggedIn = $this->_httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
		$config = (boolean) $this->_scopeConfig->getValue('chapter9/general/hidePrice', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		if(!$isLoggedIn && $config){
			return '<div class="" ' .
				'data-role="priceBox" ' .
				'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
				'><strong>'.__('Login to see price').'</strong></div>';
		}else{
			return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
				'data-role="priceBox" ' .
				'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
				'>' . $html . '</div>';
		}
	}
}