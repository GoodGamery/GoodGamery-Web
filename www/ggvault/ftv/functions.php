<?php
$IMG_URL_TEMPLATE = "http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid=%CARD_ID%&type=card";
$GATHERER_URL_TEMPLATE = "http://gatherer.wizards.com/Pages/Card/Details.aspx?multiverseid=%CARD_ID%";
$FTV_LINK_TEMPLATE = "./?id=%HASH%";

$CARD_WIDTH = 223;
$CARD_HEIGHT = 310;

$CARD_ID_FILE = "./resources/card_ids";
$IMG_TAG_TEMPLATE = "<img src=\"%CARD_URL%\" width=\"$CARD_WIDTH\" height=\"$CARD_HEIGHT\">";
$LINK_TAG_TEMPLATE = "<a href=\"%LINK%\" target=\"_new\">%CONTENT%</a>";

$WORDS_PATH = "./resources/words/";
$WORDS_FILE_PREFIX = "words_";

$ENCRYPTION_KEY = "pqOM0t7RuFsuZsf5CPeJUk33";
$debug = FALSE;
$debug_log = "";
$invalidHashTitle = "From the Server: Not Found";
$invalidHashCards = array(88817, 4437, 74256, 19616, 107259, 12403, 12376, 20178, 247547, 15151, 74231, 31741, 126419, 121187, 129022);

function getRandomElement($array) {
   return mt_rand(0, count($array) - 1);
}

function getWordFileList() {
   global $WORDS_PATH, $WORDS_FILE_PREFIX;

   $files = array();
   if ($handle = opendir($WORDS_PATH)) {
      while (false !== ($file = readdir($handle))) {
         $index = strpos($file,$WORDS_FILE_PREFIX);
         if ($index === 0) {
            $files[] = $WORDS_PATH . $file;
         }
      }
   }
   closedir($handle);
   return $files;
}

function getRandomWord() { 
   $wordFiles = getWordFileList();

   //get a random file from the file list
   $fileIndex = getRandomElement($wordFiles);
   $file = $wordFiles[$fileIndex];

   //get all the words from that list
   $words = file($file);

   //get a random word from that file
   $wordIndex = getRandomElement($words);
   return trim($words[$wordIndex]);
}

function getCardTag($id) {
   global $IMG_URL_TEMPLATE, $IMG_TAG_TEMPLATE;
   $cardUrl = str_replace("%CARD_ID%", $id, $IMG_URL_TEMPLATE);
   $cardImg = str_replace("%CARD_URL%", $cardUrl, $IMG_TAG_TEMPLATE);
   return $cardImg;
}

function getCardLink($id, $content) {
   global $GATHERER_URL_TEMPLATE, $LINK_TAG_TEMPLATE;
   $linkUrl = str_replace("%CARD_ID%", $id, $GATHERER_URL_TEMPLATE);
   return getLink($linkUrl, $content);
}

function getLink($linkUrl, $content) {
   global $LINK_TAG_TEMPLATE;
   $anchorTag = str_replace("%LINK%", $linkUrl, $LINK_TAG_TEMPLATE);
   $anchorTag = str_replace("%CONTENT%", $content, $anchorTag);
   return $anchorTag;
}

//generate a unique numeric hash from the given string
function hashWord($word) {
   $PRIMES = array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89);

   //only use the first N characters, where N is the # of primes
   $numFactors = min(mb_strlen($word), count($PRIMES)); 
   $hashNum = 0;
   
   for ($i = 0; $i < $numFactors; $i++) {
      $hashNum = $hashNum + ord(substr($word, $i, 1)) * $PRIMES[$i];
   }

   return $hashNum;
}

function echo_debug($string) {
   global $debug;
   if ($debug) {
      echo($string . "<br/>");
   }
}

function echo_debug_nobreak($string) {
   global $debug;
   if ($debug) {
      echo($string);
   }
}

$debugParam = isset($_GET['debug']);
if ($debugParam == '1' || $debugParam == 'TRUE') {
   $debug = TRUE;
}

function generateHash($word) {
   global $ENCRYPTION_KEY;
   $encrypted = encryptWord($word);
   $hexed = bin2hex($encrypted);

   echo_debug("Word: $word");
   echo_debug("Encrypting: $encrypted");
   echo_debug("Converting to hex: $hexed");
   return $hexed;
}

function encryptWord($word) {
  global $ENCRYPTION_KEY;
  return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $ENCRYPTION_KEY, $word, MCRYPT_MODE_ECB);
}

function decryptHash($hash) {
  global $ENCRYPTION_KEY;
  return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $ENCRYPTION_KEY, $hash, MCRYPT_MODE_ECB);
}

function getFullTitle($word) {
  return "From the Vault: " . mb_convert_case(trim($word), MB_CASE_TITLE, "UTF-8");
}

function searchFileForString($file, $string) { 
   // open file to an array 
   $fileLines = file($file); 

   // loop through lines and look for search term 
   foreach($fileLines as $line) { 
      $searchCount = substr_count(trim($line), trim($string)); 
      if($searchCount > 0) { 
          return TRUE;
      } 
   } 
 }   
  
function scanDirectoryForString($dir, $string) { 
   $subDirs = array(); 
   $dirFiles = array(); 

   $dh = opendir($dir); 
   while(($node = readdir($dh)) !== false) { 
      // ignore . and .. nodes 
      if(!($node=='.' || $node=='..')) { 
          if(is_dir($dir.$node)) { 
              $subDirs[] = $dir.$node.'/'; 
          } else { 
              $dirFiles[] = $dir.$node; 
          } 
      } 
   } 
          
   // loop through files and search for string 
   foreach($dirFiles as $file) {  
      //echo("Searching $file for '$string'...<br/>");        
      if (searchFileForString($file, $string)) {
         return TRUE;
      }
   }
   return FALSE;
}
?>
