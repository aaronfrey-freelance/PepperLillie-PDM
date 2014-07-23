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
class Wpjb_Module_AjaxNopriv_Linkedin 
{
    
    public function applyAction()
    {
        $post_body = file_get_contents('php://input');
        $json = json_decode($post_body);
        $transient = "wpjb_li_apply_".$json->job->id."_".$json->person->id;
        $matches = null;
        
        if(get_transient($transient) == "1") {
            exit;
        }
        
        set_transient($transient, "1", 60);
        
        // 15 seconds delay to allow LinkedIn to generate PDF resume.
        ignore_user_abort();
        sleep(15);
        
        $linkedin_signature = $_SERVER['HTTP_CONTENT_SIGNATURE'];
        $my_signature = base64_encode(hash_hmac("sha1", $post_body, wpjb_conf("linkedin_secret_key"), true));

        // compare the two signatures
        if ($linkedin_signature != $my_signature) {
            error_log("Invalid signature: expected $linkedin_signature, calculated $my_signature");
            exit;
        }
        
        preg_match("/user_id:([0-9]+)/", $json->meta, $matches);
        
        if(isset($matches[1])) {
            $user_id = (int)$matches[1];
        } else {
            $user_id = null;
        }
        
        $apply = new Wpjb_Model_Application();
        $apply->job_id = $json->job->id;
        $apply->user_id = $user_id;
        $apply->applied_at = date("Y-m-d");
        $apply->applicant_name = trim($json->person->firstName." ".$json->person->lastName);
        $apply->message = $json->coverLetter;
        $apply->email = $json->person->emailAddress;
        $apply->status = Wpjb_Model_Application::STATUS_NEW;
        $apply->save();
        
        $dir = wpjb_upload_dir("application", "file", $apply->id, "basedir");
        $files = array();
        
        if(wp_mkdir_p($dir)) {
            $wpupload = wp_upload_dir();
            $stat = @stat($wpupload["basedir"]);
            $perms = $stat['mode'] & 0007777;
            chmod($dir, $perms);
            
            $pdf = wp_remote_get($json->pdfUrl);
            
            if(!$pdf instanceof WP_Error) {
                file_put_contents($dir."/linkedin_resume.pdf", $pdf["body"]);
                $files[] = $dir."/linkedin_resume.pdf";
            } else {
                error_log($pdf->get_error_message());
                exit;
            }
            
            
        }
        
        do_action("wpjb_linkedin_application", $apply, $json);
        
        $job = new Wpjb_Model_Job($json->job->id);
        if($job->user_id) {
            $user = new WP_User($job->user_id);
        }
                
        // notify admin
        $mail = Wpjb_Utility_Message::load("notify_admin_new_application");
        $mail->assign("job", $job);
        $mail->assign("application", $apply);
        $mail->assign("resume", Wpjb_Model_Resume::current());
        $mail->addFiles($files);
        $mail->setTo(get_option("admin_email"));
        $mail->send();

        // notify employer
        $notify = null;
        if($job->company_email) {
            $notify = $job->company_email;
        } elseif($user && $user->user_email) {
            $notify = $user->user_email;
        }
        if($notify == get_option("admin_email")) {
            $notify = null;
        }
        $mail = Wpjb_Utility_Message::load("notify_employer_new_application");
        $mail->assign("job", $job);
        $mail->assign("application", $apply);
        $mail->assign("resume", Wpjb_Model_Resume::current());
        $mail->addFiles($files);
        $mail->setTo($notify);
        if($notify !== null) {
            $mail->send();
        }
        
        delete_transient($transient);
        
        exit;
    }
}

?>
