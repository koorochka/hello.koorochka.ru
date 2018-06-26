<?php
/**
 * Matrix Framework
 * @package matrix
 * @subpackage main
 * @copyright 2017 Koorochka
 */
use Matrix\Main\Localization\Loc;
require_once(substr(__FILE__, 0, strlen(__FILE__) - strlen("/include.php"))."/matrix_root.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/matrix/modules/main/start.php");
/**
 * TODO
 * check this and optimize
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/matrix/modules/main/classes/general/virtual_io.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/matrix/modules/main/classes/general/virtual_file.php");


$application = \Matrix\Main\Application::getInstance();

$application->initializeExtendedKernel(array(
    "get" => $_GET,
    "post" => $_POST,
    "files" => $_FILES,
    "cookie" => $_COOKIE,
    "server" => $_SERVER,
    "env" => $_ENV
));


/**
 * define global application object
 */
$GLOBALS["APPLICATION"] = new CMain;

if(defined("SITE_ID"))
    define("LANG", SITE_ID);

if(defined("LANG"))
{
    if(defined("ADMIN_SECTION") && ADMIN_SECTION===true)
        $db_lang = CLangAdmin::GetByID(LANG);
    else
        $db_lang = CLang::GetByID(LANG);

    $arLang = $db_lang->Fetch();

    if(!$arLang)
    {
        throw new \Matrix\Main\SystemException("Incorrect site: ".LANG.".");
    }
}
else
{
    $arLang = $GLOBALS["APPLICATION"]->GetLang();
    define("LANG", $arLang["LID"]);
}

$lang = $arLang["LID"];
if (!defined("SITE_ID"))
    define("SITE_ID", $arLang["LID"]);
define("SITE_DIR", $arLang["DIR"]);
define("SITE_SERVER_NAME", $arLang["SERVER_NAME"]);
define("SITE_CHARSET", $arLang["CHARSET"]);
define("FORMAT_DATE", $arLang["FORMAT_DATE"]);
define("FORMAT_DATETIME", $arLang["FORMAT_DATETIME"]);
define("LANG_DIR", $arLang["DIR"]);
define("LANG_CHARSET", $arLang["CHARSET"]);
define("LANG_ADMIN_LID", $arLang["LANGUAGE_ID"]);
define("LANGUAGE_ID", $arLang["LANGUAGE_ID"]);

$context = $application->getContext();
$context->setLanguage(LANGUAGE_ID);
$context->setCulture(new \Matrix\Main\Context\Culture($arLang));

$request = $context->getRequest();
if (!$request->isAdminSection())
{
    $context->setSite(SITE_ID);
}

$application->start();

$GLOBALS["APPLICATION"]->reinitPath();

if (!defined("POST_FORM_ACTION_URI"))
{
    define("POST_FORM_ACTION_URI", htmlspecialcharsbx(GetRequestUri()));
}

$GLOBALS["MESS"] = array();
$GLOBALS["ALL_LANG_FILES"] = array();

Loc::loadLanguageFile($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/general/database.php");
Loc::loadLanguageFile($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/general/main.php");
Loc::loadLanguageFile(__FILE__);

#error_reporting(COption::GetOptionInt("main", "error_reporting", E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR|E_PARSE) & ~E_STRICT & ~E_DEPRECATED);

if(!defined("MX_COMP_MANAGED_CACHE") && COption::GetOptionString("main", "component_managed_cache_on", "Y") <> "N")
{
    define("MX_COMP_MANAGED_CACHE", true);
}
require_once($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/filter_tools.php");
//component 2.0 template engines
$GLOBALS["arCustomTemplateEngines"] = array();

require_once($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/general/urlrewriter.php");



/**
 * Defined in dbconn.php
 * @param string $DBType
 */

\Matrix\Main\Loader::registerAutoLoadClasses(
    "main",
    array(
        "CSiteTemplate" => "classes/general/site_template.php",
        "CMatrixComponent" => "classes/general/component.php",
        "CComponentEngine" => "classes/general/component_engine.php",
        "CMatrixComponentTemplate" => "classes/general/component_template.php",
        "CComponentUtil" => "classes/general/component_util.php",
        "CControllerClient" => "classes/general/controller_member.php",
        "PHPParser" => "classes/general/php_parser.php",
        "CDiskQuota" => "classes/".$DBType."/quota.php",
        //"CEventLog" => "classes/general/event_log.php",
        //"CEventMain" => "classes/general/event_log.php",
        "CAllFile" => "classes/general/file.php",
        "CFile" => "classes/".$DBType."/file.php",
        "CTempFile" => "classes/general/file_temp.php",
        "CUserOptions" => "classes/general/user_options.php",
        "CTextParser" => "classes/general/textparser.php",
        "CPHPCacheFiles" => "classes/general/cache_files.php",
        "CMXShortUri" => "classes/".$DBType."/short_uri.php",
        "CFinder" => "classes/general/finder.php",
        "CAccess" => "classes/general/access.php",
        "CAuthProvider" => "classes/general/authproviders.php",
        "IProviderInterface" => "classes/general/authproviders.php",
        "CGroupAuthProvider" => "classes/general/authproviders.php",
        "CUserAuthProvider" => "classes/general/authproviders.php",
        "CUserCounter" => "classes/".$DBType."/user_counter.php",
        "CSqlUtil" => "classes/general/sql_util.php",
        "CHTMLPagesCache" => "classes/general/cache_html.php"
    )
);

#require_once($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/".$DBType."/agent.php");
require_once($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/".$DBType."/user.php");
require_once($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/".$DBType."/event.php");
require_once($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/general/menu.php");
AddEventHandler("main", "OnAfterEpilog", array("\\Matrix\\Main\\Data\\ManagedCache", "finalize"));
require_once($_SERVER["DOCUMENT_ROOT"].MATRIX_ROOT."/modules/main/classes/".$DBType."/usertype.php");

if(file_exists(($_fname = $_SERVER["DOCUMENT_ROOT"]."/matrix/php_interface/init.php")))
    include_once($_fname);

/**
 * session initialization
 */
ini_set("session.cookie_httponly", "1");

if($domain = $GLOBALS["APPLICATION"]->GetCookieDomain())
    ini_set("session.cookie_domain", $domain);

#if(COption::GetOptionString("security", "session", "N") === "Y"	&& CModule::IncludeModule("security"))
#    CSecuritySession::Init();

session_start();

foreach (GetModuleEvents("main", "OnPageStart", true) as $arEvent)
    ExecuteModuleEventEx($arEvent);

/**
 * define global user object
 */
$GLOBALS["USER"] = new CUser;

/**
 * session control from group policy
 */
$arPolicy = $GLOBALS["USER"]->GetSecurityPolicy();
$currTime = time();
if(
    (
        //IP address changed
        $_SESSION['SESS_IP']
        && strlen($arPolicy["SESSION_IP_MASK"])>0
        && (
            (ip2long($arPolicy["SESSION_IP_MASK"]) & ip2long($_SESSION['SESS_IP']))
            !=
            (ip2long($arPolicy["SESSION_IP_MASK"]) & ip2long($_SERVER['REMOTE_ADDR']))
        )
    )
    ||
    (
        //session timeout
        $arPolicy["SESSION_TIMEOUT"]>0
        && $_SESSION['SESS_TIME']>0
        && $currTime-$arPolicy["SESSION_TIMEOUT"]*60 > $_SESSION['SESS_TIME']
    )
    ||
    (
        //session expander control
        isset($_SESSION["MX_SESSION_TERMINATE_TIME"])
        && $_SESSION["MX_SESSION_TERMINATE_TIME"] > 0
        && $currTime > $_SESSION["MX_SESSION_TERMINATE_TIME"]
    )
    ||
    (
        //signed session
        isset($_SESSION["MX_SESSION_SIGN"])
        && $_SESSION["MX_SESSION_SIGN"] <> matrix_sess_sign()
    )
    ||
    (
        //session manually expired, e.g. in $User->LoginHitByHash
    isSessionExpired()
    )
)
{
    $_SESSION = array();
    @session_destroy();

    //session_destroy cleans user sesssion handles in some PHP versions
    //see http://bugs.php.net/bug.php?id=32330 discussion
    #if(COption::GetOptionString("security", "session", "N") === "Y"	&& CModule::IncludeModule("security"))
    #    CSecuritySession::Init();

    session_id(md5(uniqid(rand(), true)));
    session_start();
    $GLOBALS["USER"] = new CUser;
}
$_SESSION['SESS_IP'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['SESS_TIME'] = time();

if(!isset($_SESSION["MX_SESSION_SIGN"]))
    $_SESSION["MX_SESSION_SIGN"] = matrix_sess_sign();

/**
 * TODO
 * Here pased session control from security module
 */

define("MX_STARTED", true);

if (isset($_SESSION['MX_ADMIN_LOAD_AUTH']))
{
    define('ADMIN_SECTION_LOAD_AUTH', 1);
    unset($_SESSION['MX_ADMIN_LOAD_AUTH']);
}

/** start Authorized */
if(!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS!==true)
{
    $bLogout = isset($_REQUEST["logout"]) && (strtolower($_REQUEST["logout"]) == "yes");

    if($bLogout && $GLOBALS["USER"]->IsAuthorized())
    {
        $GLOBALS["USER"]->Logout();
        LocalRedirect($GLOBALS["APPLICATION"]->GetCurPageParam('', array('logout')));
    }

    // authorize by cookies
    if(!$GLOBALS["USER"]->IsAuthorized())
    {
        $GLOBALS["USER"]->LoginByCookies();
    }

    $arAuthResult = false;

    /**
     * Authorize user from authorization html form
    if(isset($_REQUEST["AUTH_FORM"]) && $_REQUEST["AUTH_FORM"] <> '')
    {
        $bRsaError = false;
        if($bRsaError == false)
        {
            if(!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
                $USER_LID = LANG;
            else
                $USER_LID = false;

            if($_REQUEST["TYPE"] == "AUTH")
            {
                $arAuthResult = $GLOBALS["USER"]->Login($_REQUEST["USER_LOGIN"], $_REQUEST["USER_PASSWORD"], $_REQUEST["USER_REMEMBER"]);
            }

        }
        $GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
    }
    */
}
/** end Authorized */

//application password scope control
if(($applicationID = $GLOBALS["USER"]->GetParam("APPLICATION_ID")) !== null)
{
    $appManager = \Matrix\Main\Authentication\ApplicationManager::getInstance();
    if($appManager->checkScope($applicationID) !== true)
    {
        CHTTP::SetStatus("403 Forbidden");
        die();
    }
}

//define the site template
if(!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
{

    $siteTemplate = "";
    if($siteTemplate == "")
    {
        $siteTemplate = CSite::GetCurTemplate();
    }
    define("SITE_TEMPLATE_ID", $siteTemplate);
    define("SITE_TEMPLATE_PATH", getLocalPath('templates/'.SITE_TEMPLATE_ID, MATRIX_PERSONAL_ROOT));
}


//magic sound
if($GLOBALS["USER"]->IsAuthorized())
{
    $cookie_prefix = COption::GetOptionString('main', 'cookie_name', 'MATRIX_SM');
    if(!isset($_COOKIE[$cookie_prefix.'_SOUND_LOGIN_PLAYED']))
        $GLOBALS["APPLICATION"]->set_cookie('SOUND_LOGIN_PLAYED', 'Y', 0);
}

//magic cache
\Matrix\Main\Page\Frame::shouldBeEnabled();

//magic short URI
if(defined("MX_CHECK_SHORT_URI") && MX_CHECK_SHORT_URI && CMXShortUri::CheckUri())
{
    //local redirect inside
    die();
}

foreach(GetModuleEvents("main", "OnBeforeProlog", true) as $arEvent)
    ExecuteModuleEventEx($arEvent);
