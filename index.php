<?php 
	/* 
	$headers = array(
	  'Accept: application/json',
	  'Content-Type: application/json'
	);
	
    $news = array();
	if(!empty($_POST['news-source'])){		
		$url = "https://newsapi.org/v1/articles?source=".trim($_POST['news-source'])."&sortBy=top&apiKey=a12f512fb0c24ce39901e2bc7e8434eb"; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$news_headings = curl_exec($ch);
		$news_headings = json_decode($news_headings);
		
		
	}
	*/
	
	
	
	
	
	/* 
	$fields = array(
	  #'category' => 'business',
	  'language' => 'en',
	  #'country' => '',
	);
	
	$url = "https://newsapi.org/v1/sources"; 
	$url .= '?'.http_build_query($fields);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$results = curl_exec($ch);
	curl_close($ch);
	if(!empty($results)){
		$file = "./dbase/sources.nws"; 
		file_put_contents($file,$results); 
	}
	
	if(!empty($sources->sources) && is_array($sources->sources)){
		$headers = array(
		  'Accept: application/json',
		  'Content-Type: application/json'
		);
		
		$c = 0;
		foreach($sources->sources AS $ns){
			$file_name = "NS".$ns->id.".nws";
			$handle = fopen("./dbase/".$file_name, "W");
			$url = "https://newsapi.org/v1/articles?source=".$ns->id."&sortBy=top&apiKey=a12f512fb0c24ce39901e2bc7e8434eb"; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$news_headings = curl_exec($ch);
			file_put_contents("./dbase/".$file_name,$news_headings); 
			sleep(3);
		}
	}
	
	*/
	
	$file = "./dbase/sources.nws"; 
	$raw = file_get_contents($file);
	$sources = json_decode($raw);
        
	if(!empty($_POST['demo-category'])){
            $content_file = "./dbase/NS".$_POST['demo-category'].".nws";
            $temp = file_get_contents($content_file);
            $news_headings = json_decode($temp);		
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>News Dibba</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">
                            <!-- Header -->
                            <header id="header">
                                <div class="logo">
                                    <span class="icon fa fa-newspaper-o"></span>
                                </div>
                                <div class="content">
                                        <div class="inner">
                                                <h1>News Dibba</h1>
                                                <p>A real time news update app.</p><br />
                                        </div>
                                </div>
                                <nav>
                                    <ul>
                                        <li><a href="#source-list">News Room</a></li>
                                        <li><a href="#intro">Intro</a></li>
                                        <li><a href="#work">Work</a></li>
                                        <li><a href="#about">About</a></li>
                                        <li><a href="#contact">Contact</a></li>
                                        <!--<li><a href="#elements">Elements</a></li>-->
                                    </ul>
                                </nav>
                            </header>

				<!-- Main -->
					<div id="main">
                                            <!-- Intro -->
                                            <article id="source-list">
                                                <h2 class="major">News From</h2>								
                                                <form method="post" action="">
                                                    <div class="field">
                                                        <label for="demo-category">News Source</label>
                                                        <div class="select-wrapper">
                                                            <select name="demo-category" id="demo-category">
                                                                <?php 
                                                                if(!empty($sources) && is_array($sources)){
                                                                    foreach($sources AS $source){
                                                                        ?><option value="<?php echo $source->id; ?>"><?php echo $source->name; ?></option><?php 
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="submit" value="Go" name="get_news" class="special" /> 
                                                </form>

                                                <h3 class="major">Top News</h>
                                                <?php 
                                                if(!empty($news_headings)){
                                                    if(!empty($news_headings->articles) && is_array($news_headings->articles)){
                                                        foreach($news_headings->articles AS $article){ 											
                                                            ?>
                                                            <h3><?php echo $article->title; ?></h3>
                                                            <img style="width:100%; height:auto;" src="<?php echo $article->urlToImage; ?>" alt="" />
                                                            <em>
                                                            Posted at <strong><?php echo date("d-m-Y h:i:s",strtotime($article->publishedAt)).'</strong> by '.$article->author; ?>
                                                            </em>
                                                            <p><?php echo $article->description; ?></p>

                                                            <div class="heading-cont">    
                                                                <div class="news-details hidden"> 
                                                                    <iframe src="" width="100%" height="800px;"></iframe>
                                                                </div><br/>
                                                                <span class="see-more button" data-url="<?php echo $article->url; ?>">See More...</span>
                                                                
                                                            </div>
                                                            <hr/>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </article>

						
						<!-- Intro -->
							<article id="intro">
								<h2 class="major">Intro</h2>
								<span class="image main"><img src="images/pic01.jpg" alt="" /></span>
								<p>The app is very simple to use. The motivation behind the app was simple. To read news!</p>
							</article>

						<!-- Work -->
							<article id="work">
								<h2 class="major">Work</h2>
								<span class="image main"><img src="images/pic02.jpg" alt="" /></span>
								<p>Check out the News Room section so that you can explore the world. It has the best repository of news sources like BBC, CNN, Al Jazeera, ESPN and so on. The news is updated every 6 hour. This is not the end. We will be implementing more features in near future. We are interested to include a community of journalists and knowledge seekers who can also help in updating the news with us!</p>
							</article>

						<!-- About -->
							<article id="about">
								<h2 class="major">About</h2>
								<span class="image main"><img src="images/pic03.jpg" alt="" /></span>
								<p>This is a product of CheesecakeTech, a tech startup located in Bangladesh. CheesecakeTech develops dynamic websites, mobile applications, software and games. We also provide exclusive digital marketing services.</p>
							</article>

						<!-- Contact -->
							<article id="contact">
								<h2 class="major">Contact</h2>
								<form method="post" action="#">
									<div class="field half first">
										<label for="name">Name</label>
										<input type="text" name="name" id="name" />
									</div>
									<div class="field half">
										<label for="email">Email</label>
										<input type="text" name="email" id="email" />
									</div>
									<div class="field">
										<label for="message">Message</label>
										<textarea name="message" id="message" rows="4"></textarea>
									</div>
									<ul class="actions">
										<li><input type="submit" value="Send Message" class="special" /></li>
										<li><input type="reset" value="Reset" /></li>
									</ul>
								</form>
								 
							</article>

						<!-- Elements -->
							<article id="elements">
								

							</article>

					</div>

                                        <!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; CheesecakeTech <?php echo date("Y"); ?></p>
					</footer>

			</div>

		<!-- BG -->
                <div id="bg"></div>

		<!-- Scripts -->
                <script src="assets/js/jquery.min.js"></script>
                <script src="assets/js/skel.min.js"></script>
                <script src="assets/js/util.js"></script>
                <script src="assets/js/main.js"></script>

	</body>
</html>