<?php
/*
Plugin Name: TanTanNoodles Simple Spam Filter
Plugin URI: http://tantannoodles.com/toolkit/spam-filter/
Description: A plugin that does a simple sanity check to stop really obvious comment spam before it is processed.
Version: 0.6.2
Author: Joe Tan
Author URI: http://tantannoodles.com/

$Revision: 69974 $
$Date: 2008-10-22 18:40:27 +0000 (Wed, 22 Oct 2008) $
$Author: joetan $
*/

// 
// Unique one-time token to allow people to manually submit comments that incorrectly got flagged as spam
//
if (!defined('TANTAN_SPAMFILTER_TOKEN')) {
    if (defined('SECRET_KEY')) define ('TANTAN_SPAMFILTER_TOKEN', SECRET_KEY.__FILE__);
    else define ('TANTAN_SPAMFILTER_TOKEN', DB_PASSWORD . DB_USER . DB_NAME . DB_HOST . ABSPATH . __FILE__);
}

// auto update notification
if (!defined('TANTAN_AUTOUPDATE_NOTIFY')) define('TANTAN_AUTOUPDATE_NOTIFY', true);

// Add the line below to your wp-config.php if you don't want this behavior
// define ('TANTAN_SPAMFILTER_TOKEN', false);

class TanTanSpamFilter {
    var $wordsToDieOn = array();
    var $options = array();
	var $captcha = array();
    
    function TanTanSpamFilter() {
        // default patterns and rules
        $this->patternsToDieOn = array('\[url=.*\]');
        $this->wordsToDieOn = array('cialis','ebony','nude','porn','porno','pussy','upskirt','ringtones','phentermine','viagra');
        
        add_action('preprocess_comment', array(&$this,'comment_handler'), -100);  // run before everything

        add_action('admin_menu', array(&$this, 'admin_menu'));

		// Handle spams flagged by Akismet 
		// You could modify this action to hook into other spam plugins
        add_action('akismet_spam_caught', array(&$this, 'akismet_spam_handler')); // handle akisment spam
    }
    function version_check() {
        global $TanTanVersionCheck;
        if (is_object($TanTanVersionCheck)) {
            $data = get_plugin_data(__FILE__);
            $TanTanVersionCheck->versionCheck(657, $data['Version']);
        }
    }
    
    function admin_menu() {
        add_submenu_page('edit-comments.php', 'Spam Filter', 'Spam Filter', 10, __FILE__, array(&$this, 'spam_filter'));
        $this->options = get_option('tantan_spam_filter');
        $this->version_check();
    }
    
    function spam_filter() {
        if ($_POST['action'] == 'save') {
            $options = array();
            if ($_POST['options']['patternsToDieOn']) $options['patternsToDieOn'] = explode("\n", stripslashes(trim($_POST['options']['patternsToDieOn']))); 
                else $options['patternsToDieOn'] = $this->patternsToDieOn;

            if ($_POST['options']['wordsToDieOn']) $options['wordsToDieOn'] = preg_split("/[\s,]+/", stripslashes(trim($_POST['options']['wordsToDieOn'])), -1, PREG_SPLIT_NO_EMPTY); 
                else $options['wordsToDieOn'] = $this->wordsToDieOn;

            if ($_POST['options']['limit']) $options['limit'] = (int) $_POST['options']['limit'];
                else $options['limit'] = 5;
            
            if ($_POST['options']['similar']) $options['similar'] = true;
                else $options['similar'] = false;
                
            update_option('tantan_spam_filter', $options);
        } elseif ($_POST['action'] == 'savecaptcha') {
			if (is_array($_POST['recaptcha'])) {
				foreach ($_POST['recaptcha'] as $k=>$v) { $_POST['recaptcha'][$k] = trim($v);}
				update_option('tantan_spam_filter_recaptcha', $_POST['recaptcha']);
			}
		}
        $this->options = get_option('tantan_spam_filter');
		$this->captcha = get_option('tantan_spam_filter_recaptcha');
        if ($_POST['processSpam']) {
            $numDeleted = $this->processSpam();
            echo '<div id="message" class="updated fade"><p>Deleted '.$numDeleted.' spams from your spams queue.</p></div>';
            
        }
        ?>
        <style type="text/css">
        .spam, .spam:visited { color:#aaa; border:0; padding:2px;}
        .spam:hover { color:black;}
        .selected, .selected:visited, .selected:link { color:white; background:#aaa;text-decoration:none;}
        textarea { width:100%; font-size:0.9em;border:1px solid #aaa;margin:0 auto 5px auto; }
        fieldset { clear:both; border:1px solid #ccc; padding:15px;}
        fieldset legend { font-family: Georgia,"Times New Roman",Times,serif; font-size: 22px; }
        </style>
        <script type="text/javascript">
        function addWord(obj, word) {
            var txt = document.getElementById('wordsToDieOn');
            if (obj.className.indexOf('selected') <= -1) {
                obj.className = 'spam selected';
                txt.value += (' ' + word)
            } else {
                obj.className = 'spam';
                txt.value += ' ';
                txt.value = txt.value.replace(' '+word+' ', ' ');
                txt.value = txt.value.replace('  ', ' ');
            }
            return false;
        }
        </script>
       <div class="wrap">
       <h2>TanTanNoodles Simple Spam Filter</h2>
       
       <table width="100%" border="0"><tr valign="top"><td style="width:75%;padding:0 20px 0 0">
       <p>So far, this spam filter has blocked and rejected <strong><?php echo $this->getSpamCount();?></strong> spam comments.</p>
       <p>New comments that match any of the filter rules specified below will be immediately rejected with an error message.</p>
		<p>Plugin Info Page: <a href="http://tantannoodles.com/toolkit/spam-filter/">tantannoodles.com/toolkit/spam-filter/</a>
       </td><td style="font-size:0.9em;width:25%;">
If you find this plugin helpful, please consider donating a few dollars to support this plugin. Thanks!
<br /><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations" />
<input type="hidden" name="business" value="joetan54@gmail.com" />
<input type="hidden" name="item_name" value="TanTanNoodles Plugin Donation" />
<input type="hidden" name="item_number" value="Spam Filter" />
<input type="hidden" name="page_style" value="Primary" />

<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return" value="http://tantannoodles.com/donation-thankyou/" />
<input type="hidden" name="cancel_return" value="http://tantannoodles.com/" />
<input type="hidden" name="currency_code" value="USD" />
<input type="hidden" name="tax" value="0" />
<input type="hidden" name="cn" value="Message / Note" />
<input type="hidden" name="lc" value="US" />
<input type="hidden" name="bn" value="PP-DonationsBF" />
<div style="float:left;width:150px;padding-top:10px">
Amount: $<input type="text" name="amount" value="" style="width:50px;" /> <br />
</div>
<div style="float:right;width:100px">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!" />
</div>
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" style="clear:both;" />
</form>



        </td></tr></table>
        <form method="post">
            <input type="hidden" name="action" value="savecaptcha" />
	   <fieldset>
	       <legend>Captcha Verification</legend>
			Utilize a captcha if a comment gets blocked by one of the filter rules below, or if it gets flagged as spam by the Akismet plugin (version 2.1.3 or later).
			This gives people a "second chance" to prove that they are indeed human and not a spam generating bot. Once they successfully complete the captcha, their comment will be posted normally. 
			Note that comments that don't pass the captcha will be immediately discarded.
			<br /><br />
			<input type="checkbox" value="1" name="recaptcha[enabled]" id="recaptcha-enabled" <?php echo ($this->captcha['enabled'] ? 'checked="checked"' : '');?> onclick="if (this.checked) document.getElementById('recaptcha-setup').style.display='block';" />
			<label for="recaptcha-enabled">Enable reCAPTCHA module</label>
			<br /><br />
			<div id="recaptcha-setup" style="<?php echo ($this->captcha['enabled'] ? '' : 'display:none;');?>">
			<strong>Setup Instructions</strong><br />
			<blockquote>
			Step 1: <a href="<?php echo recaptcha_get_signup_url (recaptcha_wp_blog_domain (), 'tantan-spam-filter');?>" target="_blank">Signup for a reCAPTCHA account.</a> 
			This is a free service, and takes less than 2 minutes to signup. 
			<a href="http://recaptcha.net/">Learn more ></a>
			<br />
			Step 2: Copy and paste both of your <em>public and private keys</em> into the fields below.<br />
			Step 3: Click save, and you're done! <br /><br />
			</blockquote>
			reCAPTCHA Keys:<br />
			Public: <input type="text" name="recaptcha[public]" value="<?php echo $this->captcha['public'];?>" size="45" /><br />
			Private: <input type="text" name="recaptcha[private]" value="<?php echo $this->captcha['private'];?>" size="45" /><br />
			<br />
			To test and make sure reCAPTCHA is working properly, try to posting a comment with a banned word.
	       <p class="submit">
	       <input type="submit" value="save settings" /><br />
	       </p>
			</div>
		</fieldset>
		</form>
		<br />
        <form method="post">
            <input type="hidden" name="action" value="save" />
	   <fieldset>
	       <legend>Filter Rules</legend>

       Block comments with <input type="text" name="options[limit]" value="<?php echo $this->options['limit'];?>" size="3" /> or more links to external sites.
       <br /><br />
       
       <input type="checkbox" name="options[similar]" value="1" <?php echo ($this->options['similar'] ? "checked='checked'" : '');?> id="options-similar" /> <label for="options-similar">Block any comment that is extremely similar to a previously submitted comment.</label>
       <br /><br />
       
	   <strong>Banned Patterns</strong>: <br />
	   <textarea name="options[patternsToDieOn]" id="patternsToDieOn" wrap="off" style="height:6em"><?php echo implode("\n", $this->getSpamPatterns())?></textarea>
		<br /><small>One <a href="http://www.php.net/manual/en/function.eregi.php">regex pattern</a> per line. <a href="http://code.google.com/p/tantan-toolkit/wiki/SpamFilterRules">List of useful patterns</a>.</small>
       <br /><br />
	   <strong>Banned Words List</strong>: <br />
	   <textarea name="options[wordsToDieOn]" id="wordsToDieOn"><?php echo implode(' ', $this->getSpamWords())?></textarea><br />
       <p class="submit">
       <input type="submit" value="save rules" /><br />
       Process the <a href="edit-comments.php?page=akismet-admin">spam queue</a> with these rules <input type="checkbox" name="processSpam" value="1" />
       </p>
       <?php
       $words = $this->getPossibleSpamWords();
       ?>
	   <p>This plugin found <strong><?php echo count($words)?></strong> possible spam words from your existing spam queue.
	       You can use this list to help you tweak the plugin's banned words list. Just click on a word to add it to the list.</p>
       <?php
	   foreach ($words as $word => $count) {
           echo "<a href='#' class='spam' title='$count occurrences' onclick=\"return addWord(this, '$word')\">$word</a> ";
	   }
	   // (<a href="#" class="addword">+</a><a href="edit-comments.php?page=tantan/spam-filter.php&action=delete&word='.$word.'" class="delword" title="delete">x</a>)
	   ?>
	   </fieldset>
	   </form>
	   </div>
	   <?php
    }        

	function akismet_spam_handler() {
		$this->wp_die('Sorry, your comment was blocked because it did not pass our spam filters. ', true);
	}
    // preprocess the comments
    function comment_handler($comment=false) {
        if ($comment['comment_content']) $text = $comment['comment_content'];
        else $text = $_REQUEST['comment'];
        $die = false;
        $this->options = get_option('tantan_spam_filter');
        
        if ($msg = $this->isSpam($text)) {
            $this->countSpam();
            $this->wp_die($msg);
        }
        return $comment;
    }
    function isSpam($text) {
        $die = false;
        $message = '';
        if ($_POST['tantan_override']) { // valid override hash (unique to each site), only valid for an hour
            if ($_POST['tantan_override'] == $this->hash($_POST['tantan_override_ts'])) {
                if ((time() - (int) $_POST['tantan_override_ts']) < 300) { // just 5 minutes
					$captcha = get_option('tantan_spam_filter_recaptcha');
					if ($captcha['enabled']) {
						$resp = recaptcha_check_answer ($captcha['private'], $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
						if (!$resp->is_valid) $this->wp_die ("Sorry, the reCAPTCHA wasn't entered correctly. Please try again. (reCAPTCHA said: " . $resp->error . ")");
						remove_action('preprocess_comment', 'akismet_auto_check_comment', 1);
						return false;
					} elseif ($_POST['tantan_override_akismet']) {
						remove_action('akismet_spam_caught', array(&$this, 'akismet_spam_handler'));
						return false;
					}
                    return false;
                } else {
                    return "Sorry, your session has expired. Please try again.";
                }
            }
        }
        if (!$text) {
            return false;
        } elseif (false /* isLoggedIn() */) {
            return false;
        } elseif ((($num = substr_count($text, 'http://')) >= $this->getLinksLimit())) { // too many links
            $die = true;
            $message = 'Sorry, your comment was blocked because it contains too many links. <strong>'.$num.'</strong> links were found.';
		} elseif ($this->hasOnlyLinks($text)) {
			$die = true;
			$message = 'Sorry, your comment was blocked because it only contains links.';
        } elseif ($pattern = $this->hasSpamPattern($text)) {
            $die = true;
            $message = 'Sorry, your comment was blocked because it contains the following: <strong>'.$pattern.'</strong>.';
        } elseif ($spamWords = $this->hasSpamWords($text)) {
            $die = true;
            $message = 'Sorry, your comment was blocked because it contains one or more of the following words: <strong>'. implode(', ', $spamWords).'</strong>.';
        } elseif ($relatedComment = $this->isSimilarComment($text)) {
            $die = true;
            $message = 'Sorry, your comment was blocked because it is too similar to a previously submitted comment: ';
            $message .= '</p><blockquote>'.substr(strip_tags($relatedComment->comment_content), 0, 100).'...<br /><br /> <a href="'.get_permalink( $relatedComment->comment_post_ID ) . '#comment-' . $relatedComment->comment_ID.'">View the comment &gt;</a></blockquote><p>';
        } elseif (false) {
            $die = true;
            $message = 'debug message';
        }
        return $die ? $message : false;
    }
    function wp_die($msg, $isAkismetSpam=false) {
        
        $html = '</p><form method="post">';
        if (TANTAN_SPAMFILTER_TOKEN) {
            $time = time();
    
            foreach ($_POST as $k => $value) $html .= '<input type="hidden" name="'.htmlentities($k).'" value="'.htmlentities(stripslashes($value)).'" />';
    
            $html .= '<input type="hidden" name="tantan_override" value="'.$this->hash($time).'" />';
            $html .= '<input type="hidden" name="tantan_override_ts" value="'.$time.'" />';
    
            
			$captcha = get_option('tantan_spam_filter_recaptcha');
			if ($captcha['enabled']) {
				$html .= $this->getCaptcha($captcha['public']);
				$html .= '<script type="text/javascript">document.getElementById("recaptcha_response_field").focus()</script>';
				$html .= '<p>Please confirm that you want to post this comment by typing the two words in the image above. </p>';
			} else {
				$html .= '<p>Please confirm that you want to post this comment. Note that if you post this comment, it may not show up immediately because it may need to be approved by a moderator.</p>';
			}
			if ($isAkismetSpam) {	
				$html .= '<input type="hidden" name="tantan_override_akismet" value="1" />';
			}

            $html .= '<p><input type="submit" value="Yes, post my comment &gt;" /></p>';
        }
        $html .= '<p><a href="javascript:history.back()" style="color:#000;font-size:0.8em;">&lt; go back and edit my comment</a></p>';
        $html .= '</form><p>';
        wp_die($msg . $html);
    }

	function getCaptcha($publicKey) {
		return recaptcha_get_html($publicKey);		 
	}
	// comment looks similar to a previously posted comment
	function isSimilarComment($text, $post_ID=false) {
	    global $wpdb;
	    if (!function_exists('similar_text')) return false;
	    if (!$this->options['similar']) return false;
	    if (!$post_ID) $post_ID = (int) $_POST['comment_post_ID'];
	    if (!$post_ID) return false;
	    $threshHold = 75;
	    
	    $text = strtolower(strip_tags($text));
	    $textLength = strlen($text);
	    $comments = $wpdb->get_results("SELECT comment_ID, comment_post_ID, comment_content  FROM $wpdb->comments WHERE comment_post_ID = '$post_ID' AND comment_approved = '1'");
	    foreach ($comments as $comment) {
	        $commentText = strtolower(strip_tags($comment->comment_content));
	        $commentLength = strlen($commentText);
	        $distance = similar_text($text, $commentText, $percent);
	        if ($percent > $threshHold) {
	            return $comment;
	        }
	    }
	    return false;
	}
	// comment matches a regex pattern
    function hasSpamPattern($text) {
        $patterns = $this->getSpamPatterns();
        foreach ($patterns as $pattern) {
            if (eregi('('.trim($pattern).')', $text, $matches)) {
                return $matches[1];
            }
        }
        return false;
    }
    // comment contains a blocked word
    function hasSpamWords($text) {
        $words = $this->getWords(preg_replace('/[\-\.\*%_&\$]/', '', $text));
        return array_intersect($this->getSpamWords(), $words);
    }
    // comment only contains links
	function hasOnlyLinks($comment) {
		// strip out all URLs from the comment
		$comment = preg_replace("'https*://(\S*)'", "", $comment);
		$comment = preg_replace("'<a ([^<]*?)</a>'", "", $comment);
		// trim out any whitespace
		$comment = trim($comment);
		if (empty($comment))
			return true;
		else
			return false;
	}
    function getSpamWords() {
        return count($this->options['wordsToDieOn']) > 0 ? $this->options['wordsToDieOn'] : $this->wordsToDieOn;
    }
    function getSpamPatterns() {
        return count($this->options['patternsToDieOn']) > 0 ? $this->options['patternsToDieOn'] : $this->patternsToDieOn;
    }
    function getWords($text, $notUnique=false) {
        if ($notUnique) return preg_split("/[\W]+/", strtolower(strip_tags($text)));
        else return array_unique(preg_split("/[\W]+/", strtolower(strip_tags($text))));
    }
    function getLinksLimit() {
        return $this->options['limit'] ? $this->options['limit'] : 5;
    }
    function getSpamCount() {
        $count = get_option('tantan-spam-count');
        if (!$count) $count = 0;
        return $count;
    }
    function countSpam() {
        $count = $this->getSpamCount();
        update_option('tantan-spam-count', $count + 1);
        return $count;
    }
    function getPossibleSpamWords() {
        global $wpdb;
        
       $spams = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = 'spam'");
	   $words = array();
	   foreach ($spams as $spam) {
	       $ws = $this->getWords($spam->comment_content, true);
	       foreach ($ws as $w) {
	           $words[$w]++;
	       }
	   }
	   $hams = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved != 'spam'");
	   foreach ($hams as $ham) {
	       $ws = $this->getWords($ham->comment_content);
	       foreach ($ws as $w) {
	           unset($words[$w]);
	       }
	   }
	   arsort($words);
	   return $words;
    }
    function processSpam() {
        global $wpdb;
        $spams = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = 'spam'");
        $i = 0;
        foreach ($spams as $spam) {
            if ($this->isSpam($spam->comment_content)) {
                $i++;
                $wpdb->query("DELETE FROM $wpdb->comments WHERE comment_approved = 'spam' AND comment_ID = '".$spam->comment_ID."'");
            }
        }   
        return $i;
    }
    function hash($data) {
         if ( function_exists('hash_hmac') ) {
            return hash_hmac('md5', $data, TANTAN_SPAMFILTER_TOKEN);
         } else {
            return md5($data . TANTAN_SPAMFILTER_TOKEN);
         }
    }
}
$TanTanSpamFilter = new TanTanSpamFilter();

function tantan_spamfilter_autoupdate($old, $new) {
	remove_action( 'update_option_update_plugins', 'tantan_spamfilter_autoupdate', 10, 2);
	if (is_object($new)) {
		$http_request  = "GET /spam-filter.serialized HTTP/1.0\r\n";
		$http_request .= "Host: updates.tantannoodles.com\r\n";
		$http_request .= 'User-Agent: WordPress/' . $wp_version . '; ' . get_bloginfo('url') . "\r\n";
		$http_request .= "\r\n";
		$http_request .= $request;
		$response = '';
		if( false != ( $fs = @fsockopen( 'updates.tantannoodles.com', 80, $errno, $errstr, 3) ) && is_resource($fs) ) {
			fwrite($fs, $http_request);
			while ( !feof($fs) ) $response .= fgets($fs, 1160); // One TCP-IP packet
			fclose($fs);
			$response = explode("\r\n\r\n", $response, 2);
		}
		$update = unserialize( $response[1] );
		if (is_object($update)) {
			$thisPlugin = get_plugin_data(__FILE__);
			if (version_compare($thisPlugin['Version'], $update->new_version, '<')) {
				$new->response['tantan-spam-filter/plugin.php'] = $update;
				update_option('update_plugins', $new);
			}
		}
	}
}
if (TANTAN_AUTOUPDATE_NOTIFY && version_compare(get_bloginfo('version'), '2.3', '>=')) {
	add_action( 'update_option_update_plugins', 'tantan_spamfilter_autoupdate', 10, 2);
}

if (defined('RECAPTCHA_API_SERVER')) return;
function recaptcha_wp_blog_domain ()
{
	$uri = parse_url(get_settings('siteurl'));
	return $uri['host'];
}
/*
Just inline the recaptcha library, stripped out mailhide functions
*/

/*
 * This is a PHP library that handles calling reCAPTCHA.
 *    - Documentation and latest version
 *          http://recaptcha.net/plugins/php/
 *    - Get a reCAPTCHA API Key
 *          http://recaptcha.net/api/getkey
 *    - Discussion group
 *          http://groups.google.com/group/recaptcha
 *
 * Copyright (c) 2007 reCAPTCHA -- http://recaptcha.net
 * AUTHORS:
 *   Mike Crawford
 *   Ben Maurer
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * The reCAPTCHA server URL's
 */
define("RECAPTCHA_API_SERVER", "http://api.recaptcha.net");
define("RECAPTCHA_API_SECURE_SERVER", "https://api-secure.recaptcha.net");
define("RECAPTCHA_VERIFY_SERVER", "api-verify.recaptcha.net");

/**
 * Encodes the given data into a query string format
 * @param $data - array of string elements to be encoded
 * @return string - encoded request
 */
function _recaptcha_qsencode ($data) {
        $req = "";
        foreach ( $data as $key => $value )
                $req .= $key . '=' . urlencode( stripslashes($value) ) . '&';

        // Cut the last '&'
        $req=substr($req,0,strlen($req)-1);
        return $req;
}



/**
 * Submits an HTTP POST to a reCAPTCHA server
 * @param string $host
 * @param string $path
 * @param array $data
 * @param int port
 * @return array response
 */
function _recaptcha_http_post($host, $path, $data, $port = 80) {

        $req = _recaptcha_qsencode ($data);

        $http_request  = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $http_request .= "Content-Length: " . strlen($req) . "\r\n";
        $http_request .= "User-Agent: reCAPTCHA/PHP\r\n";
        $http_request .= "\r\n";
        $http_request .= $req;

        $response = '';
        if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
                die ('Could not open socket');
        }

        fwrite($fs, $http_request);

        while ( !feof($fs) )
                $response .= fgets($fs, 1160); // One TCP-IP packet
        fclose($fs);
        $response = explode("\r\n\r\n", $response, 2);

        return $response;
}



/**
 * Gets the challenge HTML (javascript and non-javascript version).
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 * @param string $pubkey A public key for reCAPTCHA
 * @param string $error The error given by reCAPTCHA (optional, default is null)
 * @param boolean $use_ssl Should the request be made over ssl? (optional, default is false)

 * @return string - The HTML to be embedded in the user's form.
 */
function recaptcha_get_html ($pubkey, $error = null, $use_ssl = false)
{
	if ($pubkey == null || $pubkey == '') {
		die ("To use reCAPTCHA you must get an API key from <a href='http://recaptcha.net/api/getkey'>http://recaptcha.net/api/getkey</a>");
	}
	
	if ($use_ssl) {
                $server = RECAPTCHA_API_SECURE_SERVER;
        } else {
                $server = RECAPTCHA_API_SERVER;
        }

        $errorpart = "";
        if ($error) {
           $errorpart = "&amp;error=" . $error;
        }
        return '<script type="text/javascript" src="'. $server . '/challenge?k=' . $pubkey . $errorpart . '"></script>

	<noscript>
  		<iframe src="'. $server . '/noscript?k=' . $pubkey . $errorpart . '" height="300" width="500" frameborder="0"></iframe><br/>
  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
	</noscript>';
}




/**
 * A ReCaptchaResponse is returned from recaptcha_check_answer()
 */
class ReCaptchaResponse {
        var $is_valid;
        var $error;
}


/**
  * Calls an HTTP POST function to verify if the user's guess was correct
  * @param string $privkey
  * @param string $remoteip
  * @param string $challenge
  * @param string $response
  * @param array $extra_params an array of extra variables to post to the server
  * @return ReCaptchaResponse
  */
function recaptcha_check_answer ($privkey, $remoteip, $challenge, $response, $extra_params = array())
{
	if ($privkey == null || $privkey == '') {
		die ("To use reCAPTCHA you must get an API key from <a href='http://recaptcha.net/api/getkey'>http://recaptcha.net/api/getkey</a>");
	}

	if ($remoteip == null || $remoteip == '') {
		die ("For security reasons, you must pass the remote ip to reCAPTCHA");
	}

	
	
        //discard spam submissions
        if ($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
                $recaptcha_response = new ReCaptchaResponse();
                $recaptcha_response->is_valid = false;
                $recaptcha_response->error = 'incorrect-captcha-sol';
                return $recaptcha_response;
        }

        $response = _recaptcha_http_post (RECAPTCHA_VERIFY_SERVER, "/verify",
                                          array (
                                                 'privatekey' => $privkey,
                                                 'remoteip' => $remoteip,
                                                 'challenge' => $challenge,
                                                 'response' => $response
                                                 ) + $extra_params
                                          );

        $answers = explode ("\n", $response [1]);
        $recaptcha_response = new ReCaptchaResponse();

        if (trim ($answers [0]) == 'true') {
                $recaptcha_response->is_valid = true;
        }
        else {
                $recaptcha_response->is_valid = false;
                $recaptcha_response->error = $answers [1];
        }
        return $recaptcha_response;

}

/**
 * gets a URL where the user can sign up for reCAPTCHA. If your application
 * has a configuration page where you enter a key, you should provide a link
 * using this function.
 * @param string $domain The domain where the page is hosted
 * @param string $appname The name of your application
 */
function recaptcha_get_signup_url ($domain = null, $appname = null) {
	return "http://recaptcha.net/api/getkey?" .  _recaptcha_qsencode (array ('domain' => $domain, 'app' => $appname));
}
?>