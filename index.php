<?php

	/*
		1er visite
		Il doit voir un bouton se connecter
		Lorsqu'il clique sur le bouton il va sur facebook et je lui demande les permissions
		- Il accepte
			-> je le redirige sur mon application
			-> $session = getSessionFromRedirect();
			-> $token = (string) $session->getAccessToken();

		- Non merce
			-> je le redirige sur mon application
			-> j'affiche encore le bouton
	*/

	session_start();
	require "facebook-php-sdk-v4-4.0-dev/autoload.php";
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookRequest;
	
	const APPID = "502175273270576";
	const APPSECRET = "e14293037246a898dc6b2d40b6a3c089";

	FacebookSession::setDefaultApplication(APPID, APPSECRET);
	$helper = new FacebookRedirectLoginHelper('http://localhost');

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Titre de ma page</title>
		<meta name="description" content="description de ma page">
	</head>
		<body>
			<script>
				window.fbAsyncInit = function() {
					FB.init({
					  appId      : '<?php echo APPID;?>',
					  xfbml      : true,
					  version    : 'v2.3'
					});
				  };

				  (function(d, s, id){
					 var js, fjs = d.getElementsByTagName(s)[0];
					 if (d.getElementById(id)) {return;}
					 js = d.createElement(s); js.id = id;
					 js.src = "//connect.facebook.net/fr_FR/sdk.js";
					 fjs.parentNode.insertBefore(js, fjs);
				   }(document, 'script', 'facebook-jssdk'));
			</script>
			<div
				  class="fb-like"
				  data-share="true"
				  data-width="450"
				  data-show-faces="true">
			</div>
			<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&appId=502175273270576&version=v2.3";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				</script>

				<div class="fb-comments" data-href="http://developers.facebook.com/docs/plugins/comments/" data-numposts="5" data-colorscheme="light"></div>
				<br>

				<?php


					if(isset($_SESSION) && isset($_SESSION['fb_token'])){
						$session = new FacebookSession($_SESSION['fb_token']);
					}else {
						$session = $helper->getSessionFromRedirect();
						$token = (string) $session->getAccessToken();
						$_SESSION['fb_token'] = $token;
					}

		
					if($session){
						try{
							//Prepare
							$request = new FacebookRequest($session, 'GET', '/me');

							//Execute
							$response = $request->execute();

							//Transforme la data graphObject
							$user = $response->getGraphObject("Facebook\GraphUser");



						}catch (Exception $e){

						}
					}else{
						$loginUrl = $helper->getLoginUrl();
					echo "<a href='".$loginUrl."'>Se connecter</a>";
					}
					

					


				?>
		</body>
</html>
			
		