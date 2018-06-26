<?
/**
 * @param $array
 * @return string
 */
if(!function_exists("arrayToString")) {
    function arrayToString($array)
    {
        $separator = "\r\n";
        $result = $separator;
        foreach ($array as $k => $val) {
            if (is_array($val)) {
                $result .= "----------------------------";
                $result .= arrayToString($val);
                $result .= "----------------------------";
            } else {
                $result .= $k . ": " . $val;
            }
            $result .= $separator;
        }
        return $result;
    }
}

/**
 * @param $str
 */
if(!function_exists("l"))
{
    function l($str)
    {
        $file = $_SERVER["DOCUMENT_ROOT"]."/koorochka/log.txt";

        /**
         * get log string? where append neo string
         */
        $current = file_get_contents($file);

        /**
         * formating prolog
         */
        $separator = "\r\n";
        $prolog = $separator ."############# D-function: #################";
        $prolog .= $separator . "This function save string data in log like a string";
        $prolog .= $separator . "cat koorochka/log.txt or cat log.txt";
        $prolog .= $separator . "The result is:";
        $prolog .= $separator . "##########################################";
        $prolog .= $separator;

        /**
         * formating epilog
         */
        $epilog = $separator . "############" . date("d.m.Y H:i:s") . "#############";
        $epilog .= $separator;


        $current .=  $prolog . $str . $epilog;

        file_put_contents($file, $current);
    }
}

/**
 * @param $str
 */
if(!function_exists("s"))
{
    function s($str)
    {
        /**
         * formating prolog
         */
        $separator = "\r\n";
        $prolog = $separator ."############# S-function: #################";
        $prolog .= $separator . "This function save string data in socket like a string";
        $prolog .= $separator . "cat koorochka/socet.txt or cat socet.txt";
        $prolog .= $separator . "The result is:";
        $prolog .= $separator . "################" . date("d.m.Y H:i:s") . "#################";
        $prolog .= $separator;
        /**
         * formating epilog
         */
        $epilog = $separator . "###########################";
        $epilog .= $separator;


        $str =  $prolog . $str . $epilog;
        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/koorochka/socet.txt", $str);
    }
}

/**
 * @param $value
 * @param string $type
 */
if (!function_exists("d") )
{
    function d($value, $type="pre")
    {
        if ( is_array( $value ) || is_object( $value ) )
        {
            echo "<" . $type . " class=\"prettyprint\">".htmlspecialcharsbx( print_r($value, true) )."</" . $type . ">";
        }
        else
        {
            echo "<" . $type . " class=\"prettyprint\">".htmlspecialcharsbx($value)."</" . $type . ">";
        }
    }
}

/**
 * @param $value
 * @param string $type
 */
if (!function_exists("fd") )
{
    function fd($value, $type="pre")
    {
        $value = file_get_contents($value);
        echo "<" . $type . " class=\"prettyprint\">".htmlspecialcharsbx($value)."</" . $type . ">";
    }
}

/**
 * var_dump Вывод отладочной информации
 * @param $value
 */
if (!function_exists("vd") )
{
    function vd($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }
}

/**
 * var_dump Вывод отладочной информации
 * print_r Вывод отладочной информации
 * @param $value
 */
if (!function_exists("lo") )
{
    function lo($value)
    {
        if ( is_array( $value ) || is_object( $value ) )
        {
            $text = print_r($value, true);
        }
        else
        {
            $text = $value;
        }

        AddMessage2Log( $text );
        //AddMessage2Log( $text, "", 0, false );
    }
}

/**
 * IsAdmin
 * @return bool|null
 */
if (!function_exists("ia") )
{
    function ia()
    {
        global $USER;
        return $USER->IsAdmin();
    }
}

/**
 * IsAdmin
 * @param $value
 */
if (!function_exists("dia") )
{
    function dia($value)
    {
        if ( ia() )
        {
            d($value);
        }
    }
}

/**
 * Sorting array by column.
 * You can use short mode: Collection::sortByColumn($arr, 'value'); This is equal Collection::sortByColumn($arr, array('value' => SORT_ASC))
 *
 * More example:
 * Collection::sortByColumn($arr, array('value' => array(SORT_NUMERIC, SORT_ASC), 'attr' => SORT_DESC), array('attr' => 'strlen'), 'www');
 *
 * @param array        $array
 * @param string|array $columns
 * @param string|array $callbacks
 * @param bool         $preserveKeys If false numeric keys will be re-indexed. If true - preserve.
 * @param null         $defaultValueIfNotSetValue If value not set - use $defaultValueIfNotSetValue (any cols)
 */
function sortByColumn(array &$array, $columns, $callbacks = '', $defaultValueIfNotSetValue = null, $preserveKeys = false)
{
    \Matrix\Main\Type\Collection::sortByColumn($array, $columns, $callbacks, $defaultValueIfNotSetValue, $preserveKeys);
}

function SendError($error)
{
    if(defined('ERROR_EMAIL') && ERROR_EMAIL <> '')
    {
        $from = (defined('ERROR_EMAIL_FROM') && ERROR_EMAIL_FROM <> ''? ERROR_EMAIL_FROM : 'error@matrix.ru');
        $reply_to = (defined('ERROR_EMAIL_REPLY_TO') && ERROR_EMAIL_REPLY_TO <> ''? ERROR_EMAIL_REPLY_TO : 'admin@matrix.ru');
        bxmail(ERROR_EMAIL, $_SERVER['HTTP_HOST'].": Error!",
            $error.
            "HTTP_GET_VARS:\n".mydump($_GET)."\n\n".
            "HTTP_POST_VARS:\n".mydump($_POST)."\n\n".
            "HTTP_COOKIE_VARS:\n".mydump($_COOKIE)."\n\n".
            "HTTP_SERVER_VARS:\n".mydump($_SERVER)."\n\n",
            "From: ".$from."\r\n".
            "Reply-To: ".$reply_to."\r\n".
            "X-Mailer: PHP/" . phpversion()
        );
    }
}

function AddMessage2Log($sText, $sModule = "", $traceDepth = 6, $bShowArgs = false)
{
    if (defined("LOG_FILENAME") && strlen(LOG_FILENAME)>0)
    {
        if(!is_string($sText))
        {
            $sText = var_export($sText, true);
        }
        if (strlen($sText)>0)
        {
            ignore_user_abort(true);
            if ($fp = @fopen(LOG_FILENAME, "ab"))
            {
                if (flock($fp, LOCK_EX))
                {
                    @fwrite($fp, "Host: ".$_SERVER["HTTP_HOST"]."\nDate: ".date("Y-m-d H:i:s")."\nModule: ".$sModule."\n".$sText."\n");
                    $arBacktrace = Matrix\Main\Diag\Helper::getBackTrace($traceDepth, ($bShowArgs? null : DEBUG_BACKTRACE_IGNORE_ARGS));
                    $strFunctionStack = "";
                    $strFilesStack = "";
                    $iterationsCount = min(count($arBacktrace), $traceDepth);
                    for ($i = 1; $i < $iterationsCount; $i++)
                    {
                        if (strlen($strFunctionStack)>0)
                            $strFunctionStack .= " < ";

                        if (isset($arBacktrace[$i]["class"]))
                            $strFunctionStack .= $arBacktrace[$i]["class"]."::";

                        $strFunctionStack .= $arBacktrace[$i]["function"];

                        if(isset($arBacktrace[$i]["file"]))
                            $strFilesStack .= "\t".$arBacktrace[$i]["file"].":".$arBacktrace[$i]["line"]."\n";
                        if($bShowArgs && isset($arBacktrace[$i]["args"]))
                        {
                            $strFilesStack .= "\t\t";
                            if (isset($arBacktrace[$i]["class"]))
                                $strFilesStack .= $arBacktrace[$i]["class"]."::";
                            $strFilesStack .= $arBacktrace[$i]["function"];
                            $strFilesStack .= "(\n";
                            foreach($arBacktrace[$i]["args"] as $value)
                                $strFilesStack .= "\t\t\t".$value."\n";
                            $strFilesStack .= "\t\t)\n";

                        }
                    }

                    if (strlen($strFunctionStack)>0)
                    {
                        @fwrite($fp, "    ".$strFunctionStack."\n".$strFilesStack);
                    }

                    @fwrite($fp, "----------\n");
                    @fflush($fp);
                    @flock($fp, LOCK_UN);
                    @fclose($fp);
                }
            }
            ignore_user_abort(false);
        }
    }
}

function EscapePHPString($str, $encloser = '"')
{
    if($encloser == "'")
    {
        $from = array("\\", "'");
        $to = array("\\\\", "\\'");
    }
    else
    {
        $from = array("\\", "\$", "\"");
        $to = array("\\\\", "\\\$", "\\\"");
    }

    return str_replace($from, $to, $str);
}

function GetMenuTypes($site=false, $default_value=false)
{
    if($default_value === false)
        $default_value = "left=".GetMessage("main_tools_menu_left").",top=".GetMessage("main_tools_menu_top");

    $mt = COption::GetOptionString("fileman", "menutypes", $default_value, $site);
    if (!$mt)
        return Array();

    $armt_ = unserialize(stripslashes($mt));
    $armt = Array();
    if (is_array($armt_))
    {
        foreach($armt_ as $key => $title)
        {
            $key = trim($key);
            if (strlen($key) == 0)
                continue;
            $armt[$key] = trim($title);
        }
        return $armt;
    }

    $armt_ = explode(",", $mt);
    for ($i = 0, $c = count($armt_); $i < $c; $i++)
    {
        $pos = strpos($armt_[$i], '=');
        if ($pos === false)
            continue;
        $key = trim(substr($armt_[$i], 0, $pos));
        if (strlen($key) == 0)
            continue;
        $armt[$key] = trim(substr($armt_[$i], $pos + 1));
    }
    return $armt;
}

function SetMenuTypes($armt, $site = '', $description = false)
{
    return COption::SetOptionString('fileman', "menutypes", addslashes(serialize($armt)), $description, $site);
}

/**
 * Minimum function list
 * @param $string
 * @param int $flags
 * @return string
 */
if (!function_exists('htmlspecialcharsbx')){
    function htmlspecialcharsbx($string, $flags=ENT_COMPAT){
        //shitty function for php 5.4 where default encoding is UTF-8
        return htmlspecialchars($string, $flags, (defined("MX_UTF")? "UTF-8" : "ISO-8859-1"));
    }
}

/**
 * Minimum function list
 * @param $string
 * @return string
 */
if (!function_exists('htmlspecialcharsback')){
    function htmlspecialcharsback($str)
    {
        static $search =  array("&lt;", "&gt;", "&quot;", "&apos;", "&amp;");
        static $replace = array("<",    ">",    "\"",     "'",      "&");
        return str_replace($search, $replace, $str);
    }
}

function GetFileType($path)
{
    $extension = GetFileExtension(strtolower($path));
    switch ($extension)
    {
        case "jpg": case "jpeg": case "gif": case "bmp": case "png":
        $type = "IMAGE";
        break;
        case "swf":
            $type = "FLASH";
            break;
        case "html": case "htm": case "asp": case "aspx":
        case "phtml": case "php": case "php3": case "php4": case "php5": case "php6":
        case "shtml": case "sql": case "txt": case "inc": case "js": case "vbs":
        case "tpl": case "css": case "shtm":
        $type = "SOURCE";
        break;
        default:
            $type = "UNKNOWN";
    }
    return $type;
}

function GetDirectoryIndex($path, $strDirIndex=false)
{
    return GetDirIndex($path, $strDirIndex);
}

function GetDirIndex($path, $strDirIndex=false)
{
    $doc_root = ($_SERVER["DOCUMENT_ROOT"] <> ''? $_SERVER["DOCUMENT_ROOT"] : $GLOBALS["DOCUMENT_ROOT"]);
    $dir = GetDirPath($path);
    $arrDirIndex = GetDirIndexArray($strDirIndex);
    if(is_array($arrDirIndex) && !empty($arrDirIndex))
    {
        foreach($arrDirIndex as $page_index)
            if(file_exists($doc_root.$dir.$page_index))
                return $page_index;
    }
    return "index.php";
}

function GetDirIndexArray($strDirIndex=false)
{
    static $arDefault = array("index.php", "index.html", "index.htm", "index.phtml", "default.html", "index.php3");

    if($strDirIndex === false && !defined("DIRECTORY_INDEX"))
        return $arDefault;

    if($strDirIndex === false && defined("DIRECTORY_INDEX"))
        $strDirIndex = DIRECTORY_INDEX;

    $arrRes = array();
    $arr = explode(" ", $strDirIndex);
    foreach($arr as $page_index)
    {
        $page_index = trim($page_index);
        if($page_index <> '')
            $arrRes[] = $page_index;
    }
    return $arrRes;
}

/**
 * light version of GetPagePath() for menu links
 * @param $page
 * @param null $get_index_page
 * @return bool|string
 */
function GetPagePath($page=false, $get_index_page=null)
{
    if (null === $get_index_page)
    {
        if (defined('BX_DISABLE_INDEX_PAGE'))
            $get_index_page = !BX_DISABLE_INDEX_PAGE;
        else
            $get_index_page = true;
    }

    if($page===false && $_SERVER["REQUEST_URI"]<>"")
        $page = $_SERVER["REQUEST_URI"];
    if($page===false)
        $page = $_SERVER["SCRIPT_NAME"];

    $sPath = $page;

    static $terminate = array("?", "#");
    foreach($terminate as $term)
    {
        if(($found = strpos($sPath, $term)) !== false)
        {
            $sPath = substr($sPath, 0, $found);
        }
    }

    //nginx fix
    $sPath = preg_replace("/%+[0-9a-f]{0,1}$/i", "", $sPath);

    $sPath = urldecode($sPath);

    //Decoding UTF uri
    $sPath = CUtil::ConvertToLangCharset($sPath);

    if(substr($sPath, -1, 1) == "/" && $get_index_page)
    {
        $sPath .= GetDirectoryIndex($sPath);
    }

    $sPath = Rel2Abs("/", $sPath);

    static $aSearch = array("<", ">", "\"", "'", "%", "\r", "\n", "\t", "\\");
    static $aReplace = array("&lt;", "&gt;", "&quot;", "&#039;", "%25", "%0d", "%0a", "%09", "%5C");
    $sPath = str_replace($aSearch, $aReplace, $sPath);

    return $sPath;
}

/**
 * @param bool $page
 * @param null $get_index_page
 * @return bool|mixed|string
 */
function GetPagePathFull($page=false, $get_index_page=null)
{
    if (null === $get_index_page)
    {
        if (defined('MX_DISABLE_INDEX_PAGE'))
            $get_index_page = !MX_DISABLE_INDEX_PAGE;
        else
            $get_index_page = true;
    }

    if($page===false && $_SERVER["REQUEST_URI"]<>"")
        $page = $_SERVER["REQUEST_URI"];
    if($page===false)
        $page = $_SERVER["SCRIPT_NAME"];

    $sPath = $page;

    static $terminate = array("?", "#");
    foreach($terminate as $term)
    {
        if(($found = strpos($sPath, $term)) !== false)
        {
            $sPath = substr($sPath, 0, $found);
        }
    }

    //nginx fix
    $sPath = preg_replace("/%+[0-9a-f]{0,1}$/i", "", $sPath);

    $sPath = urldecode($sPath);

    //Decoding UTF uri
    $sPath = CUtil::ConvertToLangCharset($sPath);

    if(substr($sPath, -1, 1) == "/" && $get_index_page)
    {
        $sPath .= GetDirectoryIndex($sPath);
    }

    $sPath = Rel2Abs("/", $sPath);

    static $aSearch = array("<", ">", "\"", "'", "%", "\r", "\n", "\t", "\\");
    static $aReplace = array("&lt;", "&gt;", "&quot;", "&#039;", "%25", "%0d", "%0a", "%09", "%5C");
    $sPath = str_replace($aSearch, $aReplace, $sPath);

    return $sPath;
}

/**
 * @return bool|float
 */
function IsIE()
{
    global $HTTP_USER_AGENT;
    if(
        strpos($HTTP_USER_AGENT, "Opera") == false
        && preg_match('#(MSIE|Internet Explorer) ([0-9]+)\\.([0-9]+)#', $HTTP_USER_AGENT, $version)
    )
    {
        if(intval($version[2]) > 0)
            return doubleval($version[2].".".$version[3]);
        else
            return false;
    }
    else
    {
        return false;
    }
}

/**
 * @param $path
 * @return bool|mixed|string
 */
function GetFileName($path)
{
    $path = TrimUnsafe($path);
    $path = str_replace("\\", "/", $path);
    $path = rtrim($path, "/");

    $p = bxstrrpos($path, "/");
    if($p !== false)
        return substr($path, $p+1);

    return $path;
}

/**
 * @param $path
 * @return bool|string
 *
 */
function GetFileExtension($path)
{
    $path = GetFileName($path);
    if($path <> '')
    {
        $pos = bxstrrpos($path, '.');
        if($pos !== false)
            return substr($path, $pos+1);
    }
    return '';
}

/**
 * @param $sPath
 * @return bool|string
 */
function GetDirPath($sPath)
{
    if(strlen($sPath))
    {
        $p = strrpos($sPath, "/");
        if($p === false)
            return '/';
        else
            return substr($sPath, 0, $p+1);
    }
    else
    {
        return '/';
    }
}

/**
 * @return bool|string
 */
function GetRequestUri()
{
    $uriPath = "/".ltrim($_SERVER["REQUEST_URI"], "/");
    if (($index = strpos($uriPath, "?")) !== false)
    {
        $uriPath = substr($uriPath, 0, $index);
    }

    if (defined("MX_DISABLE_INDEX_PAGE") && MX_DISABLE_INDEX_PAGE === true)
    {
        if (substr($uriPath, -10) === "/index.php")
        {
            $uriPath = substr($uriPath, 0, -9);
        }
    }

    $queryString = DeleteParam(array("bxrand", "SEF_APPLICATION_CUR_PAGE_URL"));
    if ($queryString != "")
    {
        $uriPath = $uriPath."?".$queryString;
    }

    return $uriPath;
}

/**
 * @param $ParamNames
 * @return string
 */
function DeleteParam($ParamNames)
{
    if(count($_GET) < 1)
        return "";

    $aParams = $_GET;
    foreach(array_keys($aParams) as $key)
    {
        foreach($ParamNames as $param)
        {
            if(strcasecmp($param, $key) == 0)
            {
                unset($aParams[$key]);
                break;
            }
        }
    }

    return http_build_query($aParams, "", "&");
}

/**
 * @param $path
 * @param string $baseFolder
 * @return bool|string
 */
function getLocalPath($path, $baseFolder = "/matrix")
{
    $root = rtrim($_SERVER["DOCUMENT_ROOT"], "\\/");

    static $hasLocalDir = null;
    if($hasLocalDir === null)
    {
        $hasLocalDir = is_dir($root."/local");
    }

    if($hasLocalDir && file_exists($root."/local/".$path))
    {
        return "/local/".$path;
    }
    elseif(file_exists($root.$baseFolder."/".$path))
    {
        return $baseFolder."/".$path;
    }
    return false;
}

/**
 * @param $path
 * @param bool $bPermission
 * @return bool
 */
function CheckDirPath($path, $bPermission=true)
{
    $path = str_replace(array("\\", "//"), "/", $path);

    //remove file name
    if(substr($path, -1) != "/")
    {
        $p = strrpos($path, "/");
        $path = substr($path, 0, $p);
    }

    $path = rtrim($path, "/");

    if(!file_exists($path))
        return mkdir($path, MX_DIR_PERMISSIONS, true);
    else
        return is_dir($path);
}

/**
 * light version of GetPagePath() for menu links
 * @param $page
 * @param null $get_index_page
 * @return bool|string
 */
function GetFileFromURL($page, $get_index_page=null)
{
    if (null === $get_index_page)
    {
        if (defined('MX_DISABLE_INDEX_PAGE'))
            $get_index_page = !MX_DISABLE_INDEX_PAGE;
        else
            $get_index_page = true;
    }

    $found = strpos($page, "?");
    $sPath = ($found !== false? substr($page, 0, $found) : $page);

    $sPath = urldecode($sPath);

    if(substr($sPath, -1, 1) == "/" && $get_index_page)
        $sPath .= GetDirectoryIndex($sPath);

    return $sPath;
}

/*
This function emulates php internal function basename
but does not behave badly on broken locale settings
*/
function bx_basename($path, $ext="")
{
    $path = rtrim($path, "\\/");
    if(preg_match("#[^\\\\/]+$#", $path, $match))
        $path = $match[0];

    if($ext)
    {
        $ext_len = strlen($ext);
        if(strlen($path) > $ext_len && substr($path, -$ext_len) == $ext)
            $path = substr($path, 0, -$ext_len);
    }

    return $path;
}

function bxstrrpos($haystack, $needle)
{
    if(defined("MX_UTF"))
    {
        //mb_strrpos does not work on invalid UTF-8 strings
        $ln = strlen($needle);
        for($i = strlen($haystack)-$ln; $i >= 0; $i--)
            if(substr($haystack, $i, $ln) == $needle)
                return $i;
        return false;
    }
    return strrpos($haystack, $needle);
}

function Rel2Abs($curdir, $relpath)
{
    if($relpath == "")
        return false;

    if(substr($relpath, 0, 1) == "/" || preg_match("#^[a-z]:/#i", $relpath))
    {
        $res = $relpath;
    }
    else
    {
        if(substr($curdir, 0, 1) != "/" && !preg_match("#^[a-z]:/#i", $curdir))
            $curdir = "/".$curdir;
        if(substr($curdir, -1) != "/")
            $curdir .= "/";
        $res = $curdir.$relpath;
    }

    if(($p = strpos($res, "\0")) !== false)
        $res = substr($res, 0, $p);

    $res = _normalizePath($res);

    if(substr($res, 0, 1) !== "/" && !preg_match("#^[a-z]:/#i", $res))
        $res = "/".$res;

    $res = rtrim($res, ".\\+ ");

    return $res;
}

function _normalizePath($strPath)
{
    $strResult = '';
    if($strPath <> '')
    {
        if(strncasecmp(PHP_OS, "WIN", 3) == 0)
        {
            //slashes doesn't matter for Windows
            $strPath = str_replace("\\", "/", $strPath);
        }

        $arPath = explode('/', $strPath);
        $nPath = count($arPath);
        $pathStack = array();

        for ($i = 0; $i < $nPath; $i++)
        {
            if ($arPath[$i] === ".")
                continue;
            if (($arPath[$i] === '') && ($i !== ($nPath - 1)) && ($i !== 0))
                continue;

            if ($arPath[$i] === "..")
                array_pop($pathStack);
            else
                array_push($pathStack, $arPath[$i]);
        }

        $strResult = implode("/", $pathStack);
    }
    return $strResult;
}

function removeDocRoot($path)
{
    $len = strlen($_SERVER["DOCUMENT_ROOT"]);

    if (substr($path, 0, $len) == $_SERVER["DOCUMENT_ROOT"])
        return "/".ltrim(substr($path, $len), "/");
    else
        return $path;
}

function TrimUnsafe($path)
{
    return rtrim($path, "\0.\\/+ ");
}

/*********************************************************************
Language files
 *********************************************************************/
/**
 * @param $filepath
 * @param bool $lang
 * @param bool $bReturnArray
 */
function IncludeModuleLangFile($filepath, $lang=false, $bReturnArray=false)
{
    \Matrix\Main\Localization\Loc::loadLanguageFile(__FILE__);
}

/**
 * @param $name
 * @param bool $aReplace
 * @return mixed
 */
function GetMessageJS($name, $aReplace=false)
{
    return CUtil::JSEscape(GetMessage($name, $aReplace));
}

/**
 * @param $name
 * @param null $aReplace
 * @return mixed|string
 */
function GetMessage($name, $aReplace=null)
{
    /*
    global $MESS;
    if(isset($MESS[$name]))
    {
        $s = $MESS[$name];
        if($aReplace!==null && is_array($aReplace))
            foreach($aReplace as $search=>$replace)
                $s = str_replace($search, $replace, $s);
        return $s;
    }
    */
    return \Matrix\Main\Localization\Loc::getMessage($name, $aReplace);
}

/**
 * @param $a
 * @param bool $k
 * @return bool
 */
function is_set(&$a, $k=false)
{
    if ($k===false)
        return isset($a);

    if(is_array($a))
        return array_key_exists($k, $a);

    return false;
}

/**
 * @return string
 */
function matrix_sess_sign()
{
    return md5("nobody".CMain::GetServerUniqID()."nowhere");
}

/**
 * @return bool
 */
function isSessionExpired()
{
    return isset($_SESSION["IS_EXPIRED"]) && $_SESSION["IS_EXPIRED"] === true;
}

function matrix_sessid()
{
    if(!is_array($_SESSION) || !isset($_SESSION['fixed_session_id']))
        matrix_sessid_set();
    return $_SESSION["fixed_session_id"];
}

function matrix_sessid_set($val=false)
{
    if($val === false)
        $val = matrix_sessid_val();
    $_SESSION["fixed_session_id"] = $val;
}

function matrix_sessid_val()
{
    return md5(CMain::GetServerUniqID().session_id());
}

function check_matrix_sessid($varname='sessid')
{
    global $USER;
    if(defined("MATRIX_STATIC_PAGES") && (!is_object($USER) || !$USER->IsAuthorized()))
        return true;
    else
        return $_REQUEST[$varname] == matrix_sessid();
}

function matrix_sessid_get($varname='sessid')
{
    return $varname."=".matrix_sessid();
}

function matrix_sessid_post($varname='sessid', $returnInvocations=false)
{
    static $invocations = 0;
    if ($returnInvocations)
    {
        return $invocations;
    }

    $id = $invocations ? $varname.'_'.$invocations : $varname;
    $invocations++;

    return '<input type="hidden" name="'.$varname.'" id="'.$id.'" value="'.matrix_sessid().'" />';
}

function print_url($strUrl, $strText, $sParams="")
{
    return (strlen($strUrl) <= 0? $strText : "<a href=\"".$strUrl."\" ".$sParams.">".$strText."</a>");
}

/**
 * String functions
 */
function randString($pass_len=10, $pass_chars=false)
{
    static $allchars = "abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ0123456789";
    $string = "";
    if(is_array($pass_chars))
    {
        while(strlen($string) < $pass_len)
        {
            if(function_exists('shuffle'))
                shuffle($pass_chars);
            foreach($pass_chars as $chars)
            {
                $n = strlen($chars) - 1;
                $string .= $chars[mt_rand(0, $n)];
            }
        }
        if(strlen($string) > count($pass_chars))
            $string = substr($string, 0, $pass_len);
    }
    else
    {
        if($pass_chars !== false)
        {
            $chars = $pass_chars;
            $n = strlen($pass_chars) - 1;
        }
        else
        {
            $chars = $allchars;
            $n = 61; //strlen($allchars)-1;
        }
        for ($i = 0; $i < $pass_len; $i++)
            $string .= $chars[mt_rand(0, $n)];
    }
    return $string;
}
//alias for randString()
function GetRandomCode($len=8)
{
    return randString($len);
}

function TruncateText($strText, $intLen)
{
    if(strlen($strText) > $intLen)
        return rtrim(substr($strText, 0, $intLen), ".")."...";
    else
        return $strText;
}

function InsertSpaces($sText, $iMaxChar=80, $symbol=" ", $bHTML=false)
{
    $iMaxChar = intval($iMaxChar);
    if ($iMaxChar > 0 && strlen($sText) > $iMaxChar)
    {
        if ($bHTML)
        {
            $obSpacer = new CSpacer($iMaxChar, $symbol);
            return $obSpacer->InsertSpaces($sText);
        }
        else
        {
            return preg_replace("/([^() \\n\\r\\t%!?{}\\][-]{".$iMaxChar."})/".MX_UTF_PCRE_MODIFIER,"\\1".$symbol, $sText);
        }
    }
    return $sText;
}


function TrimExAll($str,$symbol)
{
    while (substr($str,0,1)==$symbol or substr($str,strlen($str)-1,1)==$symbol)
        $str = TrimEx($str,$symbol);

    return $str;
}

function TrimEx($str,$symbol,$side="both")
{
    $str = trim($str);
    if ($side=="both")
    {
        if (substr($str,0,1) == $symbol) $str = substr($str,1,strlen($str));
        if (substr($str,strlen($str)-1,1) == $symbol) $str = substr($str,0,strlen($str)-1);
    }
    elseif ($side=="left")
    {
        if (substr($str,0,1) == $symbol) $str = substr($str,1,strlen($str));
    }
    elseif ($side=="right")
    {
        if (substr($str,strlen($str)-1,1) == $symbol) $str = substr($str,0,strlen($str)-1);
    }
    return $str;
}

function utf8win1251($s)
{
    /** @global CMain $APPLICATION */
    global $APPLICATION;

    return $APPLICATION->ConvertCharset($s, "UTF-8", "Windows-1251");
}

function ToUpper($str, $lang = false)
{
    static $lower = array();
    static $upper = array();
    if(!defined("MX_CUSTOM_TO_UPPER_FUNC"))
    {
        if(defined("MX_UTF"))
        {
            return strtoupper($str);
        }
        else
        {
            if($lang === false)
                $lang = LANGUAGE_ID;
            if(!isset($lower[$lang]))
            {
                $arMsg = IncludeModuleLangFile(__FILE__, $lang, true);
                $lower[$lang] = $arMsg["ABC_LOWER"];
                $upper[$lang] = $arMsg["ABC_UPPER"];
            }
            return strtoupper(strtr($str, $lower[$lang], $upper[$lang]));
        }
    }
    else
    {
        $func = MX_CUSTOM_TO_UPPER_FUNC;
        return $func($str);
    }
}

function ToLower($str, $lang = false)
{
    static $lower = array();
    static $upper = array();
    if(!defined("MX_CUSTOM_TO_LOWER_FUNC"))
    {
        if(defined("MX_UTF"))
        {
            return strtolower($str);
        }
        else
        {
            if($lang === false)
                $lang = LANGUAGE_ID;
            if(!isset($lower[$lang]))
            {
                $arMsg = IncludeModuleLangFile(__FILE__, $lang, true);
                $lower[$lang] = $arMsg["ABC_LOWER"];
                $upper[$lang] = $arMsg["ABC_UPPER"];
            }
            return strtolower(strtr($str, $upper[$lang], $lower[$lang]));
        }
    }
    else
    {
        $func = MX_CUSTOM_TO_LOWER_FUNC;
        return $func($str);
    }
}

/**
 * @param $str
 * @return mixed
 */
function htmlspecialcharsEx($str)
{
    static $search =  array("&amp;",     "&lt;",     "&gt;",     "&quot;",     "&#34",     "&#x22",     "&#39",     "&#x27",     "<",    ">",    "\"");
    static $replace = array("&amp;amp;", "&amp;lt;", "&amp;gt;", "&amp;quot;", "&amp;#34", "&amp;#x22", "&amp;#39", "&amp;#x27", "&lt;", "&gt;", "&quot;");
    return str_replace($search, $replace, $str);
}

/**
 * @param $email
 * @param bool $bStrict
 * @return bool
 */
function check_email($email, $bStrict=false)
{
    if(!$bStrict)
    {
        $email = trim($email);
        if(preg_match("#.*?[<\\[\\(](.*?)[>\\]\\)].*#i", $email, $arr) && strlen($arr[1])>0)
            $email = $arr[1];
    }

    //http://tools.ietf.org/html/rfc2821#section-4.5.3.1
    //4.5.3.1. Size limits and minimums
    if(strlen($email) > 320)
    {
        return false;
    }

    //http://tools.ietf.org/html/rfc2822#section-3.2.4
    //3.2.4. Atom
    static $atom = "=_0-9a-z+~'!\$&*^`|\\#%/?{}-";

    //"." can't be in the beginning or in the end of local-part
    //dot-atom-text = 1*atext *("." 1*atext)
    if(preg_match("#^[".$atom."]+(\\.[".$atom."]+)*@(([-0-9a-z_]+\\.)+)([a-z0-9-]{2,20})$#i", $email))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * Array functions
 */

/*
удаляет дубли в массиве сортировки
массив
Array
(
	[0] => T.NAME DESC
	[1] => T.NAME ASC
	[2] => T.ID ASC
	[3] => T.ID DESC
	[4] => T.DESC
)
преобразует в
Array
(
	[0] => T.NAME DESC
	[1] => T.ID ASC
	[2] => T.DESC ASC
)
*/
function DelDuplicateSort(&$arSort)
{
    if (is_array($arSort) && count($arSort)>0)
    {
        $arSort2 = array();
        foreach($arSort as $val)
        {
            $arSort1 = explode(" ", trim($val));
            $order = array_pop($arSort1);
            $order_ = strtoupper(trim($order));
            if (!($order_=="DESC" || $order_=="ASC"))
            {
                $arSort1[] = $order;
                $order_ = "";
            }
            $by = implode(" ", $arSort1);
            if(strlen($by)>0 && !array_key_exists($by, $arSort2))
                $arSort2[$by] = $order_;
        }
        $arSort = array();
        foreach($arSort2 as $by=>$order)
            $arSort[] = $by." ".$order;
    }
}

/*********************************************************************
Other functions
 *********************************************************************/

function bxmail($to, $subject, $message, $additional_headers="", $additional_parameters="")
{
    if(function_exists("custom_mail"))
        return custom_mail($to, $subject, $message, $additional_headers, $additional_parameters);

    if($additional_parameters!="")
        return @mail($to, $subject, $message, $additional_headers, $additional_parameters);

    return @mail($to, $subject, $message, $additional_headers);
}

/**
 * @param $url
 * @param bool $skip_security_check
 * @param string $status
 */
function LocalRedirect($url, $skip_security_check=false, $status="302 Found")
{
    /** @global CMain $APPLICATION */
    global $APPLICATION;
    /** @global CDatabase $DB */
    global $DB;

    $bExternal = preg_match("'^(http://|https://|ftp://)'i", $url);

    if(!$bExternal && strpos($url, "/") !== 0)
    {
        $url = $APPLICATION->GetCurDir().$url;
    }

    //doubtful
    $url = str_replace("&amp;", "&", $url);
    // http response splitting defence
    $url = str_replace(array("\r", "\n"), "", $url);

    if(!defined("MX_UTF") && defined("LANG_CHARSET"))
    {
        $url = \Matrix\Main\Text\Encoding::convertEncoding($url, LANG_CHARSET, "UTF-8");
    }

    /*
    if(function_exists("getmoduleevents"))
    {
        foreach(GetModuleEvents("main", "OnBeforeLocalRedirect", true) as $arEvent)
        {
            ExecuteModuleEventEx($arEvent, array(&$url, $skip_security_check, $bExternal));
        }
    }
    */

    if(!$bExternal)
    {
        //store cookies for next hit (see CMain::GetSpreadCookieHTML())
        $APPLICATION->StoreCookies();

        $host = $_SERVER['HTTP_HOST'];
        if($_SERVER['SERVER_PORT'] <> 80 && $_SERVER['SERVER_PORT'] <> 443 && $_SERVER['SERVER_PORT'] > 0 && strpos($_SERVER['HTTP_HOST'], ":") === false)
        {
            $host .= ":".$_SERVER['SERVER_PORT'];
        }

        $protocol = (CMain::IsHTTPS() ? "https" : "http");

        $url = $protocol."://".$host.$url;
    }

    //CHTTP::SetStatus($status);

    header("Location: ".$url);
/*
    if(function_exists("getmoduleevents"))
    {
        foreach(GetModuleEvents("main", "OnLocalRedirect", true) as $arEvent)
            ExecuteModuleEventEx($arEvent);
    }
*/
    $_SESSION["MX_REDIRECT_TIME"] = time();

    CMain::ForkActions();
    exit;
}