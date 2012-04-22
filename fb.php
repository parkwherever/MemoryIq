<?php
$app_id = "291279594218895";
$app_secret = "33686c29eb9b497851b6be91cc3e6d6d"; 
$my_url = "paintedostrich.com/fb.php";

$code = $_REQUEST["code"];

if(empty($code)) {
$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
  . $app_id . "&redirect_uri=" . urlencode($my_url)."&scope=friends_hometown,friends_location,friends_work_history,friends_education_history";

echo("<script> top.location.href='" . $dialog_url 
  . "'</script>");
}

$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
. $app_id . "&redirect_uri=" . urlencode($my_url) 
. "&client_secret=" . $app_secret 
. "&code=" . $code;

$access_token = file_get_contents($token_url);

$queries = '{"friends":"SELECT uid,current_location FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())","location":"SELECT location FROM page WHERE id IN (SELECT current_location.id FROM #friends)"}';
$queries = '{"query1":"SELECT uid,name FROM user WHERE uid IN(SELECT uid2 FROM friend WHERE uid1=me())","query2":"SELECT uid,message FROM status WHERE uid IN (SELECT uid FROM #query1)"}';
$multiquery = "https://api.facebook.com/method/fql.multiquery?queries=" . urlencode($queries) . "&format=json&" . $access_token;
$res = json_decode(file_get_contents($multiquery), TRUE);
print_r($res);
$final = array();
foreach( $res[1]['fql_result_set'] as $i=>$message_arr ) {
    foreach( $res[0]['fql_result_set'] as $j=>$friend ) {
        if( $message_arr['uid'] == $friend['uid'] ) {
            $friend['message'] = $message_arr['message'];
            $final[] = $friend;
            break;
        }
    }
}
print_r($final);
?>