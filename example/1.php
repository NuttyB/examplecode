<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <body>
<?php
function fetch($source, $start, $smlen, $stop, $fail) {
$data = @implode('', @file($source));
$data = strip_tags($data);
$data = strtolower($data);
$data = str_replace("\n", '', $data);
$data = str_replace("\r", '', $data);
if(substr_count($data, $fail)) {return 0;}
else {
    $data = substr($data, strpos($data, $start)+$smlen);
    $data = substr($data, 0, strpos($data, $stop));
    return trim($data);
    }
}

function GooglePageRank($url){
$arr = parse_url($url);
$url = $arr['host'];
$url="info:".$url; $ch=GoogleCSum($url,0xE6359A60);
$host="toolbarqueries.google.com"; $hostip=gethostbyname($host);
$query ="GET /search?client=navclient-auto&ch=6".$ch."&ie=UTF-8&oe=UTF-8&features=Rank&q=".rawurlencode($url)." HTTP/1.0\r\n";
$query.="Host: $host\r\n"; $rank=-1;
$query.="User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\r\n";
$query.="Connection: Close\r\n\r\n";
$fp=fsockopen($hostip,80,$errno,$errstr,30);
if ($fp){
    fputs($fp,$query); $data=""; while (!feof($fp)) $data.=fgets($fp,4096); fclose($fp);
    $data=explode("\n",$data);
    foreach ($data as $line)
        if (!is_bool(strpos($line,"Rank_1"))){
            $rank=explode(":",trim($line)); $rank=$rank[2]; break;
            }
    }
return $rank;
}

function GoogleCSum($s,$key){
$v4=$len=strlen($s); $esi=$key; $ebx=$edi=0x9E3779B9; $p=0;
if ($len>=12)
for($i=0;$i<floor($len/12);$i++){
$edi=unsign($edi+ord($s[$p+4])+(ord($s[$p+5]) << 8)+(ord($s[$p+6]) << 16)+(ord($s[$p+7]) << 24));
$esi=unsign($esi+ord($s[$p+8])+(ord($s[$p+9]) << 8)+(ord($s[$p+10]) << 16)+(ord($s[$p+11]) << 24));
$edx=unsign(($ebx+ord($s[$p+0])+(ord($s[$p+1]) << 8)+(ord($s[$p+2]) << 16)+(ord($s[$p+3]) << 24)-$edi-$esi)^shr($esi,13));
$edi=unsign(($edi-$esi-$edx)^($edx << 8));
$esi=unsign(($esi-$edx-$edi)^shr($edi,13));
$edx=unsign(($edx-$edi-$esi)^shr($esi,12));
$edi=unsign(($edi-$esi-$edx)^($edx << 16));
$esi=unsign(($esi-$edx-$edi)^shr($edi,5));
$edx=unsign(($edx-$edi-$esi)^shr($esi,3)); $ebx=$edx;
$edi=unsign(($edi-$esi-$ebx)^($ebx << 10));
$esi=unsign(($esi-$ebx-$edi)^shr($edi,15));
$v4-=12; $p+=12;
}
$esi=unsign($esi+$len);
if ($v4>=11) $esi=unsign($esi+(ord($s[$p+10]) << 24));
if ($v4>=10) $esi=unsign($esi+(ord($s[$p+9]) << 16));
if ($v4>=9) $esi=unsign($esi+(ord($s[$p+8]) << 8));
if ($v4>=8) $edi=unsign($edi+ord($s[$p+4])+(ord($s[$p+5]) << 8)+(ord($s[$p+6]) << 16)+(ord($s[$p+7]) << 24));
else
{ if ($v4>=7) $edi=unsign($edi+(ord($s[$p+6]) << 16));
if ($v4>=6) $edi=unsign($edi+(ord($s[$p+5]) << 8));
if ($v4>=5) $edi=unsign($edi+ord($s[$p+4])); }
if ($v4>=4) $ebx=unsign($ebx+ord($s[$p+0])+(ord($s[$p+1]) << 8)+(ord($s[$p+2]) << 16)+(ord($s[$p+3]) << 24));
else
{ if ($v4>=3) $ebx=unsign($ebx+(ord($s[$p+2]) << 16));
if ($v4>=2) $ebx=unsign($ebx+(ord($s[$p+1]) << 8));
if ($v4>=1) $ebx=unsign($ebx+ord($s[$p+0])); }
$ebx=unsign(($ebx-$edi-$esi)^shr($esi,13));
$edi=unsign(($edi-$esi-$ebx)^($ebx << 8));
$esi=unsign(($esi-$ebx-$edi)^shr($edi,13));
$ebx=unsign(($ebx-$edi-$esi)^shr($esi,12));
$edi=unsign(($edi-$esi-$ebx)^($ebx << 16));
$esi=unsign(($esi-$ebx-$edi)^shr($edi,5));
$ebx=unsign(($ebx-$edi-$esi)^shr($esi,3));
$edi=unsign(($edi-$esi-$ebx)^($ebx << 10));
$esi=unsign(($esi-$ebx-$edi)^shr($edi,15)); return $esi;
}
function shr($x,$y) {
   $x=unsign($x);
   for($i=0;$i<$y;$i++) $x=floor($x/2);
   return $x;
}
function unsign($l) {
   $l=intval($l);
   if ($l>=0){return $l;}
   else{return 4294967296+$l;}
}


if( $website ){
if( !strstr($website,'http://') && !strstr($website,'https://') ){
    $website = 'http://'.$website;
    }
$pr = GooglePageRank($website);
$indexed = $indexedpages[google][0];
$links = $linkedpages[google][0];
$data = [];
$target = trim(preg_replace('#http://#i', '', $website));
// checking Google
$source = 'http://www.google.com/search?hl=en&lr=&ie=UTF-8&q=link%3A'.$target;
$data['Google'] = array(fetch($source, 'of about', 9, 'linking', 'did not match any documents'), $source);
print_r ($data['Google']);
}
?>





</body>
</html>