<?

/*
Based on the work by Nick Ciske http://nickciske.com/blog/
Modifications by GSucho

WARNING:
You could really piss off the recipient of the traffic this can generate.
I take *no responsibility* for what you do with this, it's a proof of concept, use it at your own risk!

USE:
http://localhost/podcast/index.php?url=***
where *** is your favorite weblog that links mp3 (aka mp3blog)
*/

$url=$_GET['url'];
$contents= curl_get_file_contents($url);

preg_match("/<title>(.*)<\/title>/i",substr($contents,stripos($contents,"<title>"),stripos($contents,"</title>")-9),$match);
$title=replaceRSS(strip_tags($match[0]));

if ($title=="") {
			$title = explode("/",str_replace("http://","",$url));
			$title=$title[0];
}
    
Header("Content-type: text/plain"); 

?>
<rss version="2.0">
	<channel>
		<title><?echo $title?></title>
		<link><?echo $url?></link>
		<description></description>
		<language>en</language>
		<copyright></copyright>
		<lastBuildDate><?echo date("r")?></lastBuildDate>
<?

$regex = "/a[\s]+[^>]*?href[\s]?=[\s\"\']+(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/i";

$objcount=0;
$preg=preg_match_all($regex, $contents, $links);

if ($preg) {
	for ($c=0; $c< count( $links[0] ); $c++) {

		$url     = $links[1][$c];
		
		$name = cleanHTML($links[2][$c]);

		if ($name=="link"||$name=="clip"||$name=="here"||$name=="m"||$name=="mp3"||$name=="MP3"||$name=="play"||$name=="download"||$name=="video"||stristr($name,"CLICK TO")!=false||$name=="Ver video"||$name=="Ver video."||$name=="QT Link"||$name=="MP3"||$name=="Quicktime"||stristr($name,"Download")!=false||stristr($name,"..&gt;")!=false||stristr($name,"..>")!=false||$name=="music video"||$name=="Watch it (.mov)"||stristr($name,"Quicktime")||stristr($name,"http://")!=false) {$name="";}

		$last4char=substr($url, strlen($url)-4, strlen($url));

		if ($last4char==".mp3"||$last4char==".mov"||$last4char==".mp4"||$last4char==".pdf"||$last4char==".mpg"){


		$objcount++;
		//if ($objcount>1) break;

					$inipath = explode("/",str_replace("http://","",$_GET['url']));

					if ($url{0}=="/") { $url="http://".$inipath[0].$url; }
					else {
							if (stristr($url,"http://")==false) {
									$url=$_GET['url'].$url;
							}
					}

					$path_parts = pathinfo($url);
					$titulo = explode(".",$path_parts['basename']);

					//$stripedurl=substr($url,0,strpos($url,$titulo[0])+strlen($titulo[0])+4);
					$stripedurl=$url;
							
					if ($name=="") {
						$name=cleanHTML($links[1][$c]);
						if ( stristr($name, "http:") ){
							$slashpos=strrpos($name,"/")+1;
							$name=substr($name, $slashpos, strlen($name)-$slashpos-4); 
						}
					}
		
					if (stristr($stripedurl,"http://")!=false) {
							$stripedurl=substr($stripedurl,7);
					}
					
						
					echo "<item>\n";
					echo "	<title>".replaceRSS(urldecode($name))."</title>\n";
					if (stristr($stripedurl,".php")!=false) { 
						echo "	<description><![CDATA[http://".urldecode($stripedurl)."]]></description>\n";
						echo "	<enclosure url=\""."http://".urldecode($stripedurl)."\"/>\n";
					} else {
						echo "	<description><![CDATA[http://".doURL(urldecode($stripedurl))."]]></description>\n";
						echo "	<enclosure url=\""."http://".doURL(urldecode($stripedurl))."\"/>\n";
					}
					echo "</item>\n";
		}
	}
}

$regex = "/enclosure[\s]+[^>]*?url[\s]?=[\s\"\']+(.*?)[\"\']+.*?\/>/i";

$objcount=0;
$preg=preg_match_all($regex, $contents, $links);

if ($preg) {
	for ($c=0; $c< count( $links[0] ); $c++) {

		$url     = $links[1][$c];
		
		$name = cleanHTML($links[2][$c]);

		if ($name=="link"||$name=="clip"||$name=="here"||$name=="m"||$name=="mp3"||$name=="MP3"||$name=="play"||$name=="download"||$name=="video"||stristr($name,"CLICK TO")!=false||$name=="Ver video"||$name=="Ver video."||$name=="QT Link"||$name=="MP3"||$name=="Quicktime"||stristr($name,"Download")!=false||stristr($name,"..&gt;")!=false||stristr($name,"..>")!=false||$name=="music video"||$name=="Watch it (.mov)"||stristr($name,"Quicktime")||stristr($name,"http://")!=false) {$name="";}

		$last4char=substr($url, strlen($url)-4, strlen($url));

		if ($last4char==".mp3"||$last4char==".mov"||$last4char==".mp4"||$last4char==".pdf"||$last4char==".mpg"){


		$objcount++;
		//if ($objcount>1) break;

					$inipath = explode("/",str_replace("http://","",$_GET['url']));

					if ($url{0}=="/") { $url="http://".$inipath[0].$url; }
					else {
							if (stristr($url,"http://")==false) {
									$url=$_GET['url'].$url;
							}
					}

					$path_parts = pathinfo($url);
					$titulo = explode(".",$path_parts['basename']);

					//$stripedurl=substr($url,0,strpos($url,$titulo[0])+strlen($titulo[0])+4);
					$stripedurl=$url;
							
					if ($name=="") {
						$name=cleanHTML($links[1][$c]);
						if ( stristr($name, "http:") ){
							$slashpos=strrpos($name,"/")+1;
							$name=substr($name, $slashpos, strlen($name)-$slashpos-4); 
						}
					}
		
					if (stristr($stripedurl,"http://")!=false) {
							$stripedurl=substr($stripedurl,7);
					}
					
						
					echo "<item>\n";
					echo "	<title>".replaceRSS(urldecode($name))."</title>\n";
					if (stristr($stripedurl,".php")!=false) { 
						echo "	<description><![CDATA[http://".urldecode($stripedurl)."]]></description>\n";
						echo "	<enclosure url=\""."http://".urldecode($stripedurl)."\"/>\n";
					} else {
						echo "	<description><![CDATA[http://".doURL(urldecode($stripedurl))."]]></description>\n";
						echo "	<enclosure url=\""."http://".doURL(urldecode($stripedurl))."\"/>\n";
					}
					echo "</item>\n";
		}
	}
}		

////////////////////////////////////////////////////////////////////////////////
function unhtmlspecialchars( $string )
{
  $string = str_replace ( '&amp;', '&', $string );
  $string = str_replace ( '&#039;', '\'', $string );
  $string = str_replace ( '&quot;', '"', $string );
  $string = str_replace ( '&lt;', '<', $string );
  $string = str_replace ( '&gt;', '>', $string );
  $string = str_replace ( '&uuml;', 'u', $string );
  $string = str_replace ( '&Uuml;', 'U', $string );
  $string = str_replace ( '&auml;', 'a', $string );
  $string = str_replace ( '&Auml;', 'A ', $string );
  $string = str_replace ( '&ouml;', 'o', $string );
  $string = str_replace ( '&Ouml;', 'O', $string );
  $string = str_replace ( '&Ccedil;', 'C', $string );
  $string = str_replace ( '&ccedil;', 'c', $string );
  return $string;
}

////////////////////////////////////////////////////////////////////////////////

function inversEntities($text) { // Rückwandlung von "&auml;" zu "ä" etc.
	$table = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
	$reverse = array_flip($table);
	$text = strtr($text,$reverse);
	return $text;
}

////////////////////////////////////////////////////////////////////////////////
function htmldecode($encoded) { 
   return strtr($encoded,(get_html_translation_table(HTML_ENTITIES))); 
}
////////////////////////////////////////////////////////////////////////////////

function replaceRSS($text) { // Ersetzung problematischer Zeichen
$tausch = array (
"\"" => "", 
"  " => " ",
"`" => "'",
"´" => "'",
"'" => "'",
"?" => "'", 
"???" => '"',
"?" => '"',
"?" => "-",
"?" => "-",
"ä" => "a",
"ë" => "e",
"ï" => "i",
"ö" => "o",
"ü" => "u",
"Ä" => "A",
"Ë" => "E",
"Ï" => "I",
"Ö" => "O",
"Ü" => "U",
"&" => "+",
"_" => " ");

$text = str_replace ( '&#8220;', '', $text ); // Comillas imprenta abren
$text = str_replace ( '&#8221;', '', $text ); // Comillas imprenta cierran
$text = str_replace ( '&#8216;', '\'', $text ); // Comillas imprenta abren
$text = str_replace ( '&#8217;', '\'', $text ); // Comillas imprenta abren
$text = str_replace ( '&#8211;', '-', $text );
$text = str_replace ( '&#225;', 'a' , $text );
$text = str_replace ( '&#233;', 'e' , $text );
$text = str_replace ( '&#237;', 'i' , $text );
$text = str_replace ( '&#241;', 'n' , $text );
$text = str_replace ( '&#243;', 'o' , $text );
$text = str_replace ( '&#250;', 'u' , $text );

$text = preg_replace("(\r\n|\n|\r|\t)", "", $text); 
$text = preg_replace("/&(.)(acute|cedil|circ|grave|ring|tilde|uml);/", "$1", $text); 
$text = inversEntities(trim($text));
$text = strtr($text,$tausch);
$text = unhtmlspecialchars($text);
$text = preg_replace("[^\x01-\x7f]","",$text);
return $text;
}

////////////////////////////////////////////////////////////////////////////////

function cleanHTML($string){
   static $trans;
   static $replace;
	$search = array ("@<(.*?)>@ui","@([\r\n])[\s]+@");
	$replace = array ("","");
	return preg_replace($search, $replace, $string);
	}
	
////////////////////////////////////////////////////////////////////////////////

// From cURL (stevehartken http://www.php.net/manual/en/ref.curl.php#62194)
function curl_get_file_contents($url){ 
    $url=str_replace('&amp;','&',$url); 
    $ch=curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
    $content = curl_exec ($ch); 
    curl_close ($ch); 
    return $content; 
} 
/*
function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
            else return FALSE;
    }
*/    
////////////////////////////////////////////////////////////////////////////////
    
function doURL($string){
   static $trans;

//   $string=urlencode($string);
//   $string = str_replace('+' , '%20' , $string);
   
   return implode("/", array_map("rawurlencode", explode("/", $string)));
   
$trans["%"]="%25";
$trans[" "]="%20";
$trans["	"]="%09";
$trans["!"]="%21";
$trans['"']="%22";
$trans["#"]="%23";
$trans["$"]="%24";
$trans["&"]="%26";
$trans["'"]="%27";
$trans["("]="%28";
$trans[")"]="%29";
$trans["*"]="%2a";
$trans["+"]="%2b";
$trans[","]="%2c";
$trans["-"]="%2d";
$trans["\."]="%2e";
$trans["\/"]="%2f";
$trans[":"]="%3a";
$trans[";"]="%3b";
$trans[">"]="%3e";
//$trans["?"]="%3f";
$trans["@"]="%40";
$trans["\["]="%5b";
$trans["\\"]="%5c";
$trans["\]"]="%5d";
$trans["\^"]="%5e";
$trans["`"]="%60";
$trans["{"]="%7b";
$trans["|"]="%7c";
$trans["}"]="%7d";
$trans["~"]="%7e";
$trans["´"]="%b4";

$trans["%3F"]="?";
$trans["%3D"]="=";

return strtr($string,$trans);
}
?>
	</channel>
</rss>
