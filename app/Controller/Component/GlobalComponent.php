<?php

    class GlobalComponent extends Component {
        public $components = ['Auth'];
        public function ifHasProfile() {
            $userId = $this->Auth->user('id');
            
            $profileModel = ClassRegistry::init('Profile');
            $profile = $profileModel->findById($userId);
        
            return ($profile) ? true : false;
        }
        
    }