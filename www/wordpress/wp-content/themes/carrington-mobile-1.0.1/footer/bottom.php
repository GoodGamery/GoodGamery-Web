<?php

// This file is part of the Carrington Mobile Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2009 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

$about_text = cfct_about_text();
if (!empty($about_text)) {
?>
<div id="about" class="group">
	<h3><?php printf(__('About %s', 'carrington-mobile'), get_bloginfo('name')); ?></h3>
<?php
	echo $about_text;
?>
</div>
<?php
}
?>
<div id="footer">
	<hr />
	<p class="small">
		<?php wp_loginout(); wp_register(' | ', ''); ?>
        <?php
        if (function_exists('cfmobi_mobile_exit')) {
            cfmobi_mobile_exit();
        }
        ?>
	</p>
	<div class="clear"></div>
</div>
<?php

wp_footer();

?>
</body>
</html>