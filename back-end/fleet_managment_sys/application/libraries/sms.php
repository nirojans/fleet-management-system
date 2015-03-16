<?php

class Sms
    /**
     * Sample usage:
     * $this->load->library('sms');
     * $sms = new Sms("Testing message");
     * $sent = $sms->send("0711661919","Testing message");
     *
     * */
{
    private $message;
    private $mobileNumber;
    private $serviceUri;

    /**
     * @param string $serviceUri : End point of the SMS REST service, currently using python service , in default port 3000
     * You may obtain a copy of python script in $self repo
     */
    function Sms($serviceUri = 'http://localhost:3000/service/sms/send')
    {

        $this->CI =& get_instance();
        // TODO: !!! DEPRECATED !!! replace this (currently using) https://github.com/philsturgeon/codeigniter-curl with recommended library
        $this->CI->load->library('curl');
        $this->$serviceUri = $serviceUri;
    }

    /**
     * @param $mobile_number : Number of the recipient
     * @param $message : Message need to be send
     * @return mixed : Currently, directly returning the string received as the body of the HTTP response from python sms service
     */
    public function send($mobile_number, $message)
    {
        $this->message = $message;

        $POSTData = array(
            'mobile_number' => $mobile_number,
            'message' => $message,
            CURLOPT_USERAGENT => true
        );
        $response = $this->CI->curl->simple_post('http://localhost:3000/service/sms/send', $POSTData);

//        return json_decode($response); // TODO: return status rather than string received from python daemon, change python code accordingly to return JSON string
        return $response;

    }
}
