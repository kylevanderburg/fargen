<?php
/*
NoteForge Hammer
	by Kyle Vanderburg, in Poplar Bluff & Springfield, Missouri, and Norman, OK.
	Hammer Backend Index Page
	Debuted on November 30, 2007, at www.kyledavey.com/blink.  Went live December 2, 2007.
	All code copyright Kyle Vanderburg
*/
$options = [
	'vanguard'=>TRUE,
	"seths"=>1,
	"vanguardAccess"=>"A",
	"vanguardLogin"=>"",
	"vanguardMessage"=>"kdv",
	"vanguardLoginURL"=>"https://vanguard.kylevanderburg.net/"
	];

require "/var/www/api.ntfg.net/htdocs/hammer/vanilla.php";
$hammer->setHS(1);
$hammer->setHD("/far.research.kylevanderburg.net");
$hammer->clientUrlParse();

if($hammer->user['id']!=1){$hammer->prohibited('KV');die();}

if(!empty($hammer->location[0])){$hammer->location['page']=$hammer->location[0];}
if(!empty($hammer->location[1])){$hammer->location['action']=$hammer->location[1];}
if(!empty($hammer->location[2])){$hammer->location['item']=$hammer->location[2];}

if(isset($hammer->location[0])){$page=$hammer->location[0];}else{$page="far-dashboard";}
if(isset($hammer->location[1])){$action=$hammer->location[1];}else{$action="";}

if(isset($_GET['e'])){ini_set('display_errors',1); error_reporting(E_ALL);$hammer->debug();}
$hammer->head("FARGEN","<link rel=\"stylesheet\" href=\"//liszt.dev/assets/lz-master3.css\" type=\"text/css\" /><link rel=\"shortcut icon\" href=\"//liszt.me/assets/lisztfav.png\"/><script src=\"//liszt.dev/assets/lz-master3.js\"></script>");

// var_dump($hammer);
// if(!isset($hammer->permissions['noteforge/hammer'])){$hammer->permissions['noteforge/hammer']=0;}
if(($hammer->getHS()=="1") && ($hammer->getUserRole()<7)){echo "<div class=\"text-center\"><img src=\"//cdn.ntfg.net/images/hammer/delete.png\" /></div><h1 class=\"text-center\">You are not authorized to view this page.</h1>";die();}else{}

// $hammer->debug(); ?>

<body class="d-flex flex-column h-100">

<nav class="navbar navbar-expand-lg navbar-dark d-print-none" id="ntfgnav" role="navigation" style="background-color:#000;">
	<div class="container">
		<a class="navbar-brand" href="/"><img src="/kvfar.png" class="" alt="FARGEN" border="0" style="" /></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbar-content">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
			<li class="nav-item"><a class="nav-link<?php if(!empty($hammer->location[0])){if($hammer->location[0]=="activities"){echo " active";}}?>" aria-current="page" href="/activities/">Activities</a></li>
			</ul>
		</div><!-- nav-collapse -->
	</div><!-- contianer --> 
</nav><!--navbar-->

<div class="container">
<br />
	<?php if(isset($hammer->user)){include($page.".php");} ?>
<?php require_once "/var/www/cdn.ntfg.net/htdocs/footer-scripts.php"; ?>

</body>  
</html>  
