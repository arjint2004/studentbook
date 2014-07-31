<?php
include_once("dbconfig.php");
include_once("functions.php");

function addCalendar($st, $et, $sub, $ade, $guru, $id_sekolah, $id_mengajar){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
	$qnamapelajaran=mysql_query('SELECT ap.nama, apg.nama as nama_pegawai FROM ak_pelajaran ap JOIN ak_mengajar am JOIN ak_pegawai apg ON ap.id=am.id_pelajaran AND am.id_pegawai=apg.id WHERE am.id='.$id_mengajar.'');
	
	$namamapel=mysql_fetch_array($qnamapelajaran);
	//print_r($namamapel);
	$namsubject="".$namamapel['nama']." (".$namamapel['nama_pegawai'].")";
    $sql = "insert into `ak_jadwal` (`subject`, `starttime`, `endtime`, `isalldayevent`, `id_sekolah`, `id_mengajar`, `id_kelas`) values ('"
      .mysql_real_escape_string($namsubject)."', 
	  '".php2MySqlTime(js2PhpTime($st))."', 
	  '".php2MySqlTime(js2PhpTime($et))."', 
	  '".mysql_real_escape_string($ade)."', 
	  '".$id_sekolah."', 
	  '".$id_mengajar."',
	  '".$_POST['id_kelas']."'
	  )";
    //echo($sql);
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}


function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "insert into `ak_jadwal` (`subject`, `starttime`, `endtime`, `isalldayevent`, `description`, `location`, `color`) values ('"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."', '"
      .mysql_real_escape_string($dscr)."', '"
      .mysql_real_escape_string($loc)."', '"
      .mysql_real_escape_string($color)."' )";
    //echo($sql);
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function listCalendarByRange($sd, $ed){

  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = php2JsTime($sd);
  $ret["end"] = php2JsTime($ed);
  $ret['error'] = null;
  try{
    $db = new DBConnection();
    $db->getConnection();
    //$sql = "select * from `ak_jadwal` where id_kelas='".$_POST['id_kelas']."' AND `starttime` between '" .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'";
    $sql = "
	SELECT aj . *
	FROM `ak_mengajar` am
	JOIN ak_jadwal aj
	JOIN ak_pelajaran ap
	ON ap.id = am.id_pelajaran
	AND aj.id_mengajar=am.id
	WHERE aj.id_kelas='".$_POST['id_kelas']."' 
	AND ap.semester='".$_POST['semester']."' 
	AND aj.`starttime` between '" .php2MySqlTime($sd)."' 
	AND '". php2MySqlTime($ed)."'";
	
    $handle = mysql_query($sql);
    //echo $sql;
    while ($row = mysql_fetch_object($handle)) {
      //$ret['events'][] = $row;
      //$attends = $row->AttendeeNames;
      //if($row->OtherAttendee){
      //  $attends .= $row->OtherAttendee;
      //}
      //echo $row->StartTime;
      $ret['events'][] = array(
        $row->Id,
        $row->Subject,
        php2JsTime(mySql2PhpTime($row->StartTime)),
        php2JsTime(mySql2PhpTime($row->EndTime)),
        $row->IsAllDayEvent,
        0, //more than one day event
        //$row->InstanceType,
        0,//Recurring event,
        $row->Color,
        1,//editable
        $row->Location, 
        ''//$attends
      );
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  return $ret;
}

function listCalendar($day, $type){
  $phpTime = js2PhpTime($day);
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  //echo $st . "--" . $et;
  return listCalendarByRange($st, $et);
}

function updateCalendar($id, $st, $et){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "update `ak_jadwal` set"
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "' "
      . "where `id`=" . $id;
    //echo $sql;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz, $id_sekolah, $id_kelas, $id_mengajar){
  $ret = array();

  try{
    $db = new DBConnection(); 	 	 	
    $db->getConnection();
	
	$qnamapelajaran=mysql_query('SELECT ap.nama, apg.nama as nama_pegawai FROM ak_pelajaran ap JOIN ak_mengajar am JOIN ak_pegawai apg ON ap.id=am.id_pelajaran AND am.id_pegawai=apg.id WHERE am.id='.$id_mengajar.'');
	$namamapel=mysql_fetch_array($qnamapelajaran);
	$namsubject="".$namamapel['nama']." (".$namamapel['nama_pegawai'].")";
	
    $sql = "update `ak_jadwal` set"
      . " `id_sekolah`='" .$id_sekolah. "', "
      . " `id_kelas`='" .$id_kelas. "', "
      . " `id_mengajar`='" .$id_mengajar. "', "
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "', "
      . " `subject`='" . mysql_real_escape_string($namsubject) . "', "
      . " `isalldayevent`='" . mysql_real_escape_string($ade) . "', "
      . " `description`='" . mysql_real_escape_string($dscr) . "', "
      . " `location`='" . mysql_real_escape_string($loc) . "', "
      . " `color`='" . mysql_real_escape_string($color) . "' "
      . "where `id`=" . $id;
    //echo $sql;die();
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function removeCalendar($id){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "delete from `ak_jadwal` where `id`=" . $id;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}




header('Content-type:text/javascript;charset=UTF-8');
$method = $_GET["method"];
switch ($method) {
    case "add":
        $ret = addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"], $_POST["Guru"], $_POST["id_sekolah"], $_POST["id_mengajar"]);
        break;
    case "list":
        //$ret = listCalendar($_POST["showdate"], $_POST["viewtype"]);
        $ret = listCalendar('2/12/2013', 'week');
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break; 
    case "remove":
        $ret = removeCalendar( $_POST["calendarId"]);
        break;
    case "adddetails":
        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
        if(isset($_GET["id"])){
            $ret = updateDetailedCalendar($_GET["id"], $st, $et, 
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"],$_POST["id_sekolah"],$_POST["id_kelas"],$_POST["id_mengajarpegawai"]);
        }else{
            $ret = addDetailedCalendar($st, $et,                    
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }        
        break; 


}
echo json_encode($ret); 



?>