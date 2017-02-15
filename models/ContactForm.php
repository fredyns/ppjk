<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        $body = nl2br($this->body);
        $mailBody = <<<BODY
Halo,<br/>
Seseorang telah berusaha menghubungi Jasco melalui kontak website.<br/>
<br/>
<b>Nama</b>: {$this->name}<br/>
<b>Email</b>: {$this->email}<br/>
<b>Tentang</b>: {$this->subject}<br/>
<br/>
<b>Pesan</b>:<br/>
{$body}
BODY;
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setHtmlBody($mailBody)
                ->send();

            return true;
        }
        return false;
    }
}