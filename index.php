<?php

require_once "./markdown.php";

if (isset($_GET['n'])){
	$title = $_GET['n'];
	$file = './src/'.$title.'.mkd';
	$fh = fopen($file, 'r');
	$title = preg_replace('#_#', ' ', $title);
	$title = preg_replace('/^.*\/(.*)/', "$1", $title);
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
        <div  id="menu">
            <ul>
	    <li><a href="/">Retour Accueil</a></li>
            </ul>
        </div>
	<div id="main_content">
	    <article>
END;
	echo Markdown(fread($fh, filesize($file)));
	fclose($fh);

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
} elseif (isset($_GET['rss'])){
	$dir = './src/*';
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo '<rss version="2.0">';
	echo '<channel>';
	echo '<title>Exos SPI</title>';
	echo '<description>Flux RSS du site d\'exos étudiant de la SPI</description>';
	echo "<lastBuildDate>".date('l jS F Y h:i:s A')."</lastBuildDate>";
	echo "<link>http://exos.matael.org</link>";

	foreach (glob($dir) as $file) {
		$filename = preg_replace('/\.mkd$/', '', $file);
		$filename = preg_replace('/^\.\/src\//', '', $filename);
		echo "<item>";
		echo "<title>".preg_replace('#_#', ' ',$filename)."</title>";
		echo "<link>http://exos.matael.org/?n=".$filename."</link>";
		echo "</item>";
	}
	echo "</channel>";
	echo "</rss>";

} else {
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
	foreach (glob($dir) as $folder) {
		$folder_name = preg_replace('/^\.\/src\//', '', $folder);

		echo "<h3>".preg_replace('/^\.\/src\//', '', $folder_name)."</h3>";

		$fh = fopen($folder."/index.mkd", "r");
		echo Markdown(fread($fh, filesize($folder."/index.mkd")));
		fclose($fh);

		echo "<ul>";

		foreach (glob($folder.'/*') as $file) {
			if ($file == $folder.'/index.mkd') {
				continue;
			}
			$filename = preg_replace('/\.mkd$/', '', $file);
			$filename = preg_replace('/^\.\/src\/'.$folder_name.'\//', '', $filename);
			echo '<li><a href="/?n='.$folder_name.'/'.$filename.'">'.preg_replace('#_#', ' ',$filename).'</a></li>';
		}
		echo "</ul>";
	}

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
}
?>
