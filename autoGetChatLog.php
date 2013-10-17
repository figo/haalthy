<?php
//header("Content-Type: text/html; charset=utf-8");
$temp_dir = tempnam(sys_get_temp_dir(), 'loginQQ');

// get qq setup info
$qqconf = file('./qq.conf',FILE_SKIP_EMPTY_LINES);
$idTmp = explode('=',$qqconf[0]);
$qqId = trim($idTmp[1]);
$pwdTmp = explode('=',$qqconf[1]);
$qqpwd = trim($pwdTmp[1]);
$gnamesTmp = explode('=',$qqconf[2]);
$gnames = trim($gnamesTmp[1]);

$sqlserverConnect = 0;
$sqlconnect=mysqli_connect("127.0.0.1","root","","forum");
function uin2hex($str){
    $str=intval($str);
    $hex=dechex($str);
    $len=strlen($hex);
    for($i=$len;$i<16;$i++)
	    $hex="0".$hex;
    $arr=array();
    for($i=0;$i<16;$i+=2){
        array_push($arr,"\\x".substr($hex,$i,2));
    }
    $result=implode("",$arr);
    eval("\$temp = \"$result\";");
    return $temp;
}

function hexchar2bin($str){
    $len = strlen($str);
    $arr=array();
    for ($i=0;$i<$len;$i+=2)
    {
	    array_push($arr,"\\x".substr($str,$i,2));
    }
    $result=implode("",$arr);
    eval("\$temp = \"$result\";");
    return $temp;
}
$ptvfsession;
function check_verify($uid)
{
	global $temp_dir;
	global $qqId;
    $ch = curl_init("http://ptlogin2.qq.com/check?uin={$uid}&appid=1003903&js_ver=10046&js_type=0&login_sig=2yl9aqteJokdziSaA7OZdsPLQnwx5fdSbnAufskAnJ7pKWAnIhRIMQDN5RNHBAVs&u1=http%3A%2F%2Fweb2.qq.com%2Floginproxy.html&r=0.7583650903003927");

    $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; pgv_info=pgvReferrer=&ssid=s1599367146; chkuin={$qqId}; uin=o00{$qqId}; skey=@0N4D4Gs3e; ETK=Wd7zGrrwxyI-XFlPxXTeV62pw94asVtCgay2z8FVLE5snIiJcNr2suYCNy0yvzZx7v4sU-ChGKc4pI7Jj8G9Lw__; superuin=o00{$qqId}; superkey=-05J03M5a6vTyCozTA3PhE8rcB*oGKamKychasenxJ8_; supertoken=3311387555; ptisp=os; ptuserinfo=4c696c79; confirmuin={$qqId}; ptvfsession=00cbe4e6206f12ea4dbd4bc0c7ed1384b020075d0c2adcee47f5e3320c6c2d659b74a956a746d49d429d5f3eba1ce693";
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."cookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."cookie");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true); 
    $data = curl_exec($ch);
    //echo $data;
preg_match('/ptvfsession=\w*/', $data, $m);
$cookies = explode('=', $m[0]);
global $ptvfsession;
$ptvfsession = $cookies[1];
    $information = curl_getinfo($ch);
    if (preg_match("/ptui_checkVC\('(.*)','(.*)','(.*)'\);/", $data, $verify))
    {
        $returnArr = array_slice($verify, 1);
        return $returnArr[1];
    }
}

function getQQpwd($uid, $veriCode, $pwd)
{
	return strtoupper(md5(strtoupper(md5(hexchar2bin($pwd).uin2hex($uid))).$veriCode));
}
$ptwebQQ;
$respUrl;
$skey;
function loginQQ($uid, $pwd){
	global $temp_dir;
	global $skey;
	global $qqId;
	$veriCode = check_verify($uid);
	$pwd = getQQpwd($uid, $veriCode, $pwd);
	$temp_dir = tempnam(sys_get_temp_dir(), 'loginQQ');
    $url = "http://ptlogin2.qq.com/login?u={$uid}&p={$pwd}&verifycode={$veriCode}&webqq_type=10&remember_uin=1&login2qq=1&aid=1003903&u1=http%3A%2F%2Fweb2.qq.com%2Floginproxy.html%3Flogin2qq%3D1%26webqq_type%3D10&h=1&ptredirect=0&ptlang=2052&daid=164&from_ui=1&pttype=1&dumy=&fp=loginerroralert&action=1-12-7933&mibao_css=m_webqq&t=1&g=1&js_type=0&js_ver=10048&login_sig=fdpwa0WBwfG5*Nae74oyyY1ey*J9ksAqM91NwioYJBZdTXodlol522byoE-1pxz7";
    //echo $url;
	$ch = curl_init($url);
	global $ptvfsession;
	$cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; pgv_info=pgvReferrer=&ssid=s1599367146; uikey=ed65a10b564da08a9a39ce93d3a7deeca3fdbe80070641c507bf2ab5cba88d14; chkuin={$qqId}; uin=o00{$qqId}; skey=@5qvfd99qw; ETK=; superuin=o00{$qqId}; superkey=ClcoYw9HY2IERkHAoMw43pLhRClmD2DwZJe-8L5XMCE_; supertoken=756008169; ptisp=os; ptuserinfo=4c696c79; confirmuin={$qqId}; ptvfsession={$ptvfsession}; verifysession=h02xn0o2ZFG_gh8_agaZj2_qAqi_wCq09mv97cUeP4g_CeF3IoZ-Ty-iPK7cWJyXwCfDXCCNpzHGa6ylsOG8krVRQ";
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."lgcookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."lgcookie");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true); 
    $data = curl_exec($ch);
   // echo $data;
    $information = curl_getinfo($ch);
    preg_match('/ptwebqq=\w*/', $data, $m);
    $cookies = explode('=', $m[0]);
    global $ptwebQQ;
    $ptwebQQ = $cookies[1];
//    $arr = explode(',', $data);
    preg_match("/ptuiCB\('(.*)','(.*)','(.*)'\);/", $data, $verify);
    $arr = explode(',', $verify[0]);
    global $respUrl;
    $respUrl = substr($arr[2], 1, -1);
    preg_match("/Set-Cookie: skey=[^;]*/", $data, $skeyarr);
    $arr = explode('=', $skeyarr[0]);
    $skey = $arr[1];
}

loginQQ($qqId,$qqpwd);
$psessionid;
$vfwebqq;
$p_skey;
function login2($clientid)
{
    global $ptwebQQ;
    global $temp_dir;
    global $respUrl;
    global $ptvfsession;
    global $skey;
    global $psessionid;
    global $vfwebqq;
    global $p_skey;
    global $qqId;
    $chLgResp = curl_init($respUrl);
    $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s1599367146; uin=o00{$qqId}; skey={$skey}; ptisp=os; p_uin=o00{$qqId}; pt4_token=jTi8KvjiOF6Ptr-pjp-TLA__; verifysession=h02xn0o2ZFG_gh8_agaZj2_qAqi_wCq09mv97cUeP4g_CeF3IoZ-Ty-iPK7cWJyXwCfDXCCNpzHGa6ylsOG8krVRQ**; ptwebqq={$ptwebQQ}";
    //$cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s1599367146; uin=o00{$qqId}; skey=@0N4D4Gs3e; ptisp=os; p_uin=o00{$qqId}; p_skey=Yp5KDMNsgfg6ACPvic45zzYyM6-CI9BiJMPNU5pM-*Q_; pt4_token=jTi8KvjiOF6Ptr-pjp-TLA__; verifysession=h02xn0o2ZFG_gh8_agaZj2_qAqi_wCq09mv97cUeP4g_CeF3IoZ-Ty-iPK7cWJyXwCfDXCCNpzHGa6ylsOG8krVRQ**; ptwebqq={$ptwebQQ}";
    curl_setopt($chLgResp, CURLOPT_COOKIE, $cookie);
    curl_setopt($chLgResp, CURLOPT_COOKIESESSION, true);
    curl_setopt($chLgResp, CURLOPT_COOKIEFILE, $temp_dir."lgrespcookie");
    curl_setopt($chLgResp, CURLOPT_COOKIEJAR, $temp_dir."lgrespcookie");
    curl_setopt($chLgResp, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chLgResp, CURLOPT_HEADER, true);
    curl_setopt($chLgResp, CURLINFO_HEADER_OUT, true); 
    $data = curl_exec($chLgResp);
    preg_match('/p_skey=[^;]*/', $data, $m);
    $arr = explode("=", $m[0]);
    $p_skey = $arr[1];
    $url = "http://d.web2.qq.com/channel/login2";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "r=%7B%22status%22%3A%22online%22%2C%22ptwebqq%22%3A%22{$ptwebQQ}%22%2C%22passwd_sig%22%3A%22%22%2C%22clientid%22%3A%2286495926%22%2C%22psessionid%22%3Anull%7D&clientid={$clientid}%22%2C%22psessionid%22%3Anull%7D&clientid={$clientid}&psessionid=null");
    $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s1599367146; uin=o00{$qqId}; skey={$skey}; ptisp=os; p_uin=o00{$qqId}; p_skey={$p_skey}; pt4_token=jTi8KvjiOF6Ptr-pjp-TLA__; verifysession=h02xn0o2ZFG_gh8_agaZj2_qAqi_wCq09mv97cUeP4g_CeF3IoZ-Ty-iPK7cWJyXwCfDXCCNpzHGa6ylsOG8krVRQ**; ptwebqq={$ptwebQQ}";
//    $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s1599367146; uin=o00{$qqId}; skey=@0N4D4Gs3e; ptisp=os; p_uin=o00{$qqId}; p_skey={$p_skey}; pt4_token=jTi8KvjiOF6Ptr-pjp-TLA__; verifysession=h02xn0o2ZFG_gh8_agaZj2_qAqi_wCq09mv97cUeP4g_CeF3IoZ-Ty-iPK7cWJyXwCfDXCCNpzHGa6ylsOG8krVRQ**; ptwebqq={$ptwebQQ}";
    curl_setopt($ch, CURLOPT_REFERER, "http://d.web2.qq.com/proxy.html?v=20110331002&callback=1&id=2");
//  curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."lg2cookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."lg2cookie");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
//    preg_match('/"psessionid":"[^,]*/', $data, $m);
//    $arr = explode(":", $m[0]);
    //    $psessionid = substr($arr[1], 1, -1);
    $ret = json_decode($data);
    $psessionid = $ret->{'result'}->{'psessionid'};
    $vfwebqq = $ret->{'result'}->{'vfwebqq'};
    return $data;
}
login2("86495929");

function poll($clientid)
{
	global $psessionid;
	global $temp_dir;
    $post = "r=%7B%22clientid%22%3A%22{$clientid}%22%2C%22psessionid%22%3A%22{$psessionid}%22%2C%22key%22%3A0%2C%22ids%22%3A%5B%5D%7D&clientid={$clientid}&psessionid={$psessionid}";
    $ch = curl_init("http://d.web2.qq.com/channel/poll2");
    // 必须要来路域名
    curl_setopt($ch, CURLOPT_REFERER, "http://d.web2.qq.com/proxy.html?v=20110331002&callback=1&id=3");
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."poolcookie");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    return $data;
}

poll("86495929");
$group_name_list;
function get_group_name_list_mask()
{
	global $vfwebqq;
	global $temp_dir;
	global $skey;
	global $p_skey;
	global $ptwebQQ;
    global $qqId;
    global $group_name_list;
    $post = "r=%7B%22vfwebqq%22%3A%22{$vfwebqq}%22%7D";
    $ch = curl_init("http://s.web2.qq.com/api/get_group_name_list_mask2");
    //    $cookie = "	pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s8179519402; ptisp=os; uin=o00{$qqId}; skey={$skey}; p_uin=o00{$qqId}; p_skey={$p_skey}; pt4_token=jAyUx6c80TbFXs*TmjQ-dw__; ptwebqq={$ptwebQQ}";
    $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s8179519402; ptisp=os; uin=o00{$qqId}; skey={$skey}; p_uin=o00{$qqId}; p_skey={$p_skey}; pt4_token=jAyUx6c80TbFXs*TmjQ-dw__; ptwebqq={$ptwebQQ}";
    curl_setopt($ch, CURLOPT_REFERER, "http://s.web2.qq.com/proxy.html?v=20110412001&callback=1&id=3");
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."groupcookie");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    $group_name_list = $data;
}

get_group_name_list_mask();

function getGidByGroupName($gname){
    global $group_name_list;
    $ret = json_decode($group_name_list);
    $groups = $ret->{'result'}->{'gnamelist'};
    $groupsArr = (array)$groups;
    $groupCount = count($groupsArr);
    for($i = 0; $i<$groupCount; $i++){
        $group = $groupsArr[$i];
        if($group->{'name'} == $gname)
        {
            return $group->{'code'};
        }
    }

}

function get_chatlogdates($gcode){
	global $vfwebqq;
	global $temp_dir;
	global $qqId;
	global $skey;
	global $p_skey;
	global $ptwebQQ;
    $url = "http://cgi.web2.qq.com/keycgi/top/chatlogdates?gid=".$gcode."&vfwebqq={$vfwebqq}&t=1381193104174";
	$ch = curl_init($url);
	 $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s8179519402; ptisp=os; uin=o00{$qqId}; skey={$skey}; p_uin=o00{$qqId}; p_skey={$p_skey}; pt4_token=6o3fT5G40*7abJ7GdzH2bA__; ptwebqq={$ptwebQQ}";
    //$cookie = "	pgv_pvid=2152677377; pt2gguin=o0039376963; o_cookie=16481189; ptui_loginuin=39376963; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s8179519402; ptisp=os; uin=o0039376963; skey=@nreo2KVM7; p_uin=o0039376963; p_skey=IPxlhHGIg-bBbUNOvqM2022v3BVmJ3Ewpfkig3-NaBM_; pt4_token=6o3fT5G40*7abJ7GdzH2bA__; ptwebqq=6d2fd0c085542d07bb8bf7f4baa79d29660063f1a4ee93622e2d96";
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."chatlogdatescookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."chatlogdatescookie");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_HEADER, true);
    //curl_setopt($ch, CURLINFO_HEADER_OUT, true); 
    curl_setopt($ch, CURLOPT_REFERER, "http://d.web2.qq.com/proxy.html?v=20110331002&callback=1&id=2");
    $data = curl_exec($ch);
    return $data;
}

function get_group_chatlog($gname){
	global $qqId;
	global $ptwebQQ;
	global $p_skey;
    global $skey;
    global $vfwebqq;
    global $sqlconnect;
    $gcode = getGidByGroupName($gname);
    $dates = get_chatlogdates($gcode);
    //echo $dates;
    $dateJson = json_decode($dates);
    $dateInfo = $dateJson->{'result'}->{'info'};
    $dateArr = (array)$dateInfo;
    $retLog;
    $dateCount = count($dateArr);
    for($i = 0; $i<$dateCount; $i++){
        $date = $dateArr[$i];
        $today = new DateTime("Asia/Shanghai");
//        $tz = new DateTimeZone('Asia/Shanghai');
//        $today->setTimeZone($tz);
        $todayDate = $today->format('Ymd');
        if($date->{'ymd'} < $todayDate)
            continue;
        //$lastEndSeq = file_get_contents("./chatLog/qqLog.".$gname.".endSeq".".txt");
        $lastEndSeq = file_get_contents("./qqLog.".$gname.".endSeq.txt");
        $begseq = $lastEndSeq > $date->{'begseq'}?$lastEndSeq:$date->{'begseq'};
        if($begseq>=$date->{'endseq'})
            continue;
        //echo $begseq.'<br>';
        $url = "http://cgi.web2.qq.com/keycgi/top/groupchatlog?ps=10&bs=".$begseq."&es=".$date->{'endseq'}."&gid=".$gcode."&mode=1&vfwebqq={$vfwebqq}&t=1381190020016";
	    global $temp_dir;
	    $ch = curl_init($url);
        $cookie = "	pgv_pvid=2152677377; pt2gguin=o0039376963; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; hideusehttpstips=1; pgv_info=pgvReferrer=&ssid=s8179519402; ptisp=os; uin=o00{$qqId}; skey={$skey}; p_uin=o00{$qqId}; p_skey={$p_skey}; pt4_token=6o3fT5G40*7abJ7GdzH2bA__; ptwebqq={$ptwebQQ}";
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."lgcookie");
        curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."lgcookie");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true); 
        curl_setopt($ch, CURLOPT_REFERER, "http://d.web2.qq.com/proxy.html?v=20110331002&callback=1&id=2");
        $data = curl_exec($ch);
        if($sqlconnect){
            $chatJson = json_decode($data);
            $chatArr = $chatJson->{'result'}->{'data'}->{'cl'}[0]->{'cl'};
            //print_r($chatArr);
            $chatCount = count($chatJson->{'result'}->{'data'}->{'cl'}[0]->{'cl'});
            //echo $chatCount.'<br>';
            for($i = 0; $i<$chatCount; $i++){
                $qqId = $chatArr[$i]->{'u'};
                $time = date('Y-m-d h:i:s', $chatArr[$i]->{'t'});
                $il = $chatArr[$i]->{'il'};
                for($j = 0; $j<count($il); $j++){
                    if($il[$j]->{'t'}==0){
                //        echo 'group name '.$gname;
                        $insertSql = "INSERT INTO qqChatLog (QQID,content,time,groupName) values ('".$qqId."','".$il[$j]->{'v'}."','".$time."','".$gname."')";
                //        echo $insertSql;
                        mysqli_query($sqlconnect, $insertSql); 
                    }
                }                
            }
        }else{
            file_put_contents("./chatLog/qqLog.".$gname.".".$date->{'ymd'}.".txt", $data, FILE_APPEND);
        }
        file_put_contents("./qqLog.".$gname.".endSeq".".txt", $date->{'endseq'});
    }
}

function getAllGroupsChatLog(){
    global $gnames;
    $gidsArr = explode(',', $gnames);
    foreach($gidsArr as $gname){
        echo $gname;
        get_group_chatlog($gname);    
    }
}
getAllGroupsChatLog();
if($sqlconnect)
    mysqli_close($sqlconnect);
?>
