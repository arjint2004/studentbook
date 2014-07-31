<?php
class Chat extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->helper('global');
        $this->load->library('session');
        $this->load->library('auth');
        $this->auth->user_logged_in();
        $this->load->library('image_moo');
        $this->load->library('Online_Users');
        if (!isset($_SESSION['chatHistory'])) {
            $_SESSION['chatHistory'] = array();	
        }
        
        if (!isset($_SESSION['openChatBoxes'])) {
            $_SESSION['openChatBoxes'] = array();	
        }
        $session                = session_data();
        $_SESSION['username']   = $session['username']; 
        $_SESSION['nama']   = $session['nama']; 
    }
    
    function chatHeartbeat() {
            $sql = "select chat.*, 
			(SELECT nama FROM ak_pegawai WHERE ak_pegawai.id=users.id_pengguna) as nama_pegawai,
			(SELECT nama FROM ak_siswa WHERE ak_siswa.id=users.id_pengguna) as nama_siswa
			from chat JOIN users ON users.username=chat.from where (chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND recd = 0) order by id ASC";
            $query = mysql_query($sql);
            $items = '';
            $chatBoxes = array();
            while ($chat = mysql_fetch_array($query)) {
				if($chat['nama_pegawai']!=''){$chat['nama']=$chat['nama_pegawai'];}else{$chat['nama']=$chat['nama_siswa'];}
                if (!isset($_SESSION['openChatBoxes'][$chat['from']]) && isset($_SESSION['chatHistory'][$chat['from']])) {
                        $items = $_SESSION['chatHistory'][$chat['from']];
                }
                $chat['message'] = $this->sanitize($chat['message']);
                $items .= " {\"s\" : \"0\" , \"nama\" : \"{$chat['nama']}\", \"f\" : \"{$chat['from']}\",\"m\" : \"{$chat['message']}\"},";
                if (!isset($_SESSION['chatHistory'][$chat['from']])) {
                        $_SESSION['chatHistory'][$chat['from']] = '';
                }
                $_SESSION['chatHistory'][$chat['from']] .= " {\"s\" : \"0\" , \"nama\" : \"{$chat['nama']}\", \"f\" : \"{$chat['from']}\",\"m\" : \"{$chat['message']}\"},";                        
                unset($_SESSION['tsChatBoxes'][$chat['from']]);
                $_SESSION['openChatBoxes'][$chat['from']] = $chat['sent'];
                $_SESSION['openChatBoxesname'][$chat['from']] = $chat['nama'];
            }
        
            if (!empty($_SESSION['openChatBoxes'])) {
                foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
                    if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
                            $now = time()-strtotime($time);
                            $time = date('g:iA M dS', strtotime($time));
    
                            $message = "Sent at $time";
                            if ($now > 180) {
                                $items .= " {\"s\" : \"2\" , \"nama\" : \"{$_SESSION['openChatBoxesname'][$chatbox]}\", \"f\" : \"{$chatbox}\",\"m\" : \"{$message}\"},";
                    
                                if (!isset($_SESSION['chatHistory'][$chatbox])) {
                                        $_SESSION['chatHistory'][$chatbox] = '';
                                }
                        
                                $_SESSION['chatHistory'][$chatbox] .= " {\"s\" : \"2\" , \"nama\" : \"{$_SESSION['openChatBoxesname'][$chatbox]}\", \"f\" : \"{$chatbox}\",\"m\" : \"{$message}\"},";
                                $_SESSION['tsChatBoxes'][$chatbox] = 1;
                            }
                    }
                }
            }
    
            $sql = "update chat set recd = 1 where chat.to = '".mysql_real_escape_string($_SESSION['username'])."' and recd = 0";
            $query = mysql_query($sql);
    
            if ($items != '') {
                    $items = substr($items, 0, -1);
            }
            header('Content-type: application/json');
            ?>
            {
                "items": [
                        <?php echo $items;?>
                ]
            }
    
            <?php
            exit(0);
        
    }
        
        function chatBoxSession($chatbox) {
            $items = '';
            if (isset($_SESSION['chatHistory'][$chatbox])) {
                    $items = $_SESSION['chatHistory'][$chatbox];
            }
            return $items;
        }
        
        function startChatSession() {
                $items = '';
                if (!empty($_SESSION['openChatBoxes'])) {
                    foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
                        $items .= $this->chatBoxSession($chatbox);
                    }
                }
                if ($items != '') {
                    $items = substr($items, 0, -1);
                }
                header('Content-type: application/json');
                ?>
                {
                    "username": "<?php echo $_SESSION['username'];?>",
                    "items": [
                            <?php echo $items;?>
                    ]
                }
                <?php 
                exit(0);
            
        }
        
        function sendChat() {
                $from = $_SESSION['username'];
                $nama = $_SESSION['nama'];
                $to = $_POST['to'];
                $message = $_POST['message'];
                $_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
                $messagesan = $this->sanitize($message);
                if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
                    $_SESSION['chatHistory'][$_POST['to']] = '';
                }
                $_SESSION['chatHistory'][$_POST['to']] .= " {\"s\" : \"1\" , \"f\" : \"{$to}\", \"nama\" : \"{$nama}\",\"m\" : \"{$messagesan}\"},";
                unset($_SESSION['tsChatBoxes'][$_POST['to']]);        
                $sql = "insert into chat (chat.from,chat.to,message,sent) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."',NOW())";
                $query = mysql_query($sql);
				
				echo $nama;
                exit(0);
            
        }
        
        function closeChat() {
                unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);
                echo "1";
                exit(0);
            
        }
        
        function sanitize($text) {
            $text = htmlspecialchars($text, ENT_QUOTES);
            $text = str_replace("\n\r","\n",$text);
            $text = str_replace("\r\n","\n",$text);
            $text = str_replace("\n","<br>",$text);
            return $text;
        }
    }
?>