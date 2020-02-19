<?php
namespace Magenest\Chapter9\Plugin\Order\View\Items;

class Add{
	public function afterGetColumnHtml(\Magento\Framework\DataObject $subject, $html,$item,$column){
		switch ($column){
			case 'message':
				$html = $item->getProductOptionByCode('info_buyRequest')['messages'];
				break;
		}
		return $html;
	}
}
