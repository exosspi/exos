<?php
	$title = 'Index';
	$dir = './src/*';
	echo<<<END
<!doctype html>
<html lang="fr">
    <head>
	<title>$title</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="main.css" media="screen"/>
    </head>
    <body>
	<header>
		<p><a href="/">$title</a></p>
	</header>
	<div id="main_content">
	    <article>
		
END;
	$fh = fopen("index.mkd", 'r');
	echo Markdown(fread($fh, filesize("index.mkd")));
	fclose($fh);
	$redis = new Redis();
	$redis->connect('127.0.0.1');
	foreach (glob($dir) as $folder) {
		$folder_name = preg_replace('/^\.\/src\//', '', $folder);

		echo "<h3 class='index_title'>".preg_replace('/^\.\/src\//', '', $folder_name)."</h3>";

		$fh = fopen($folder."/index.mkd", "r");
		if ($fh) {
			echo '<div class="archive_separator">&nbsp;</div>';
			echo '<div class="intro_category">'.Markdown(fread($fh, filesize($folder."/index.mkd"))).'</div>';
		}
		fclose($fh);
		echo '<div class="archive_separator">&nbsp;</div>';

		foreach (glob($folder.'/*') as $file) {
			if ($file == $folder.'/index.mkd') {
				continue;
			}
			$filename = preg_replace('/\.mkd$/', '', $file);
			$filename = preg_replace('/^\.\/src\/'.$folder_name.'\//', '', $filename);
			$first_line = $redis->get("exosfac:".$folder_name."/".$filename.".mkd");
			echo '<div><div class="archive_link"><a href="/?n='.$folder_name.'/'.$filename.'">'.preg_replace('#_#', ' ',$filename).'</a></div>';
			echo '<div class="archive_summary">'.$first_line.'</div>';
			echo '<div class="archive_separator">&nbsp;</div></div>';
		}
	}
	$redis->close();

echo<<<END
</article>
<hr/>
<article class="disqus">
	<div id="disqus_thread"></div>
	<script type="text/javascript">
/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
var disqus_shortname = 'exosspi'; // required: replace example with your forum shortname

/* * * DON'T EDIT BELOW THIS LINE * * */
(function() {
	    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		    dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
		    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
</script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
</article>
</div>
<div style="clear:both;">&nbsp;</div>
<footer><p>Powered by mkdizer <!--| <a href="/?rss">RSS Feed</a>--></p></footer>
</body>
</html>
END;
?>
