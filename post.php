<!-- THIS IS THE PROJECT PAGE TEMPLATE -->
<?php
require "vendor/config.php";
session_start();
require "./revRedir/checkLog.php";


$id = $_GET["id"];
$post = mysqli_query($db, "SELECT * FROM `projects` WHERE `id` = '$id'");
$post_tradarray = mysqli_fetch_all($post)[0];

// $julkisvu_label = mysqli_fetch_all(mysqli_query($db, "SELECT project_type FROM projects WHERE id = '44'"));
// print_r ($julkisvu_label[0][0]);
// echo '<br>';
// echo 'Julkisivu';


$post = mysqli_query($db, "SELECT * FROM `projects` WHERE `id` = '$id'");
$post = mysqli_fetch_assoc($post);





include('./header.php');
// echo "<form action='' method='post' onsubmit='return false' class='post__form'>";

$usr = $_GET["user"];

$usr_role = mysqli_query($db, "SELECT * FROM `users` WHERE `username`='$usr'; ");
$usr_role = mysqli_fetch_all($usr_role)[0];

$usr_role = $usr_role[3];

if(isset($usr_role) && $usr_role == 'mittaus'){
    include('./templates/2_0.php');
    include('./templates/drawarea.php');
    include('./templates/2_1.php');
    include('./templates/2_2.php');
    include('./templates/2_3.php');
    include('./templates/2_4.php');
    include('./templates/2_5.php');
    include('./templates/2_5-5.php');
    include('./templates/2_5-esikatselu.php');
    include('./templates/2_6.php');
    include('./templates/2_7.php');
    echo '<style> .da_controls_commenting {display: none !important}</style>';
}
else {
    $usr = $_GET['user'];
    if(strtolower($_GET["user"]) == "tyonjohto") {
        $usrpermissions_ = mysqli_query($db, "SELECT * FROM `users` WHERE `username`='$usr';");
        $usrpermissions = mysqli_fetch_all($usrpermissions_);
        $open_comments_ = mysqli_query($db, "SELECT * FROM `comments` WHERE `projectid`=$id AND `ending_time`='' AND `answer_to`=''");
        $_open_comments = mysqli_fetch_all($open_comments_);

        $txt = "";
        foreach ($_open_comments as $value) {
            $txt .= $value[0] . "," . $value[1] . "," . $value[2] . "," . $value[3] . "," . $value[4] . "," .  $value[5] . "," . $value[6] . "," . $value[7] . "," .  $value[8] . "," . $value[9] . "," . $value[10] . "," . $value[11] . "," . $value[12] . "," . $value[13] . "," . $value[14];
            $txt .= "~";
        }
        echo '<input type="hidden" value="' . $txt . '" id="open_comments" name="open_comments">';
        include('./templates/2_0.php');
        include('./templates/drawarea.php');
        include('./templates/commentator.php');
        echo '<style> .drawarea__top,.box,.drawarea__right.recl_btn,.drawarea__controls_one {display: none !important} .da_controls_commenting {display: block !important} .nav li div.nav_current {color:black}</style>';
    } else {
        $usrpermissions_ = mysqli_query($db, "SELECT * FROM `users` WHERE `username`='$usr';");
        $usrpermissions = mysqli_fetch_all($usrpermissions_);
        $open_comments_ = mysqli_query($db, "SELECT * FROM `comments` WHERE `projectid`=$id AND `ending_time`='' AND `answer_to`='' AND `comment_to` LIKE '%$usr%';");
        $_open_comments = mysqli_fetch_all($open_comments_);

        $txt = "";
        foreach ($_open_comments as $value) {
            if ($usrpermissions[0][4] == 0) {
                if ($usrpermissions[0][1] == $value[7] || $usrpermissions[0][1] == $value[8]) {
                    $txt .= $value[0] . "," . $value[1] . "," . $value[2] . "," . $value[3] . "," . $value[4] . "," .  $value[5] . "," . $value[6] . "," . $value[7] . "," .  $value[8] . "," . $value[9] . "," . $value[10] . "," . $value[11] . "," . $value[12] . "," . $value[13] . "," . $value[14];
                    $txt .= "~";
                }
            } else {
                $txt .= $value[0] . "," . $value[1] . "," . $value[2] . "," . $value[3] . "," . $value[4] . "," .  $value[5] . "," . $value[6] . "," . $value[7] . "," .  $value[8] . "," . $value[9] . "," . $value[10] . "," . $value[11] . "," . $value[12] . "," . $value[13] . "," . $value[14];
                $txt .= "~";
            }
        }
        echo '<input type="hidden" value="' . $txt . '" id="open_comments" name="open_comments">';
        include('./templates/2_0.php');
        include('./templates/drawarea.php');
        include('./templates/commentator.php');
        echo '<style> .drawarea__top,.box,.drawarea__right.recl_btn,.drawarea__controls_one {display: none !important} .da_controls_commenting {display: block !important} .nav li div.nav_current {color:black}</style>';
    }
}


// print_r($usrpermissions[0][1]);
// print_r($usrpermissions[0][4]);
echo '<input type="hidden" value="' . strtolower($_GET["user"]) . '" id="current_user" name="current_user">';
echo '<input type="hidden" value="' . (strlen($_GET["role"]) ? strtolower($_GET["role"]) : $usr_role) . '" id="current_role" name="current_role">';
echo '<input type="hidden" value="' . $usrpermissions[0][4] . '" id="current_user_permissions" name="current_user_permissions">';
echo '<input type="hidden" value="' . $id . '" id="current_project_id" name="current_project_id">';
echo '<input type="hidden" value="' . $post_tradarray[4] . '" id="current_project_measurement" name="current_project_measurement">';

$usrs_asiakas = mysqli_query($db, "SELECT * FROM `users`");
$usrs_asiakas = mysqli_fetch_all($usrs_asiakas)[1][1];
echo '<input type="hidden" value="' . $usrs_asiakas . '" id="current_asiakas" name="current_asiakas">';
echo '<input type="hidden" value="" id="listat_list">';

include('./footer-post.php');


        $usr = $_GET["user"];
        echo $usr;

        $user_team_n = mysqli_query($db, "SELECT `company` FROM `users` WHERE `username` LIKE '%$usr%'; ");
        $user_team = mysqli_fetch_all($user_team_n)[0][0];
        echo "USR TEAM".$user_team;
        // this and 2_0 in templ demands setpreset changing
        $set = mysqli_query($db, "SELECT * FROM `settingsmeta` WHERE `meta_key`='s_statussettings';");
        $set = mysqli_fetch_all($set)[0][3];
        $set_array = explode("~~", $set);
        
        $int = 0;
        $array = [];
        foreach ($set_array as $key => $s) {
          $s_array = explode(",",$s);
          foreach ($s_array as $key => $z) {
            if(intval($z === $user_team)) {
              array_push($array,$int);
            }
          }
          $int += 1;
        }

        $old = ["0","1", "2", "3","4","5","6","7","8","9"];
        $new  = ["_f", "_b", "_c","_d","_e","_g","_h","_i","_j","_k"];
        

        foreach ($array as $key => $s) {
          $z =str_replace($old, $new, $s);
          echo '<script> document.querySelectorAll(`.popup__statuses'.$z.'`).forEach(el => el.classList.add(`p_active`));</script>';
        }
echo '<input style="display: none;" value="'.$loggined_usr.'" id="loggined_usr" name="loggined_usr">';
?>
<!-- <script src="./revRedir/revRedir.js"></script> -->
 <script>
function zero_controls_close_reverRedirt() {
	document.querySelector(".zero_popup").classList.add("out")
	document.querySelector(".zero_popup").classList.remove("two")

	mainsite = window.location.host
	prid = document.querySelector("#current_project_id").value
    project_type = document.querySelector("#current_project_measurement").value;

	if (document.querySelector("#usr__selection").value.charAt(0) == " ") {
		selected_user = document
			.querySelector("#usr__selection")
			.value.replace(" ", "")
	} else {
		selected_user = document.querySelector("#usr__selection").value
	}
	console.log(selected_user);
	let loggined_usr = document.querySelector("#loggined_usr").value
	console.log(loggined_usr);
	if (loggined_usr == selected_user){
        if (project_type=='Julkisivu'){
            window.location.replace("http://julkisivut2.gromi.fi/post.php?id=" + prid + "&user=" + selected_user)
        } else {
            window.location.replace("http://" + mainsite + "/post.php?id=" + prid + "&user=" + selected_user)
        }
        //редирект на домен фасадов или на текущий (если авторизован в обоих случаях)
	} else if (loggined_usr == 'noUser'){
        document.location.href = "http://" + mainsite + "/revRedir/sessionFromGet.php?id=" + prid + "&user=" + selected_user;
	} else {
		document.location.href = "http://" + mainsite + "/logout.php";
	}
}
 </script>
