<?php
$qqId = $_GET['qqId'];
    $temp_dir = tempnam(sys_get_temp_dir(), 'loginQQ');
    $ch = curl_init("http://captcha.qq.com/getimage?aid=1003903&r=0.4113517610392986&uin=".$qqId);
    echo $ch;
    $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; pgv_info=pgvReferrer=&ssid=s1599367146; chkuin={$qqId}; uin=o00{$qqId}; skey=@0N4D4Gs3e; ETK=Wd7zGrrwxyI-XFlPxXTeV62pw94asVtCgay2z8FVLE5snIiJcNr2suYCNy0yvzZx7v4sU-ChGKc4pI7Jj8G9Lw__; superuin=o00{$qqId}; superkey=-05J03M5a6vTyCozTA3PhE8rcB*oGKamKychasenxJ8_; supertoken=3311387555; ptisp=os; ptuserinfo=4c696c79; confirmuin={$qqId}; ptvfsession=00cbe4e6206f12ea4dbd4bc0c7ed1384b020075d0c2adcee47f5e3320c6c2d659b74a956a746d49d429d5f3eba1ce693";
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."cookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."cookie");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, "https://ui.ptlogin2.qq.com/cgi-bin/login?daid=164&target=self&style=5&mibao_css=m_webqq&appid=1003903&enable_qlogin=0&no_verifyimg=1&s_url=http%3A%2F%2Fweb2.qq.com%2Floginproxy.html&f_url=loginerroralert&strong_login=1&login_state=10&t=20130903001");
//    curl_setopt($ch, CURLOPT_HEADER, true);
//    curl_setopt($ch, CURLINFO_HEADER_OUT, true); 
    $data = curl_exec($ch);
//echo $data;
    //file_put_contents("veriImage".$qqId.".png", file_get_contents("http://captcha.qq.com/getimage?aid=1003903&r=0.4113517610392986&uin=".$qqId));
    file_put_contents("veriImage".$qqId.".png", $data);
?>
