<?php

class UsersController extends AppController {


    function login() {
        $this->layout = null;


        $this->set('admin_page', 'login');


        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $user = $this->Auth->user();
                if(empty($user['active'])){
                    return $this->redirect($this->Auth->logout());
                }
                
                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('Username or password incorrect');
            }
        }
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }


    function admin_userActive($idUser = null) {
        $this->autoRender = false;
        $this->User->id = $idUser;
        $this->User->saveField('active', 1);
            $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
    }
    
    function admin_userInActive($idUser = null) {
        $this->autoRender = false;
        $this->User->id = $idUser;
        $this->User->saveField('active', 0);
            $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
    }
    
    function admin_index() {
                $this->set('menu_item', 'account');
        $this->layout = 'admin';
        $this->set('users', $this->User->find('all', array(
                    'order' => 'id',
                )));
    }

    function admin_add() {
                $this->set('menu_item', 'account');
        $this->layout = 'admin';
        if (!empty($this->data)) {
            $pass1 = $this->Auth->password($this->data['User']['pass']);
            $pass2 = $this->Auth->password($this->data['User']['pass2']);
            if ($pass1 == $pass2) {
                $this->request->data['User']['password'] = $this->Auth->password($this->data['User']['pass']);

                if ($this->User->save($this->request->data)) {
            $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
                }
            } else {
                $this->request->data['User']['pass'] = '';
                $this->request->data['User']['pass2'] = '';

                $this->Session->setFlash('Password doesn\'t match!');
            }
        }
    }

    function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->set('menu_item', 'account');
        if (!empty($this->data)) {
                $pass1 = $this->data['User']['pass'];
                $pass2 = $this->data['User']['pass2'];
                $old_pass = $this->data['User']['old_pass'];
            if(empty($pass1) && empty($pass2) && empty($old_pass)){
                $this->User->id = $this->data['User']['id'];
                $this->User->saveField('username', $this->data['User']['username']);
                $this->User->saveField('email', $this->data['User']['email']);
                
            }
            else{
                $pass1 = $this->Auth->password($this->data['User']['pass']);
                $pass2 = $this->Auth->password($this->data['User']['pass2']);
                $old_pass = $this->Auth->password($this->data['User']['old_pass']);
            
                if ($pass1 == $pass2) {

                    if ($this->data['User']['password'] == $old_pass) {
                        $this->request->data['User']['password'] = $pass1;

                        if ($this->User->save($this->request->data)) {
            $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
                        }
                    } else {
                        $this->request->data['User']['pass'] = '';
                        $this->request->data['User']['old_pass'] = '';
                        $this->request->data['User']['pass2'] = '';

                        $this->Session->setFlash('Old password doesn\'t match!');
                    }
                } else {
                    $this->request->data['User']['pass'] = '';
                    $this->request->data['User']['pass2'] = '';

                    $this->Session->setFlash('New Password doesn\'t match!');
                }
            }
        } else {
            $this->User->id = $id;
            $this->data = $this->User->read();
        }
    }

    function admin_delete($id = null) {

        $this->autoRender = false;
        $this->User->id = $id;

        if ($this->User->delete(false)) {
            $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
        }
    }

}

?>