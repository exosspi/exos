<?php
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
?>
