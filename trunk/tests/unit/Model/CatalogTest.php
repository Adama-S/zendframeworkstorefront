<?php
/**
 * TestHelper
 */
require_once dirname(__FILE__) . '/../../TestHelper.php';

/**
 * Catalog Model
 */
require_once 'modules/storefront/models/Catalog.php';

/**
 * Test case for Storefront_Catalog
 * 
 * This test simply tests the interface between the model
 * and the resources that it uses. This ensures that our 
 * tests will run quickly and do not need to access things
 * like the database. Databases etc will be tested during the
 * integration tests.
 */
class CatalogTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SF_Model_Interface
     */
    protected $_model;
    
    protected function setUp()
    {        
        /**
         * Setup model and path for model resources
         */
        $this->_model = new Storefront_Model_Catalog(array(
            'path'   => dirname(__FILE__) . '/TestResources' ,
            'prefix' => 'Test'
            )
        );
    }
    
    protected function tearDown()
    {}
    
    public function test_Catalog_Get_Product_By_Id_Returns_Product_Item()
    {
        $p = $this->_model->getProductById(2);
        
        $this->assertEquals(2, $p->productId);
        $this->assertEquals('Product-2', $p->ident);

        $this->assertType('Storefront_Resource_Product_Item_Interface', $p);
    }
    
    public function test_Catalog_Get_Product_By_Ident_Returns_Product_Item()
    {
        $p = $this->_model->getProductByIdent('Product-3');
        
        $this->assertEquals(3, $p->productId);
        $this->assertEquals('Product-3', $p->ident);

        $this->assertType('Storefront_Resource_Product_Item_Interface', $p);
    }

    public function test_Catalog_Product_Item_Can_Get_Images()
    {
        $p = $this->_model->getProductById(1);
        $i = $p->getImages();
        
        $this->assertType('array', $i);
    }
    
    public function test_Catalog_Can_Get_Categories_By_parentId()
    {
        $cats= $this->_model->getCategories(0);
        
        $this->assertType('Zend_Db_Table_Rowset', $cats);
        $this->assertEquals(6, count($cats));
    }
    
    public function test_Catalog_Can_Get_Category_By_Ident()
    {
        $category = $this->_model->getCategoryByIdent('Category-5');
        
        $this->assertType('Storefront_Resource_Category_Item_Interface', $category);
        $this->assertEquals(5, $category->categoryId);
    }
    
    public function test_Catalog_Can_Get_Category_Parent()
    {
        $category = $this->_model->getCategoryByIdent('Category-8');
        $parent   = $this->_model->getParentCategory($category);

        $this->assertType('Storefront_Resource_Category_Item_Interface', $parent);
        $this->assertEquals(7, $parent->categoryId);
        
        $category = $this->_model->getCategoryByIdent('Category-1');
        $parent   = $this->_model->getParentCategory($category);
        
        $this->assertNull($parent);
        
    }
}