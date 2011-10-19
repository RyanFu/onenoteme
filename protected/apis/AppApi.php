<?php
class AppApi
{
    private static $_apiPath;
    
    private $_apiUrl;
    private $_apikey;
    private $_secretKey;
    private $_format = 'json';
    private $_methods;
    private $_sig;
    private $_args;
    
    private $_class;
    private $_function;
    
    /**
     * 构造函数
     * @param string $apiUrl ApiBaseUrl
     * @param array $args
     */
    public function __construct($apiUrl, $args)
    {
        $this->_args = $args;
    	$this->init();
    	
        if (empty($this->_apikey))
            $this->setApiPath(dirname(__FILE__));
        $this->_apiUrl = $apiUrl;
        
        $this->parseArgs($args);
    }
    
    private function init()
    {
//        sleep(3);
        set_error_handler(array($this, 'errorHandler'), E_ERROR);
    	set_exception_handler(array($this, 'exceptionHandler'));
    }
    
    /**
     * 设置api类所在的路径
     * @param string $path
     * @throws ApiException
     * @return AppApi
     */
    public function setApiPath($path)
    {
        if (file_exists(realpath($path)))
            self::$_apiPath = rtrim($path, '\/') . DIRECTORY_SEPARATOR;
        else
            throw new ApiException('$path 不存在', ApiError::APIPATH_NO_EXIST);
            
        return $this;
    }
    
    /**
     * 运行AppApi
     */
    public function run()
    {
        $this->checkArgs()->execute();
        exit(0);
    }
    
    /**
     * 检查参数
     * @return AppApi
     */
    private function checkArgs()
    {
        $this->checkFormat()
            ->checkApiKey()
            ->checkSignature();
            
        return $this;
    }
    
    /**
     * 执行methods对应的命令
     * @throws ApiException
     */
    private function execute()
    {
        $result = call_user_func($this->parsekMethods());
        if (false === $result)
            throw new ApiException('$class->$method 执行错误', ApiError::CLASS_METHOD_EXECUTE_ERROR);
        else
            self::output($result, $this->_format);
    }
    
    /**
     * 分析用户提交的参数
     * @param array $args
     * @return AppApi
     */
    private function parseArgs($args)
    {
        $this->checkRequiredArgs();
        
        foreach ($args as $key => $value)
            $args[$key] = strip_tags(trim($value));
            
        $args['oauth_consumer_key'] && $this->_apikey = $args['oauth_consumer_key'];
        $args['format'] && $this->_format = $args['format'];
        $args['methods'] && $this->_methods = $args['methods'];
        $args['oauth_signature'] && $this->_sig = $args['oauth_signature'];
        
        return $this;
    }
    
    /**
     * 检查必需的参数
     * @throws ApiException
     * @return AppApi
     */
    private function checkRequiredArgs()
    {
        $args = array('oauth_consumer_key', 'oauth_signature', 'methods');
        $keys = array_keys($this->_args);
        if ($keys != ($keys + $args)) {
            throw new ApiException('缺少必须的参数', ApiError::ARGS_NOT_COMPLETE);
        }
        return $this;
    }

    /**
     * 检查apikey
     * @throws ApiException
     * @return AppApi
     */
    private function checkApiKey()
    {
        $keys = (array)require(dirname(__FILE__) . DS . 'keys.php');
        if (array_key_exists($this->_apikey, $keys)) {
            $this->_secretKey = $keys[$this->_apikey];
        }
        else
            throw new ApiException('apikey不存在', ApiError::APIKEY_INVALID);
        return $this;
    }
    
    /**
     * 检查format参数
     * @throws ApiException
     * @return AppApi
     */
    private function checkFormat()
    {
        if (!in_array(strtolower($this->_format), array('json', 'xml'))) {
            throw new ApiException('format 参数错误', ApiError::FORMAT_INVALID);
        }
        return $this;
    }
    
    /**
     * 解析method参数
     * @throws ApiException
     * @return array 0=>object, 1=>method
     */
    private function parsekMethods()
    {
        list($class, $method) = explode('.', $this->_methods);
        if (empty($class) || empty($method)) {
            throw new ApiException('methods参数格式不正确', ApiError::METHOD_FORMAT_ERROR);
        }
        
        $class = 'Api_' . $class;
        if (!class_exists($class, false))
            self::importClass($class);

        if (!class_exists($class, false))
            throw new ApiException('$class 类定义不存在', ApiError::CLASS_FILE_NOT_EXIST);
            
        $object = new $class($this->_args);
        if (!method_exists($object, $method))
            throw new ApiException('$method 方法不存在', ApiError::CLASS_METHOD_NOT_EXIST);
        
        return array($object, $method);
    }
    
    /**
     * 导入api类
     * @param string $class
     * @throws ApiException
     */
    private static function importClass($class)
    {
        try {
            require self::$_apiPath . ucfirst($class) . '.php';
        }
        catch (Exception $e) {
            throw new ApiException('$class 文件导入错误', ApiError::CLASS_FILE_NOT_EXIST);
        }
    }
    
    /**
     * 验证用户提交签名是否正确
     * @throws ApiException
     * @return AppApi
     */
    private function checkSignature()
    {
        $sig1 = ($this->_sig);
        $sig2 = urldecode($this->makeSignature());
        if ($sig1 != $sig2) {
            throw new ApiException('$sig 签名不正确', ApiError::SIGNATURE_ERROR);
        }
        return $this;
    }
    
    /**
     * 计算签名
     * @return string 签名
     */
    private function makeSignature()
    {
        $args = $this->_args;
        unset($args['oauth_signature']);

        require('OAuth.php');
        $consumer = new OAuthConsumer($this->_apikey, $this->_secretKey);
        $sigMethod = new OAuthSignatureMethod_HMAC_SHA1();
        $request = new OAuthRequest($_SERVER['REQUEST_METHOD'], $this->_apiUrl);
        
        foreach ($args as $key => $value)
            $request->set_parameter($key, $value, false);
        
        $sig = $request->build_signature($sigMethod, $consumer, null);
        return $sig;
    }
    
    private static function output($data, $format = 'json')
    {
        $method = 'output' . ucfirst(strtolower($format));
        echo self::$method($data);
    }
    
    /**
     * 返回json编码数据
     * @param mixed $data
     * @return string json编码后的数据
     */
    private static function outputJson($data)
    {
        return json_encode($data);
    }
    
    /**
     * 返回xml格式数据
     * @param mixed $data
     * @return string xml数据
     */
    private static function outputXml($data)
    {
        return 'xml';
    }
    
    public function errorHandler($errno, $message, $file, $line)
    {
        if (isset($this->_args[debug]) && $this->_args[debug])
            $error = array('errno'=>$errno, 'message'=>$error, 'line'=>$line, 'file'=>$file);
        else
            $error = 'ERROR';
    	echo json_encode($error);
    	exit(0);
    }
    
    public function exceptionHandler($e)
    {
    	if (isset($this->_args['debug']) && $this->_args['debug'])
    		$error = array('errno'=>$e->getCode(), 'message'=>$e->getMessage());
    	else
    		$error = 'ERROR';
        echo json_encode($error);
    	exit(0);
    }
    
}