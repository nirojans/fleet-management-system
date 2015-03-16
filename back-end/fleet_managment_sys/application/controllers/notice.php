<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class Notice extends CI_Controller
{

    public function trial_expire(){
        $this->load->view('notices/trial_expire');
    }

    public function service_down(){
        $this->load->view('notices/service_down');
    }

    public function feedback_form(){
        $this->load->view("notices/feedback");
    }

    public function submit_feedback(){
        $post_data = $this->input->post();
        $first_name = $post_data['firstname'];
        $last_name = $post_data['lastname'];
        $email = $post_data['email'];
        $subject = $post_data['subject'];
        $message_content = $post_data['comment'];

        try {
            $mandrill = new Mandrill('r0v0dh55VP6Zwk2Se_RmVQ');
            $template_name = 'feedback-report';
            $template_content = array(
                array(
                    'name' => 'Feedback report',
                    'content' => 'Report content'
                )
            );
            $message = array(
                'html' => '<p>Feedback report content</p>',
                'text' => 'Report content',
                'subject' => '[Knnect Feedback]'.$subject,
                'from_email' => 'mailer@knnect.com',
                'from_name' => 'Knnect Mail Service',
                'to' => array(
                    array(
                        'email' => 'tmkasun@gmail.com',
                        'name' => 'Kasun Thennakoon',
                        'type' => 'to'
                    ),
                    array(
                        'email' => 'mypossibelemail@gmail.com',
                        'name' => 'Nirojan Selvanathan',
                        'type' => 'to'
                    ),array(
                        'email' => 'fleet_management@googlegroups.com',
                        'name' => 'Nitrous Technologies',
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => $email),
                'important' => false,
                'track_opens' => null,
                'track_clicks' => null,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,
                'merge_language' => 'mailchimp',
                'global_merge_vars' => array(
                    array(
                        'name' => 'FNAME',
                        'content' => $first_name
                    ),
                    array(
                        'name' => 'LNAME',
                        'content' => $last_name
                    ),
                    array(
                        'name' => 'UEMAIL',
                        'content' => $email
                    ),
                    array(
                        'name' => 'UMESSAGE',
                        'content' => $message_content
                    )
                ),
                'tags' => array('User Feedback'),
                'metadata' => array('website' => 'www.knnect.com')
            );
            $async = false;
            $ip_pool = 'Main Pool';
            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }
}