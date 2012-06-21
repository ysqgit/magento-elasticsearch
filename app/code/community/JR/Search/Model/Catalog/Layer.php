<?php
/**
 * Overrides default layer model to handle custom product collection filtering.
 *
 * @package JR_Search
 * @subpackage JR_Search_Model
 * @author Johann Reinke <johann.reinke@gmail.com>
 */
class JR_Search_Model_Catalog_Layer extends Mage_Catalog_Model_Layer
{
    /**
     * Returns product collection for current category.
     *
     * @return JR_Search_Model_Resource_Catalog_Product_Collection
     */
    public function getProductCollection()
    {
        /** @var $category Mage_Catalog_Model_Category */
        $category = $this->getCurrentCategory();
        /** @var $collection JR_Search_Model_Resource_Catalog_Product_Collection */
        if (isset($this->_productCollections[$category->getId()])) {
            $collection = $this->_productCollections[$category->getId()];
        } else {
            $collection = Mage::helper('catalogsearch')
                ->getEngine()
                ->getResultCollection()
                ->setStoreId($category->getStoreId())
                ->addFqFilter(array('store_id' => $category->getStoreId()));
            $this->prepareProductCollection($collection);
            $this->_productCollections[$category->getId()] = $collection;
        }

        return $collection;
    }
}
