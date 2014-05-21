<?php
/**
 * 邮件
 *
 * @author cdlei
 */

class Application_Model_Mail extends Application_Model_Common
{
    /**
     * 状态，返回0为成功，其他为错误
     *
     * @var int
     */
    protected $_status = NULL;

    /**
     * 错误信息
     *
     * @var int
     */
    protected $_info = NULL;
    

    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 发送邮件
     *
     * @param string $address
     * @param string $subject
     * @param string $content
     * @return void
     */
    public function send($address, $subject, $content)
    {
        try{
            $config = array('auth' => 'login',
                    'username' => $this->_configs['project']['mailSendAccount'],
                    'password' => $this->_configs['project']['mailSendPassword'],
                    'port'     => $this->_configs['project']['mailHostPort']
            );
            $transport = new Zend_Mail_Transport_Smtp($this->_configs['project']['mailHost'], $config);
            $mail = new Zend_Mail("UTF-8");
            $mail->setBodyHtml($content);
            $mail->setFrom($this->_configs['project']['mailSendAccount'], "{$this->_configs['project']['systemName']}{$_SERVER['SERVER_NAME']}");
            $mail->addTo($address, $address);
            $mail->setSubject($subject);
            $mail->send($transport);
            $this->_status = 0;
            $this->_info = '发送成功';
        } catch(Exception $e) {
            $this->_status = 1;
            $this->_info = $e->getMessage();
        }
    }

    /**
     * 获取发送状态
     *
     * @return void
     */
    public function getSendStaus() {
        return $this->_status;
    }

    /**
     * 获取发送信息
     *
     * @return void
     */
    public function getSendInfo() {
        return $this->_info;
    }
}