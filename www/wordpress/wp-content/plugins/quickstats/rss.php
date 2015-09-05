<?
	if (!isset($_GET['magic'])) die();
	require_once("../../../wp-config.php");
	require_once("../../../wp-includes/cache.php");
	wp_cache_init();
	require_once("../../../wp-includes/wp-db.php");
	require_once("../../../wp-includes/functions.php");
	if (get_settings('jqst_feed_enabled')!='yes') die();
	if ($_GET['magic'] != get_settings('jqst_magic_number')) die();
	$r = mysql_query("SELECT * FROM `wp_jqstats` ORDER BY id DESC LIMIT 0,10");
	header('Content-type: text/xml');
	echo('<?xml version="1.0" encoding="ISO-8859-1" ?'.">\n"); 
?>
<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
>
<channel>
	<title><?php bloginfo('name'); ?> Quick Stats Feed</title>
	<description>Hmm...</description>
	<link><?php bloginfo('wpurl'); ?></link>
	<lastBuildDate></lastBuildDate>
<?
	while ($c = mysql_fetch_assoc($r)) { 
		if ($c['date'] == $lastdate) {
			$suffix = ":".++$suff;
		} else {
			$suff = 0;
			$suffix = '';
		}
		ob_start();
?>
<b>URL: </b><?=$c['url']?><br />
<b>Date: </b><?=date("Y-M-d H:i:s",$c['date']);?><br />
<b>Referer: </b><?=$c['referer']?><br />
<b>IP: </b><?=$c['ip']?><br />
<b>Host: </b><?=$c['host']?><br />
<b>Browser: </b><?=$c['browser']?>
<?
		$desc = ob_get_clean();
?>
		<item>
			<title><?=$c['url']?> <?=date("d-m-y H:i:s",$c['date']).$suffix?></title>
			<description><?=htmlspecialchars($desc)?></description>
			<pubDate><?=date("D, d M Y H:i:s O",$c['date'])?></pubDate>
			<link>http://<?=$c['host']?>/</link>
			<dc:creator><?=$c['host']?></dc:creator>
		</item>
<?
		$lastdate = $c['date'];
	}
?>
	</channel>
</rss>
