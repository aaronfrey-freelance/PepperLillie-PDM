<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Linkedin
 *
 * @author Grzegorz
 */
class Wpjb_Service_Linkedin {
    
    const URL = 'https://api.linkedin.com';
    
    public $param = null;
    
    public function __construct($param = array())
    {
        if(is_array($param)) {
            $param = (object)$param;
        }
        
        $this->param = $param;
    }
    
    public function setOauthToken($token)
    {
        $this->param->oauth_token = $token;
    }
    
    public function getOauthToken()
    {
        return $this->param->oauth_token;
    }
    
    public function setOauthTokenSecret($token)
    {
        $this->param->oauth_token_secret = $token;
    }
    
    public function getOauthTokenSecret()
    {
        return $this->param->oauth_token_secret;
    }
    
    /**
     * 
     * @param array $param
     * @return Wpjb_Service_Linkedin
     */
    public static function linkedin($param = array())
    {
        
        $path = Wpjb_List_Path::getPath("vendor");
        if(!class_exists("OAuthException")) {
            require_once $path."/TwitterOAuth/OAuth.php";
        }
        if(!class_exists("TwitterOAuth")) {
            require_once $path."/TwitterOAuth/TwitterOAuth.php";
        }
        
        $default = array(
            'api_key'  => wpjb_conf("linkedin_api_key"),
            'secret_key' => wpjb_conf("linkedin_secret_key"),
            'oauth_token' => wpjb_conf("linkedin_oauth_token"),
            'oauth_token_secret' => wpjb_conf("linkedin_oauth_token_secret"),
        );
        
        foreach($default as $key => $value) {
            if(!isset($param[$key])) {
                $param[$key] = $value;
            }
        }

        $self = new self($param);
        
        return $self;
    }
    
    public function requestToken($param)
    {
        $url = $param["redirect_url"];
        
        $result = null;
        $consumer = new OAuthConsumer($this->param->api_key, $this->param->secret_key, NULL);
        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
        $reqObj = OAuthRequest::from_consumer_and_token($consumer, NULL, "POST", self::URL.'/uas/oauth/requestToken');
        $reqObj->set_parameter("oauth_callback", $url);
        $reqObj->sign_request($signatureMethod, $consumer, NULL);
        $toHeader = $reqObj->to_header();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($toHeader));
        curl_setopt($ch, CURLOPT_URL, self::URL.'/uas/oauth/requestToken');
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_POST, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        parse_str($output, $result);

        //setcookie("linkedin_request_oauth_token", $result["oauth_token"]);
        //setcookie("linkedin_request_oauth_token_secret", $result["oauth_token_secret"]);
        update_user_meta(get_current_user_id(), "_linkedin_request_oauth_token_secret", $result["oauth_token_secret"]);

        return self::URL."/uas/oauth/authorize?oauth_token=".$result["oauth_token"];

    }
    
    public function accessToken($param = array())
    {
        $linkedin_request_oauth_token_secret = get_user_meta(get_current_user_id(), "_linkedin_request_oauth_token_secret", true);
        $result = null;
        $consumer = new OAuthConsumer($this->param->api_key, $this->param->secret_key, NULL);
        $token = new OAuthConsumer($_REQUEST['oauth_token'], $linkedin_request_oauth_token_secret, 1);
        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();

        $accObj = OAuthRequest::from_consumer_and_token($consumer, $token, "POST", self::URL.'/uas/oauth/accessToken');
        $accObj->set_parameter("oauth_verifier", $_REQUEST['oauth_verifier']); # need the verifier too!
        $accObj->sign_request($signatureMethod, $consumer, $token);
        $toHeader = $accObj->to_header();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($toHeader));
        curl_setopt($ch, CURLOPT_URL, self::URL.'/uas/oauth/accessToken');
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_POST, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        parse_str($output, $result);

        return $result;
    }
    
    public function profile()
    {
        $endpoint = self::URL.'/v1/people/~';
        $consumer = new OAuthConsumer($this->param->api_key, $this->param->secret_key, NULL);
        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
        $token = new OAuthConsumer($this->param->oauth_token, $this->param->oauth_token_secret, 1);

        $profileObj = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $endpoint, array());
        $profileObj->sign_request($signatureMethod, $consumer, $token);
        $toHeader = $profileObj->to_header();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($toHeader));
        curl_setopt($ch, CURLOPT_URL, $endpoint);

        $output = curl_exec($ch);
        curl_close($ch);

        return new SimpleXMLElement($output);
    }
    
    public function admin()
    {
        $endpoint = self::URL.'/v1/companies?is-company-admin=true';
        $consumer = new OAuthConsumer($this->param->api_key, $this->param->secret_key, NULL);
        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
        $token = new OAuthConsumer($this->param->oauth_token, $this->param->oauth_token_secret, 1);

        $profileObj = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $endpoint, array());
        $profileObj->sign_request($signatureMethod, $consumer, $token);
        $toHeader = $profileObj->to_header();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($toHeader));
        curl_setopt($ch, CURLOPT_URL, $endpoint);

        $output = curl_exec($ch);
        curl_close($ch);

        return new SimpleXMLElement($output);
    }
    
    public static function share($object)
    {
        try {
            $post = self::_share($object);
            
            //$meta = $object->meta->facebook_share_id->getFirst();
            //$meta->value = $post["id"];
            //$meta->save();
            
        } catch(Exception $e) {
            // @todo: log error
        }
    }
    
    public static function shareTest($object) 
    {
        self::_share($object);
    }
    
    protected static function _share($object)
    {
        $linkedin = self::linkedin();
        $parameters = apply_filters("wpjb_linkedin_share_params", array(
            'comment' => wpjb_conf("linkedin_share_comment"),
            'title' => wpjb_conf("linkedin_share_title"),
            'description' => "",
            'url' => $object->url(),
            'image_url' => $object->getLogoURL(),
            'visibility' => "anyone"
        ));
        
        $parser = new Daq_Tpl_Parser();
        $parser->assign("job", $object);
        
        $parameters["comment"] = $parser->draw($parameters["comment"]);
        $parameters["title"] = $parser->draw($parameters["title"]);
        $parameters["description"] = $parser->draw($parameters["description"]);
        
        $share = new SimpleXMLElement("<share></share>");
        $share->addChild("comment");
        $share->comment = $parameters["comment"];
        
        $content = $share->addChild("content");
        if(!empty($parameters["title"])) {
            $content->addChild("title");
            $content->title = $parameters["title"];
        }
        
        if(!empty($parameters["description"])) {
            $content->addChild("description");
            $content->description = $parameters["description"];
        }
        
        $content->addChild("submitted-url");
        $content->{"submitted-url"} = $parameters["url"];
        
        if(!empty($parameters["image_url"])) {
            $content->addChild("submitted-image-url");
            $content->{"submitted-image-url"} = $parameters["image_url"];
        }
        
        $visibility = $share->addChild("visibility");
        $visibility->addChild("code");
        $visibility->code = $parameters["visibility"];
        
        if(is_numeric(wpjb_conf("linkedin_share_as"))) {
            $endpoint = self::URL.'/v1/companies/'.wpjb_conf("linkedin_share_as").'/shares';
        } else {
            $endpoint = self::URL.'/v1/people/~/shares';
        }
        
        $consumer = new OAuthConsumer($linkedin->param->api_key, $linkedin->param->secret_key, NULL);
        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
        $token = new OAuthConsumer($linkedin->param->oauth_token, $linkedin->param->oauth_token_secret, 1);

        $profileObj = OAuthRequest::from_consumer_and_token($consumer, $token, "POST", $endpoint, array());
        $profileObj->sign_request($signatureMethod, $consumer, $token);
        $toHeader = $profileObj->to_header();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($toHeader, "Content-type: application/xml"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $share->asXML());
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $newpost = new SimpleXMLElement($output);
        
        if($newpost->status && (int)$newpost->status >= 400) {
            throw new Exception((string)$newpost->message);
        }
        
        return $newpost;
    }
    
    public static function apply($job) 
    {
        ?>

            <style type="text/css">
                span.IN-widget { vertical-align: bottom !important }
            </style>
            <script data-cfasync="false" type="text/javascript" src="http://platform.linkedin.com/in.js">
              api_key: <?php echo esc_js(wpjb_conf("linkedin_api_key")) ?>
            </script>

            <script type="IN/Apply" 
              data-jobId="<?php echo esc_attr($job->id) ?>"
              data-companyId="<?php echo esc_attr(wpjb_conf("linkedin_share_as")) ?>" 
              data-companyName="<?php echo esc_attr($job->company_name) ?>" 
              data-jobTitle="<?php echo esc_attr($job->job_title) ?>" 
              data-jobLocation="<?php echo esc_attr($job->locationToString()) ?>"
              data-showText="false"
              <?php if(wpjb_conf("linkedin_apply_method") == "email"): ?>
              data-email="<?php echo esc_attr(wpjb_conf("linkedin_apply_email")) ?>" 
              <?php else: ?>
              data-url="<?php echo esc_url(admin_url("admin-ajax.php")) ?>?action=wpjb_linkedin_apply"
              <?php endif; ?>
              data-meta="<?php if(Wpjb_Model_Resume::current()) echo "user_id:".Wpjb_Model_Resume::current()->user_id ?>"
              data-coverLetter="optional"
              >
            </script>

        <?php
    }

}

?>
