<?php
namespace core;
class Application {

    static $APP_NAME = 'FlowCash 2099';
    static $HOST= 'localhost/cash_flow/';
    static $HOME = 'app\view\Home'; //..home page

    //------- icons -------------
    static $ICON_SUCCESS = 'core/icon/checked.png';
    static $ICON_ERROR = 'core/icon/.....';
    static $ICON_NOT_FOUND = 'core/icon/....';
    static $ICON_REPORT = 'core/icon/icon_report.png';

    //------- messages ----------
    static $MSG_TITLE = 'Mensagem do Sistema';
    static $MSG_SUCCESS = 'Operação realizada com sucesso!';
    static $MSG_ERROR = 'Erro durante a operação';
    static $MSG_NOT_FOUND = 'Objeto não encontrado';
    static $MSG_ACTIVATE = 'Cadastro ativado com sucesso! Faça o login!';
    static $MSG_INCORRECT_LOGIN = 'Dados incorretos!';


    //-------- email -------------
    static $EMAIL = 'jlgregorio81@hotmail.com';
    static $EMAIL_PASSWD = '';

    public static function start(){
        (new self::$HOME())->show();
    }

    public static function getRoot(){
        return $_SERVER['DOCUMENT_ROOT'] . '/cash_flow/';
    }

    //..send mail
    public static function sendEmail($dest, $subject, $msg){
        //..load the classes of PHPMailer
        require_once 'core/vendor/phpmailer-5.2/PHPMailerAutoload.php';
        //..instantiate a new PHPMailer class - the true parameter supports exception treatment.
        $mail = new \PHPMailer(true);
        try{
            //..Prepare for hotmail.com - to use other mail servers, verify the configurations. 
            $mail->CharSet = 'utf-8';
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'SMARTTLS';
            $mail->Port = 587;
            $mail->Host = 'SMTP.office365.com';
            //..from email
            $mail->setFrom(self::$EMAIL,self::$APP_NAME);
            $mail->Username = self::$EMAIL;
            $mail->Password = self::$EMAIL_PASSWD;
            //..set the destiny, the subject and the message
            $mail->addAddress($dest);
            $mail->Subject = $subject;
            $mail->msgHTML($msg);
            //..send the mail
            $mail->send();            
        } catch(\phpmailerException $ex){
            throw new \Exception("[Erro do PHPMailer] {$ex->getMessage()}",0,$ex);
        } catch (\Exception $ex){
            throw $ex;
        }

    }

}

