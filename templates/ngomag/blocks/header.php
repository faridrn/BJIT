<?php
if (!class_exists('templateHelper'))
	require_once (dirname(dirname(__FILE__)) . '/helper.php');
$helper = new TemplateHelper($this); // Creatig an instance of helper class
$device = $helper->device_array; // Get User Device platform and settings
echo $helper->doctype . "\n"; // Doctype based on users platform (only differs in mobile devices)

$app = JFactory::getApplication();
$url = JURI::base(); // Root URL
$turl = rtrim($url, "/"); // Root URL without tailing slash

$isFrontpage = $helper->isFrontpage($app->getMenu());
$this->setGenerator(''); // Remove Joomla generator tag
$sitename = $app->getCfg('sitename');
$lang = JLanguageHelper::getLanguages('lang_code')[JFactory::getLanguage()->getTag()]->sef;
@$pageSuffix = JFactory::getApplication()->getMenu()->getActive()->params["pageclass_sfx"];

JResponse::clearHeaders();
?><html class="no-js<?php echo $helper->getBaseClasses($app->getMenu()); ?>" lang="<?php echo $lang; ?>"  dir="<?php echo $this->direction; ?>">
	<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
	<meta property="og:site_name" content="<?php echo $sitename; ?>" />
	<meta property="og:locale" content="<?php echo $lang; ?>" />
	<meta name="google-site-verification" content="RuhLN7r7CmLWXg0zwSSAqLrHsQN0WnPOpvUTKgi8IJ0" />
	<meta name="samandehi" content="996884440"/>
	<?php if ($isFrontpage) { ?><meta name="image" content="<?php echo JURI::base() . 'assets/data/placeholder_ngomag.jpg'; ?>">
	<meta property="og:image" content="<?php echo JURI::base() . 'assets/data/placeholder_ngomag.jpg'; ?>">
	<meta property="og:image:width" content="1920">
	<meta property="og:image:height" content="1080">
<?php } ?>
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/assets/img/ngomag/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/img/ngomag/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/img/ngomag/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/img/ngomag/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/assets/img/ngomag/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/assets/img/ngomag/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/assets/img/ngomag/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/assets/img/ngomag/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="/assets/img/ngomag/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="/assets/img/ngomag/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="/assets/img/ngomag/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="/assets/img/ngomag/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="/assets/img/ngomag/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="نشریه نهاد مردمی"/>
	<meta name="msapplication-TileColor" content="#0ebee3" />
	<meta name="msapplication-TileImage" content="/assets/img/ngomag/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="/assets/img/ngomag/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="/assets/img/ngomag/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="/assets/img/ngomag/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="/assets/img/ngomag/mstile-310x310.png" />
		<?php
		$JHeader = $this->getHeadData(); // Get Joomla Native Head tags
		$this->setHeadData($helper->cleanHead($JHeader)); // Removing unwanted tags from Joomla native head
		unset($this->_styleSheets);
		unset($this->_scripts); //unset($this->_style); // Unsetting default stylesheets and script even after helpers try and adding my own files
		foreach ($this->_style as $style)
			unset($style);
		// Adding stylesheets and scripts to joomla head to prevent core to face an empty array
		$this->_styleSheets[JURI::base() . 'assets/css/ngomag.css?_=20180805'] = array('mime' => "text/css");
//		$this->_scripts[JURI::base() . 'assets/js/modernizr-2.6.2.min.js'] = array('mime' => "text/javascript");
		$this->_scripts[JURI::base() . 'assets/js/jquery-3.3.1.min.js'] = array('mime' => "text/javascript");
//		$this->_scripts[JURI::base() . 'media/j2store/js/j2store.js'] = array('mime' => "text/javascript");
		if (!$isFrontpage) {
			$this->_scripts[JURI::base() . 'assets/js/jwplayer-8.6.3/jwplayer.js'] = array('mime' => "text/javascript");
			$this->_scripts['https://www.google.com/recaptcha/api.js?hl=fa'] = array('mime' => "text/javascript");
		}
		JFactory::getDocument()->addScriptDeclaration(';var Config = { base: "' . JURI::base() . '" }');
		?><jdoc:include type="head" />
</head>