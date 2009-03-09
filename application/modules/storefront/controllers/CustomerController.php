<?php
/**
 * CustomerController
 * 
 * @category   Storefront
 * @package    Storefront_Controllers
 * @copyright  Copyright (c) 2008 Keith Pope (http://www.thepopeisdead.com)
 * @license    http://www.thepopeisdead.com/license.txt     New BSD License
 */
class Storefront_CustomerController extends Zend_Controller_Action 
{
    protected $_model;
    
    public function init()
    {
        // get the default model
        $this->_model = new Storefront_Model_User();
        
        // add forms
        $this->view->registerForm = $this->getRegistrationForm();
        $this->view->loginForm = $this->getLoginForm();
    }
    
	public function indexAction() 
	{}

	public function registerAction()
	{}
	
    public function postAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->_helper->redirector('register');
        }

        if (false === ($id = $this->_model->saveUser($request->getPost()))) {
            return $this->render('register');
        }
	}
	
	public function listAction()
	{
	    $this->view->users = $this->_model->getUsers();
	}
	
	public function loginAction()
	{}
	
	public function authenticateAction()
	{
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }

        // Validate
        $form = $this->_forms['login'];
        if (!$form->isValid($request->getPost())) {
            return $this->render('login');
        }
        
        $authService = new Storefront_Service_Authentication();
        if (false === $authService->authenticate($form->getValues())) {
            $form->setDescription('Login failed, please try again.');
            return $this->render('login');
        }
        
        $this->_helper->redirector('index');
	}
	
	public function logoutAction()
    {
        $authService = new Storefront_Service_Authentication();
        $authService->clear();
        $this->_helper->redirector('index');
    }
    
    public function getRegistrationForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        
        $this->_forms['register'] = $this->_model->getForm('register');
        $this->_forms['register']->setAction($urlHelper->url(array(
            'controller' => 'customer' , 
            'action' => 'post'
            ), 
            'default'
        ));
        $this->_forms['register']->setMethod('post');
        
        return $this->_forms['register'];
    }
    
    public function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        
        $this->_forms['login'] = $this->_model->getForm('login');
        $this->_forms['login']->setAction($urlHelper->url(array(
            'controller' => 'customer',
            'action'     => 'authenticate',
            ), 
            'default'
        ));
        $this->_forms['login']->setMethod('post');
        
        return $this->_forms['login'];
    }
}
