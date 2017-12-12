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

    public function createImageAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $data = $_POST['image'];
        // var_dump($data);

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        file_put_contents('image.png', $data);

        // $link = $_POST['link'];
        // $link = 'http://local.vapor.vn/test2/story_html6.html';
        // var_dump(APPLICATION_PATH . '/../public/test2/run.sh ' . $link);
        // set_time_limit(600);
        // $output = shell_exec(APPLICATION_PATH . '/../public/test2/run.sh');
        // $output = shell_exec('ls -la');
        // $cmd = APPLICATION_PATH . '/../public/test2/gulp --path ' . $link;
        // $cwd = APPLICATION_PATH . '/../public/test2/';
        // $descriptors = array(
        //     0 => array('pipe', 'r'),
        //     1 => array('file', 'stdout', 'w'),
        //     2 => array('file', 'stderr', 'w'),
        // );
        // flush();
        // $handle = proc_open($cmd, $descriptors, $pipes, $cwd);
        // if (!$handle) {
        //     echo 'failed to run command';
        // } else {
        //     proc_close($handle); // wait for command to finish (optional)
        // }
        // var_dump($output);
    }
}

