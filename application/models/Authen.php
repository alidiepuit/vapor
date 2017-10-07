<?php
class Application_Model_Authen {
  const TYPE_REGISTER_EMAIL = 0;
  const TYPE_REGISTER_SOCIAL = 1;

  private static $_sharedInstance = Null;

  protected $_authAdapter = Null;

  protected $_dbAdapter = Null;

  public function __construct() {
    $this->dbAdapter = Zend_Db_Table::getDefaultAdapter();

    $this->_authAdapter = new Zend_Auth_Adapter_DbTable(
        $this->dbAdapter,
        'frontend_user',
        'user_name',
        'user_password',
        'MD5(CONCAT(?, "'.Zend_Registry::get('configs')->AUTH_USER_SALT.'"))'
    );
  }

  static public function getInstance() {
    if (self::$_sharedInstance) {
      return self::$_sharedInstance;
    }
    self::$_sharedInstance = new self();
    return self::$_sharedInstance;
  }

  public function authenticate($username, $password) {
    $this->_authAdapter->setIdentity($username);
    $this->_authAdapter->setCredential($password);

    $user = Application_Model_UserMapper::getInstance()->find($username);
    if ($user && $user->getUserTypeLogin() != self::TYPE_REGISTER_EMAIL) {
      throw new Exception_Authen(Exception_Authen::EXCEPTION_AUTHEN_EMAIL_SOCIAL);
      return false;
    }

    $auth = Zend_Auth::getInstance();
    $result = $auth->authenticate($this->_authAdapter);
    if ($result->isValid()) {
      $object = (array) $this->_authAdapter->getResultRowObject();
      // pr($object);

      // Zend_Auth::getInstance()->clearIdentity();
      $modelUser = new Application_Model_User($object);
      // pr($modelUser);

      $namespace = new Zend_Session_Namespace('Zend_Auth');
      $namespace->user = $modelUser;

      $auth->getStorage()->write($modelUser);
      return true;
    }
    return false;
  }

  public function getCurrentUser() {
    $auth = Zend_Auth::getInstance();
    return $auth->getIdentity();
  }

  public function register($modelUser, $typeLogin = self::TYPE_REGISTER_EMAIL) {
    $username = $modelUser->getUserName();
    $user = Application_Model_UserMapper::getInstance()->find($username);

    if ($user && $user->getUserTypeLogin() != $typeLogin) {
      throw new Exception_Authen(Exception_Authen::EXCEPTION_AUTHEN_EXISTED_USER);
      return false;
    }

    if (!$user) {
      Application_Model_UserMapper::getInstance()->save($modelUser);
      $user = $modelUser;
    }

    // pr($modelUser->getUserName() . ' ' . $modelUser->getUserPassword());
    $namespace = new Zend_Session_Namespace('Zend_Auth');
    $namespace->user = $user;
    
    $auth = Zend_Auth::getInstance();
    $auth->getStorage()->write($user);

    return true;
  }

  public function isValidAuthenSocial($type) {
    return $type == "facebook" || $type == "google";
  }

  public function authenSocial($data) {
    $typeLogin = $data['type'];
    $func = 'authen'.ucfirst($typeLogin);
    if (method_exists('Application_Model_Authen', $func)) {
      return $this->$func($data['accessToken']);
    }
    return false;
  }

  private function authenFacebook($accessToken) {
    require_once APPLICATION_PATH . '/../library/Facebook/autoload.php';

    $fb = new \Facebook\Facebook([
      'app_id' => Zend_Registry::get('configs')->facebook->appId,
      'app_secret' => Zend_Registry::get('configs')->facebook->appSecret,
      'default_graph_version' => 'v2.10',
    ]);

    try {
      // pr($accessToken);
      $response = $fb->get('/me?fields=email,name', $accessToken);
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $me = $response->getGraphUser();
    if (isset($me['id'])) {
      // pr($me);
      $data = array(
        'user_name'           => $me['email'],
        'user_password'       => md5($me['id'].Zend_Registry::get('configs')->AUTH_USER_SALT),
        'user_display_name'   => $me['name'],
        'user_type_login'     => self::TYPE_REGISTER_SOCIAL,
      );
      $modelUser = new Application_Model_User($data);
      return $this->register($modelUser, self::TYPE_REGISTER_SOCIAL);
    }
  }

  private function authenGoogle($accessToken) {
    require_once APPLICATION_PATH.'/../library/Google/vendor/autoload.php';
    
    $config = Zend_Registry::get('configs')->google->json;
    // pr($config);
    $client = new Google_Client();
    $client->setClientId($config->web->client_id);
    $client->setClientSecret($config->web->client_secret);
    $client->setDeveloperKey('AIzaSyBVeWQlpgrEUI1h5fUDYJLj9JlbU6UGmHE');
    $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
    $client->setAccessToken($accessToken);

    $oauth2 = new \Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();
    
    if ($userInfo) {
      // pr($userInfo);
      $data = array(
        'user_name'           => $userInfo['email'],
        'user_password'       => md5($userInfo['id'].Zend_Registry::get('configs')->AUTH_USER_SALT),
        'user_display_name'   => $userInfo['name'],
        'user_type_login'     => self::TYPE_REGISTER_SOCIAL,
      );
      $modelUser = new Application_Model_User($data);
      return $this->register($modelUser, self::TYPE_REGISTER_SOCIAL);
    }
  }
}