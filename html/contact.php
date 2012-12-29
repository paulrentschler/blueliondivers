<?php

/**
 * Contact form to contact the site owner
 *
 * @author     Paul Rentschler <paul@rentschler.ws>
 * @since      28 December 2012
 */


require_once 'log.class.php';
require_once 'messages.class.php';
require_once 'request.class.php';
require_once 'validate.class.php';
require_once 'display.class.php';
require_once 'html.class.php';
require_once 'widgets.class.php';
require_once 'captcha.class.php';
require_once 'email.class.php';


// define the time zone
date_default_timezone_set('America/New_York');

// settings to log application and error messages to a file
define('LOG_ERRORS', true);
define('LOG_ERRORS_FILE', dirname($_SERVER['DOCUMENT_ROOT']).'/logs/errors.log');
define('LOG_APPLICATION_FILE', dirname($_SERVER['DOCUMENT_ROOT']).'/logs/app.log');

session_start();


$page_title = 'Contact';
$page_active_url = 'contact.php';


/**
 * Handles processing and rendering the contact form
 *
 * @author     Paul Rentschler <paul@rentschler.ws>
 * @since      28 December 2012
 */
class Page
{
    /**
     * Array of valid input values from the form
     *
     * @var array
     */
    protected $validInput = array(
        'name' => '',
        'email' => '',
        'phone' => '',
        'comment' => '',
    );
    
    
    /**
     * Array of widgets used by the contact form
     *
     * @var array
     */
    public $widgets = array();
    
    
    
    /**
     * Setup and process the form on page load
     *
     * @return     void
     * @access     public
     * @author     Paul Rentschler <paul@rentschler.ws>
     * @since      28 December 2012
     */
    public function __construct ()
    {
        // define the widgets used by the form
        $this->buildForm();
        
        // collect any URL or form submitted values
        Request::process();
        
        // see if the form has been submitted
        if (Request::getSafeValue('submitted') == 'ok') {
            // assign the submitted values to the widgets for future use
            foreach ($this->widgets as $widgetName => $widget) {
                if ($widgetName <> 'ksht') {
                    $this->widgets[$widgetName]->setValue(
                        Request::getSafeValue($widgetName)
                    );
                }
            }
            
            // validate the submitted information
            if ($this->validate()) {
                // send the message
                $this->send();
                
                // clear the widget values
                foreach ($this->widgets as $widgetName => $widget) {
                  $this->widgets[$widgetName]->setValue('');
                }
                
                // inform the user that the message has been sent
                Msg::add(
                    MSG_TYPE_WARN,
                    '<strong>Thank You!</strong> Your comment or question '
                        .'has been sent. Someone will get back to you soon.'
                );
                
            } else {
                // get the messages to add to the widgets
                foreach (Msg::get(MSG_TYPE_VALIDATION) as $field => $msg) {
                    $this->widgets[$field]->setErrorText($msg);
                }
            }
        }
    }
    
    
    
    /**
     * Add the widgets to the form for the page
     *
     * @return     void
     * @access     protected
     * @author     Paul Rentschler <paul@rentschler.ws>
     * @since      28 December 2012
     */
    protected function buildForm ()
    {
        $this->widgets = array(
            'name' => new StringWidget(
                'name',
                'Name',
                'Tell us your name',
                true
            ),
            'email' => new StringWidget(
                'email',
                'Email address',
                'Provide your email address so we can respond to you',
                true
            ),
            'phone' => new StringWidget(
                'phone',
                'Phone number',
                'Provide your phone number if you would like us to call you',
                false
            ),
            'comment' => new TextAreaWidget(
                'comment',
                'Comment or question',
                'Ask your question or provide feedback to us',
                true,
                -1,
                array('rows' => 7, 'cols' => 50)
            ),
            'ksht' => new CaptchaWidget(
                'ksht',
                'Help prevent spam',
                'The following math question helps prevent abuse of this form',
                true
            ),
        );
    }
    
    
    
    /**
     * Display the user messages in formatted HTML
     * 
     * @return     string   a string containing HTML that will display the 
     *                      user messages associated with the page.
     * @access     public
     * @author     Paul Rentschler <paul@rentschler.ws>
     * @since      28 December 2012
     */
    public function displayUserMessages ()
    {
        // get the messages
        $messages = Msg::get();
        
        // generate the HTML to display all the messages
        $html = "\n";
        foreach ($messages as $messageType => $msgs) {
            // only show the message type if there are messages
            // do not show validation messages here, they belong 
            //   with their respective field
            if ($messageType <> MSG_TYPE_VALIDATION && count($msgs) > 0) {
              $html .= '<div class="alert ';
              if ($messageType == MSG_TYPE_WARN) {
                  $html .= 'alert-success">'."\n";
              } else {
                  $html .= 'alert-'.strtolower($messageType).'">'."\n";
              }
              $html .= '<button type="button" class="close" '
                  .'data-dismiss="alert">&times;</button>'."\n";
              foreach ($msgs as $msg) {
                  $html .= '  <p>'.$msg.'</p>'."\n";
              }
              $html .= '</div>'."\n";
            }
        }
        
        // return the html
        return $html;
    }
    
    
    
    /**
     * Send the submitted values as an email message
     *
     * @return     void
     * @access     protected
     * @author     Paul Rentschler <paul@rentschler.ws>
     * @since      28 December 2012
     */
    protected function send ()
    {
        $email = new Email();
        $email->addToAddress('paul@rentschler.ws');
        $email->setSubject('[BLS] Web Site Comment or Question');
        $email->setFromAddress('bls@rentschler.ws', 'Blue Lion SCUBA');
        if ($this->validInput['email'] <> ''
            && $this->validInput['name'] <> ''
        ) {
            $email->setReplyToAddress(
                $this->validInput['email'],
                $this->validInput['name']
            );
        } elseif ($this->validInput['email'] <> '') {
            $email->setReplyToAddress($this->validInput['email']);
        }
        
        $msg = $this->validInput['name'].' ';
        if ($this->validInput['phone'] <> '') {
          $msg .= '(ph: '.$this->validInput['phone'].') ';
        }
        $msg .= 'submitted the following comment or question:'."\n\n";
        $msg .= $this->validInput['comment']."\n";
        $msg .= "\n\n";
        $msg .= "--\n";
        $msg .= $this->validInput['name']."\n";
        $msg .= $this->validInput['email']."\n";
        $email->setBody($msg);
        
        $email->send();
    }
    
    
    
    /**
     * Validate the submitted values
     *
     * @return     boolean  a boolean indicating if all the submitted values
     *                      were valid
     * @access     protected
     * @author     Paul Rentschler <paul@rentschler.ws>
     * @since      28 December 2012
     */
    protected function validate ()
    {
        $validate = new Validate();
        
        // validate the submitted information
        $dataValid = true;
        
        
        /* CHECK NAME */
        if (trim(Request::getRawValue('name')) <> '') {
            // validate the name
            if ($validate->validatePersonName(Request::getRawValue('name'), 100)) {
                // the name is valid
                $this->validInput['name'] = Request::getSafeValue('name');
            } else {
              Msg::add(
                  MSG_TYPE_VALIDATION,
                  $validate->getErrorMessage('name'),
                  'name'
              );
              $dataValid = false;
            }
        } else {
            Msg::add(
                MSG_TYPE_VALIDATION,
                'You must tell us your name.',
                'name'
            );
            $dataValid = false;
        }
        
        /* CHECK EMAIL */
        if (trim(Request::getRawValue('email')) <> '') {
            // validate the email
            if ($validate->validateEmailAddress(Request::getRawValue('email'))) {
                // the email is valid
                $this->validInput['email'] = Request::getSafeValue('email');
            } else {
                Msg::add(
                    MSG_TYPE_VALIDATION,
                    $validate->getErrorMessage('email address'),
                    'email'
                );
                $dataValid = false;
            }
        } else {
            Msg::add(
                MSG_TYPE_VALIDATION,
                'You must tell us your email address so we can get back to you.',
                'email'
            );
            $dataValid = false;
        }
        
        /* CHECK PHONE */
        if (trim(Request::getRawValue('phone')) <> '') {
            // validate the phone
            if ($validate->validatePhoneNumber(Request::getRawValue('phone'), true)) {
                // the phone is valid
                $this->validInput['phone'] = Request::getSafeValue('phone');
            } else {
                Msg::add(
                    MSG_TYPE_VALIDATION,
                    $validate->getErrorMessage('phone number'),
                    'phone'
                );
                $dataValid = false;
            }
        }
        
        /* CHECK COMMENT */
        if (trim(Request::getRawValue('comment')) <> '') {
            // validate the comment
            if ($validate->validateStringBlock(Request::getRawValue('comment'))) {
                // the comment is valid
                $this->validInput['comment'] = Request::getSafeValue('comment');
            } else {
                Msg::add(
                    MSG_TYPE_VALIDATION,
                    $validate->getErrorMessage('comment or question'),
                    'comment'
                );
                $dataValid = false;
            }
        } else {
            Msg::add(
                MSG_TYPE_VALIDATION,
                'You must provide a comment or question.',
                'comment'
            );
            $dataValid = false;
        }
        
        /* CHECK THE CAPTCHA */
        // ksht = Kill Spam Human Test
        if (is_numeric(Request::getRawValue('ksht'))
            && ((int) Request::getRawValue('ksht')) >= 0
        ) {
            // check the captcha
            if (!Captcha::checkAnswer(Request::getSafeValue('ksht'))) {
                Msg::add(
                    MSG_TYPE_VALIDATION,
                    'The answer you provided was incorrect. '
                        .'A new question is being asked.',
                    'ksht'
                );
                $dataValid = false;
            }
        } else {
            Msg::add(
                MSG_TYPE_VALIDATION,
                'You need to answer the math question to help prevent '
                    .'inappropriate use of this form.',
                'ksht'
            );
            $dataValid = false;
        }
        
        return $dataValid;
    }
}



$page = new Page();

include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/header.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/contact.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/footer.tpl';

?>
