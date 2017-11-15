<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('homepagelayout');
    }

    public function indexAction()
    {
        // $username = 'Admin';
        // $salt = 'DtkD0_##$@!dbmcsfkjf';
        // $akey = md5($username.$salt);
        // pr($akey);
    }

    public function testAction()
    {
        require_once APPLICATION_PATH . '/../library/Notification/init.php';
        $wonderpush = new \WonderPush\WonderPush(Zend_Registry::get('configs')->webpush->token, Zend_Registry::get('configs')->webpush->id);
        $response = $wonderpush->deliveries()->prepareCreate()
            ->setTargetSegmentIds('@ALL')
            ->setNotification(\WonderPush\Obj\Notification::_new()
                ->setAlert(\WonderPush\Obj\NotificationAlert::_new()
                    ->setTitle('Có đặt hàng mới')
                    ->setText('')
                    ->setTargetUrl('http://admin.vapor.vn/admin/frontend_grouporders')
                    ->setWeb(\WonderPush\Obj\NotificationAlertWeb::_new()->setIcon('https://cdn.by.wonderpush.com/upload/01buspoaojfm49j2/90ff94fc2fd015f124a96fe6b793a326f4c41efa')
                        ->setImage('https://cdn.by.wonderpush.com/upload/01buspoaojfm49j2/90ff94fc2fd015f124a96fe6b793a326f4c41efa')
                )))
            ->execute()
            ->checked();
    }
}

