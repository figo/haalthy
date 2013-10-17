<!DOCTYPE html>
<html>
<head>
<script>
function hexchar2bin(str)
{var arr=[];
for(var i=0;i<str.length;i=i+2)
{arr.push("\\x"+str.substr(i,2))}
arr=arr.join("");
eval("var temp = '"+arr+"'");
return temp}
 
function uin2hex(str)
{var maxLength=16;str=parseInt(str);
var hex=str.toString(16);
var len=hex.length;
for(var i=len;i<maxLength;i++)
{hex="0"+hex}
var arr=[];for(var j=0;j<maxLength;j+=2)
{arr.push("\\x"+hex.substr(j,2))}
var result=arr.join("");
eval('result="'+result+'"');
return result;
}

var hexcase=1;var b64pad="";var chrsz=8;var mode=32;function md5(A){return hex_md5(A)}function hex_md5(A){return binl2hex(core_md5(str2binl(A),A.length*chrsz))}function str_md5(A){return binl2str(core_md5(str2binl(A),A.length*chrsz))}function hex_hmac_md5(A,B){return binl2hex(core_hmac_md5(A,B))}function b64_hmac_md5(A,B){return binl2b64(core_hmac_md5(A,B))}function str_hmac_md5(A,B){return binl2str(core_hmac_md5(A,B))}function core_md5(K,F){K[F>>5]|=128<<((F)%32);K[(((F+64)>>>9)<<4)+14]=F;var J=1732584193;var I=-271733879;var H=-1732584194;var G=271733878;for(var C=0;C<K.length;C+=16){var E=J;var D=I;var B=H;var A=G;J=md5_ff(J,I,H,G,K[C+0],7,-680876936);G=md5_ff(G,J,I,H,K[C+1],12,-389564586);H=md5_ff(H,G,J,I,K[C+2],17,606105819);I=md5_ff(I,H,G,J,K[C+3],22,-1044525330);J=md5_ff(J,I,H,G,K[C+4],7,-176418897);G=md5_ff(G,J,I,H,K[C+5],12,1200080426);H=md5_ff(H,G,J,I,K[C+6],17,-1473231341);I=md5_ff(I,H,G,J,K[C+7],22,-45705983);J=md5_ff(J,I,H,G,K[C+8],7,1770035416);G=md5_ff(G,J,I,H,K[C+9],12,-1958414417);H=md5_ff(H,G,J,I,K[C+10],17,-42063);I=md5_ff(I,H,G,J,K[C+11],22,-1990404162);J=md5_ff(J,I,H,G,K[C+12],7,1804603682);G=md5_ff(G,J,I,H,K[C+13],12,-40341101);H=md5_ff(H,G,J,I,K[C+14],17,-1502002290);I=md5_ff(I,H,G,J,K[C+15],22,1236535329);J=md5_gg(J,I,H,G,K[C+1],5,-165796510);G=md5_gg(G,J,I,H,K[C+6],9,-1069501632);H=md5_gg(H,G,J,I,K[C+11],14,643717713);I=md5_gg(I,H,G,J,K[C+0],20,-373897302);J=md5_gg(J,I,H,G,K[C+5],5,-701558691);G=md5_gg(G,J,I,H,K[C+10],9,38016083);H=md5_gg(H,G,J,I,K[C+15],14,-660478335);I=md5_gg(I,H,G,J,K[C+4],20,-405537848);J=md5_gg(J,I,H,G,K[C+9],5,568446438);G=md5_gg(G,J,I,H,K[C+14],9,-1019803690);H=md5_gg(H,G,J,I,K[C+3],14,-187363961);I=md5_gg(I,H,G,J,K[C+8],20,1163531501);J=md5_gg(J,I,H,G,K[C+13],5,-1444681467);G=md5_gg(G,J,I,H,K[C+2],9,-51403784);H=md5_gg(H,G,J,I,K[C+7],14,1735328473);I=md5_gg(I,H,G,J,K[C+12],20,-1926607734);J=md5_hh(J,I,H,G,K[C+5],4,-378558);G=md5_hh(G,J,I,H,K[C+8],11,-2022574463);H=md5_hh(H,G,J,I,K[C+11],16,1839030562);I=md5_hh(I,H,G,J,K[C+14],23,-35309556);J=md5_hh(J,I,H,G,K[C+1],4,-1530992060);G=md5_hh(G,J,I,H,K[C+4],11,1272893353);H=md5_hh(H,G,J,I,K[C+7],16,-155497632);I=md5_hh(I,H,G,J,K[C+10],23,-1094730640);J=md5_hh(J,I,H,G,K[C+13],4,681279174);G=md5_hh(G,J,I,H,K[C+0],11,-358537222);H=md5_hh(H,G,J,I,K[C+3],16,-722521979);I=md5_hh(I,H,G,J,K[C+6],23,76029189);J=md5_hh(J,I,H,G,K[C+9],4,-640364487);G=md5_hh(G,J,I,H,K[C+12],11,-421815835);H=md5_hh(H,G,J,I,K[C+15],16,530742520);I=md5_hh(I,H,G,J,K[C+2],23,-995338651);J=md5_ii(J,I,H,G,K[C+0],6,-198630844);G=md5_ii(G,J,I,H,K[C+7],10,1126891415);H=md5_ii(H,G,J,I,K[C+14],15,-1416354905);I=md5_ii(I,H,G,J,K[C+5],21,-57434055);J=md5_ii(J,I,H,G,K[C+12],6,1700485571);G=md5_ii(G,J,I,H,K[C+3],10,-1894986606);H=md5_ii(H,G,J,I,K[C+10],15,-1051523);I=md5_ii(I,H,G,J,K[C+1],21,-2054922799);J=md5_ii(J,I,H,G,K[C+8],6,1873313359);G=md5_ii(G,J,I,H,K[C+15],10,-30611744);H=md5_ii(H,G,J,I,K[C+6],15,-1560198380);I=md5_ii(I,H,G,J,K[C+13],21,1309151649);J=md5_ii(J,I,H,G,K[C+4],6,-145523070);G=md5_ii(G,J,I,H,K[C+11],10,-1120210379);H=md5_ii(H,G,J,I,K[C+2],15,718787259);I=md5_ii(I,H,G,J,K[C+9],21,-343485551);J=safe_add(J,E);I=safe_add(I,D);H=safe_add(H,B);G=safe_add(G,A)}if(mode==16){return Array(I,H)}else{return Array(J,I,H,G)}}function md5_cmn(F,C,B,A,E,D){return safe_add(bit_rol(safe_add(safe_add(C,F),safe_add(A,D)),E),B)}function md5_ff(C,B,G,F,A,E,D){return md5_cmn((B&G)|((~B)&F),C,B,A,E,D)}function md5_gg(C,B,G,F,A,E,D){return md5_cmn((B&F)|(G&(~F)),C,B,A,E,D)}function md5_hh(C,B,G,F,A,E,D){return md5_cmn(B^G^F,C,B,A,E,D)}function md5_ii(C,B,G,F,A,E,D){return md5_cmn(G^(B|(~F)),C,B,A,E,D)}function core_hmac_md5(C,F){var E=str2binl(C);if(E.length>16){E=core_md5(E,C.length*chrsz)}var A=Array(16),D=Array(16);for(var B=0;B<16;B++){A[B]=E[B]^909522486;D[B]=E[B]^1549556828}var G=core_md5(A.concat(str2binl(F)),512+F.length*chrsz);return core_md5(D.concat(G),512+128)}function safe_add(A,D){var C=(A&65535)+(D&65535);var B=(A>>16)+(D>>16)+(C>>16);return(B<<16)|(C&65535)}function bit_rol(A,B){return(A<<B)|(A>>>(32-B))}function str2binl(D){var C=Array();var A=(1<<chrsz)-1;for(var B=0;B<D.length*chrsz;B+=chrsz){C[B>>5]|=(D.charCodeAt(B/chrsz)&A)<<(B%32)}return C}function binl2str(C){var D="";var A=(1<<chrsz)-1;for(var B=0;B<C.length*32;B+=chrsz){D+=String.fromCharCode((C[B>>5]>>>(B%32))&A)}return D}function binl2hex(C){var B=hexcase?"0123456789ABCDEF":"0123456789abcdef";var D="";for(var A=0;A<C.length*4;A++){D+=B.charAt((C[A>>2]>>((A%4)*8+4))&15)+B.charAt((C[A>>2]>>((A%4)*8))&15)}return D}function binl2b64(D){var C="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";var F="";for(var B=0;B<D.length*4;B+=3){var E=(((D[B>>2]>>8*(B%4))&255)<<16)|(((D[B+1>>2]>>8*((B+1)%4))&255)<<8)|((D[B+2>>2]>>8*((B+2)%4))&255);for(var A=0;A<4;A++){if(B*8+A*6>D.length*32){F+=b64pad}else{F+=C.charAt((E>>6*(3-A))&63)}}}return F}

var xmlHttp = null;

function getVeriCode()
{
    var Url = "http://ptlogin2.qq.com/check?uin=39376963&appid=1003903&js_ver=10046&js_type=0&login_sig=2yl9aqteJokdziSaA7OZdsPLQnwx5fdSbnAufskAnJ7pKWAnIhRIMQDN5RNHBAVs&u1=http%3A%2F%2Fweb2.qq.com%2Floginproxy.html&r=0.7583650903003927";
    xmlHttp = new XMLHttpRequest(); 
    xmlHttp.withCredentials = true;
    xmlHttp.onreadystatechange = ProcessRequest;
    xmlHttp.open( "GET", Url, true );
    xmlHttp.send();
}

function ProcessRequest() 
{
    if (xmlHttp.readyState == 4  && xmlHttp.status == 200) 
    {
//        alert(xmlHttp.status);
        //return xmlHttp.responseText;
        analyzeVeriCode();
    }
}

function analyzeVeriCode(){
    var paras1 = new Array();
    paras1 = xmlHttp.responseText.split("(");
//    alert(xmlHttp.responseText);
    var paras2 = paras1[1].split(",");
    var vc = paras2[1].substring(1, 5);
//    alert(vc);
    loginQQ(md5(md5(hexchar2bin(md5("fili99q1w2E#R$"))+uin2hex("39376963"))+vc), vc);
}

//getVeriCode();
var loginQQHttp;

function loginQQ(pwd, veriCode){
    var Url = "http://ptlogin2.qq.com/login?u=39376963&p="+pwd+"&verifycode="+veriCode+"&webqq_type=10&remember_uin=1&login2qq=1&aid=1003903&u1=http%3A%2F%2Fweb2.qq.com%2Floginproxy.html%3Flogin2qq%3D1%26webqq_type%3D10&h=1&ptredirect=0&ptlang=2052&daid=164&from_ui=1&pttype=1&dumy=&fp=loginerroralert&action=2-15-16887&mibao_css=m_webqq&t=1&g=1&js_type=0&js_ver=10046&login_sig=2yl9aqteJokdziSaA7OZdsPLQnwx5fdSbnAufskAnJ7pKWAnIhRIMQDN5RNHBAVs";
    loginQQHttp = new XMLHttpRequest(); 
    loginQQHttp.onreadystatechange = getLoginRequest;
    loginQQHttp.open( "GET", Url, true );
    loginQQHttp.send( null ); 
}
function getLoginRequest(){
    if ( loginQQHttp.readyState == 4 && loginQQHttp.status == 200 ) 
    {
        //return xmlHttp.responseText;
        msgTip();
        return loginQQHttp.responseText;
    }
}

var msgTipHttpresq = null;
function msgTip(){
    var Url = "http://web2.qq.com/web2/get_msg_tip?uin=&tp=1&id=0&retype=1&rc=416&lv=3&t=1379717542760";
    msgTipHttpresq = new XMLHttpRequest(); 
    msgTipHttpresq.onreadystatechange = getMsgTip;
    msgTipHttpresq.open( "GET", Url, true );
    msgTipHttpresq.send( null ); 
}

function getMsgTip(){
    if ( msgTipHttpresq.readyState == 4 && msgTipHttpresq.status == 200 ) {

        var Url = "http://d.web2.qq.com/channel/login2";
	   var paras = new Object();
	   paras["clientid"] = "19425597";
	   paras["psessionid"] = null;
	   paras["r"] = '{"status":"online","ptwebqq":"a86d8dde69fbabd415b6b7b27567ccacd43df74ca85911d0972c55d3f075fa7d","passwd_sig":"","clientid":"19425597","psessionid":null}';
	   post_to_url(Url,paras,null);
    }
}

function post_to_url(path, params, method) {
        alert("test");
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}

//getVeriCode();
</script>
</head>
<body>

<button type="button" onclick="getVeriCode()">QQ</button>

</body>
</html> 

<?php
//$getVeriCode = file_get_contents("http://ptlogin2.qq.com/check?uin=39376963&appid=1002101&r=0.8849248");
//print_r($getVeriCode);

///$xml = file_get_contents("http://ptlogin2.qq.com/login?u=39376963&p=D1AE529564E3226382A44A131E6E8625&verifycode=!AEB&aid=1002101");
//echo file_put_contents("test.png", file_get_contents("http://captcha.qq.com/getimage?aid=1003903&r=0.4113517610392986&uin=1541208587"));
$data = file_get_contents("http://captcha.qq.com/getimage?aid=1003903&r=0.4113517610392986&uin=1541208587");
file_put_contents("/tmp/test.png", $data);
?>
