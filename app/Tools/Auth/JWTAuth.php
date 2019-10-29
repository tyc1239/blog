<?php
/**
 * Created by PhpStorm.
 * User: 田胤辰
 * Date: 2019/7/5
 * Time: 16:13
 */

namespace App\Tools\Auth;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

/**
 * 单例模式的使用场景
 *连接数据库时候
 *做用户验证的时候
 *
 * 注意：
 *  1、单例类只能有一个实例。
 *  2、单例类必须自己创建自己的唯一实例。
* 3、单例类必须给所有其他对象提供这一实例。
 */



/**
 * app接口使用JWT授权
 * Class JWTAuth
 * @package App\Tools\Auth
 */

class JWTAuth
{
    /**
     * @var
     */
    private $token;

    /**
     * @var
     */
    private $decodetoken;

    /**
    *定义token的的签发者
     * @var string
     */
    private $iss = "https://www.du.com";
    /**
    *定义token的使用者
     * @var string
     */
    private $aud = "https://www.bai.com";

    /*
     * 设置加密的盐值
     */
    private $salt;

    public function setsalt()
    {
         $this->salt =env('APISALT');
    }

    /**
     * 用户的id
     * @var
     */
    private $uid;

    /**
     * 设置用户id
     * @param $id
     * @return $this
     */
    public function setuid($uid)
    {
         $this->uid =$uid;
        return $this;
    }

    /**
     * 获取token
     * @return string
     */
    public function GetToken()
    {
        $token =(string)$this->token;
         return $token;
    }

    /**
     * 设置token
     * @param $token
     * @return $this
     */
    public function SetToken($token)
    {
       $this->token = $token;
        return $this;
    }

    /**
     * 创建单例模式 私有的静态属性
     * @var
     */
    private static $instance;

    /**
     * 获取单例模式 共有的静态方法
     * @return mixed
     */
    public static function getInstance()
    {
        if(is_null(self::$instance)){
            self::$instance =new self();

        }
        return self::$instance;
    }


    /**
     * 单例模式 私有的构造方法
     * JWTAuth constructor.
     */
    private function __construct()
    {

    }

    /**
     *单例模式 私有的克隆方法
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.


    }


    /**
     * 加密
     * @return $this
     */
    public  function encode()
    {
        $time =time();
        $this->token = (new Builder())
                                ->setHeader('alg','HS256')
                                ->setIssuer($this->iss)//服务签发者 服务端
                                ->setAudience($this->aud)//签发给谁 客户端
                                ->setIssuedAt($time)//设置创建时间
                                ->set('uid',$this->uid)//设置用户id
                                ->setExpiration($time +3600)//设置过期时间
                                //->identifiedBy($this->salt,true)//设置盐值
                                ->sign(new Sha256(),$this->salt)//设置盐值
                                ->getToken();
        return $this;
    }

    /**
     * 将token强转为字符串
     * @return \Lcobucci\JWT\Token
     */
    public function decode()
    {
        if(!$this->decodetoken){
        $this->decodetoken =(new Parser())->parse((string)$this->token);
    }
        return $this->decodetoken;

//        $token = (new Parser())->parse((string)$this->token); // Parses from a string
//        echo $token->getHeader('jti'); // will print "4f1g23a12aa"
//        echo $token->getClaim('iss'); // will print "http://example.com"
//        echo $token->getClaim('uid'); // will print "1"
    }

    /**
     * 验证token数据的有效性
     * @return bool
     */
    public function validate()
    {
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($this->iss);
        $data->setAudience($this->aud);
        return $this ->decode()->validate($data);
    }

    /**、
     * 鉴权
     */
    public function verify()
    {
        $result = $this->decode()->verify(new Sha256(),$this->salt);
        return $result;
    }


}