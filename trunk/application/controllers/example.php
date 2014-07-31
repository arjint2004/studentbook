<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form','file'));
        $this->load->library(array('session','email'));
    }

    public function index()
    {
        if(!empty($_POST)) {
            //echo 'pos ada';exit;
            // load library
            $this->load->library('nexmo');
            // set response format: xml or json, default json
            $this->nexmo->set_format('json');
            
            // **********************************Text Message*************************************
            $phone  = $this->input->post('phone');
            $jumlah = $this->input->post('jumlah'); 
            $phone = explode(',',$phone);
            if(is_array($phone)) {
                foreach($phone as $no) {
                    for($i=1;$i<=$jumlah;$i++) {
                        $from = $this->input->post('from');
                        $to = $no;
                        $pesan = $this->input->post('pesan');
                        $message = array(
                            'text' => $pesan
                        );
                        $response = $this->nexmo->send_message($from, $to, $message);
                        echo "<h1>Text Message</h1>";
                        $this->nexmo->d_print($response);
                        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";   
                    }    
                }
            }
            
            
        }else{
            //echo 'pos exit';exit;
            $this->load->view('viewnexmo','');
        }
        
        //        // load library
        //$this->load->library('nexmo');
        //// set response format: xml or json, default json
        //$this->nexmo->set_format('json');
        //
        //// **********************************Text Message*************************************
        //$from = 'hai';
        //$to = '+6285729294333';
        //$message = array(
        //    'text' => 'test message'
        //);
        //$response = $this->nexmo->send_message($from, $to, $message);
        //echo "<h1>Text Message</h1>";
        //$this->nexmo->d_print($response);
        //echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // *********************************Binary Message**************************************
        /*
        $from = 'xxxxxxxx';
        $to = 'xxxxxxxxxx';
        $message = array(
            'body' => 'body message',
            'udh' => 'xxxxxxx'
        );
        $response = $this->nexmo->send_message($from, $to, $message);
        echo "<h1>Binary Message</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";
        */
        // *********************************Wappush Message**************************************
        /*
        $from = 'xxxxxxxx';
        $to = 'xxxxxxxxxx';
        $message = array(
            'title' => 'xxxxxx',
            'url' => 'xxxxxxx',
            'validity' => 'xxxxxx'
        );
        $response = $this->nexmo->send_message($from, $to, $message);
        echo "<h1>Wappush Message</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // *********************************Account - Get Balance*********************************
        $response = $this->nexmo->get_balance();
        echo "<h1>Account - Get Balance</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Account - Get Pricing*********************************
        $response = $this->nexmo->get_pricing('TW');
        echo "<h1>Account - Get Pricing</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Account - Settings*********************************
        $response = $this->nexmo->get_account_settings(NULL, 'http://mlb.mlb.com', 'http://www.facebook.com');
        echo "<h1>Account - Settings</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Account - Numbers*********************************
        $response = $this->nexmo->get_numbers();
        echo "<h1>Account - Numbers</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Account - Top-up*********************************
        $trx = 'xxxxxxxxxxxxx';
        $response = $this->nexmo->get_top_up($trx);
        echo "<h1>Account - Top-up</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Number - Search*********************************
        $response = $this->nexmo->get_number_search('US', NULL);
        echo "<h1>Number - Search</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Number - Buy*********************************
        $response = $this->nexmo->get_number_buy('US', 'xxxxxxxxxxxxx');
        echo "<h1>Number - Buy</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Number - Cancel*********************************
        $response = $this->nexmo->get_number_cancel('US', 'xxxxxxxxxxxxx');
        echo "<h1>Number - Cancel</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Number - Update*********************************
        $params = array(
            'moHttpUrl' => 'http://xxxxxx'
            'moSmppSysType' => 'inbound'
        );
        $response = $this->nexmo->get_number_update('TW', 'xxxxxxxxxxxxx', null);
        echo "<h1>Number - Update</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Search - Message*********************************
        $response = $this->nexmo->search_message('xxxxxxxxxxxxx');
        echo "<h1>Search - Message</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Search - Messages*********************************
        $ids = array('xxxxxxxxxxxxx', 'xxxxxxxxxxxxx');
        $response = $this->nexmo->search_messages($ids);
        echo "<h1>Search - Messages</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        $response = $this->nexmo->search_messages(null, '2013-01-23', 'xxxxxxxxxxxxx');
        echo "<h1>Search - Messages</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";

        // ********************************Search - Rejections*********************************
        $response = $this->nexmo->search_rejections('2013-01-23', 'xxxxxxxxxxxxx');
        echo "<h1>Search - Message</h1>";
        $this->nexmo->d_print($response);
        echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";
        */
    }
}
/* End of file example.php */
/* Location: ./application/controllers/example.php */
