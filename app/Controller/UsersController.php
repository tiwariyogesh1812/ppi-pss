<?php
App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {
 
    var $name = 'Users';
    var $uses = array('User');
    var $helpers = array('Html', 'Form', 'Captcha');
    var $components = array('Captcha'=>array('field'=>'security_code'));//'Captcha'
    
    public $paginate = array(
        'limit' => 1,
        'conditions' => array('status' => '1'),
        'order' => array('User.username' => 'asc' ) 
    );
     
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','add','captcha'); 
    }
     
    public function captcha()	{
        $this->autoRender = false;
        $this->layout='ajax';
        if(!isset($this->Captcha))	{ //if you didn't load in the header
            $this->Captcha = $this->Components->load('Captcha'); //load it
        }
        $this->Captcha->create();
    }
 
    public function login() {
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('action' => 'index'));      
        }
         
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
             
            if ($this->Auth->login()) {
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')));
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password'));
            }
        } 
    }
 
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
 
    public function index() {
        $this->paginate = array(
            'limit' => 10,
            'order' => array('User.id' => 'asc' )
        );
        $users = $this->paginate('User');
        //echo '<pre>'; print_r($users); exit;
        $this->set(compact('users'));
    }
 
 
    public function add() {
        
         //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
           $this->set('loggeduser',$this->Auth->user('email'));
        }
         
        if ($this->Auth->login()) {
            $this->set('loggeduser',$this->Auth->user('email'));
        } else {
            $this->set('loggeduser','');
        }

        
        if ($this->request->is('post')) {
            //$this->User->beforeSave($this->request->data);
            
            $this->User->create();
            $this->request->data['User']['email'] = $this->request->data['User']['username'];  
            $this->request->data['User']['isactive'] = 1;            
            $this->request->data['User']['createddate'] = time();
            $this->request->data['User']['remarks'] = 'Registration';
            //echo '<pre>'; print_r($this->request->data); exit;
            $this->User->setCaptcha('security_code', $this->Captcha->getCode('User.security_code'));
            if ($this->User->save($this->request->data)) {
                $message = 'Click the following link to activate your account.' . "\n\n" . Router::url(array('plugin' => 'user', 'action' => 'activate', ''), true);
                $email = new CakeEmail('smtp');
                /*$email->from('noreply@example.com')
                      ->to($this->request->data['User']['EmailID'])
                      ->subject('Account Activation')
                      ->send();*/
                //$email->send($message);
                //echo "<pre>";
                //print_r($email);
		//exit;
                $this->Session->setFlash(__('Your account has been created. Please check your email for activation instructions.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }   
        }
    }
 
    public function edit($id = null) {
 
            if (!$id) {
                $this->Session->setFlash('Please provide a user id');
                $this->redirect(array('action'=>'index'));
            }
 
            $user = $this->User->findById($id);
            if (!$user) {
                $this->Session->setFlash('Invalid User ID Provided');
                $this->redirect(array('action'=>'index'));
            }
 
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->User->id = $id;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been updated'));
                    $this->redirect(array('action' => 'edit', $id));
                }else{
                    $this->Session->setFlash(__('Unable to update your user.'));
                }
            }
 
            if (!$this->request->data) {
                $this->request->data = $user;
            }
    }
 
    public function delete($id = null) {
         
        if (!$id) {
            $this->Session->setFlash('Please provide a user id');
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('isactive', 'N')) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
     
    public function activate($id = null) {
         
        if (!$id) {
            $this->Session->setFlash('Please provide a user id');
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('isactive', 'Y')) {
            $this->Session->setFlash(__('User re-activated'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not re-activated'));
        $this->redirect(array('action' => 'index'));
    }
 
}