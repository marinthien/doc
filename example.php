<?php
use Magento\Framework\App\Bootstrap;
require __DIR__.'/app/bootstrap.php';

$params = $_SERVER;
$params[Bootstrap::PARAM_REQUIRE_MAINTENANCE] = true; // default false
$params[Bootstrap::PARAM_REQUIRE_IS_INSTALLED] = false; // default true
//var_dump($params);

try{

  $bootstrap = Bootstrap::create(BP, $params);
  /** @var \Magento\Framework\App\Http $app */

   //var_dump($bootstrap);
    $app = $bootstrap->createApplication('Magento\Framework\App\Http');

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $objectManager->get('Magento\Framework\App\State')->setAreaCode('frontend');


    $orderDatamodel = $objectManager->get('Magento\Sales\Model\Order')->getCollection();
    //$product = $objectManager->get('catalog\product')->getCollection();

    ///var_dump($product);

    $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');

    $collection = $productCollection->create()
                ->addAttributeToSelect('*')
                ->load();

    foreach ($collection as $product){
         echo 'Name  =  '.$product->getName().'<br>';
    }


    foreach($orderDatamodel as $orderDatamodel1){
    $getid =  $orderDatamodel1->getData("increment_id");
        $orderData = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($getid);
         //echo "<pre>";
         $getorderdata = $orderData->getData();
         $orderItems = $orderData->getAllVisibleItems();
         foreach($orderItems as $orderItems){
                   print_r($orderItems->getData());
       }
    }


  //$bootstrap->run($app);
}catch(Exception $e){


  // https://www.mageplaza.com/how-get-product-collection-magento-2.html
  // \Magento\Catalog\Model\ResourceModel\Product


}
