<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2013 Bitrix
 */

/**
 * Bitrix vars
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*
Authorization form (for prolog)
Params:
	REGISTER_URL => path to page with authorization script (component?)
	PROFILE_URL => path to page with profile component
*/

$arParamsToDelete = array(
	"login",
	"login_form",
	"logout",
	"register",
	"forgot_password",
	"change_password",
	"confirm_registration",
	"confirm_code",
	"confirm_user_id",
	"logout_butt",
	"auth_service_id",
);

$currentUrl = $APPLICATION->GetCurPageParam("", $arParamsToDelete);

$arResult["BACKURL"] = $currentUrl;

$arResult['ERROR'] = false;
$arResult['SHOW_ERRORS'] = (array_key_exists('SHOW_ERRORS', $arParams) && $arParams['SHOW_ERRORS'] == 'Y'? 'Y' : 'N');
$arResult["RND"] = $this->randString();

if(!$USER->IsAuthorized())
{
	$arResult["STORE_PASSWORD"] = COption::GetOptionString("main", "store_password", "Y") == "Y" ? "Y" : "N";
	$arResult["NEW_USER_REGISTRATION"] = COption::GetOptionString("main", "new_user_registration", "N") == "Y" ? "Y" : "N";

	if(defined("AUTH_404"))
		$arResult["AUTH_URL"] = htmlspecialcharsback(POST_FORM_ACTION_URI);
	else
		$arResult["AUTH_URL"] = $APPLICATION->GetCurPageParam("login=yes", array_merge($arParamsToDelete, array("logout_butt", "backurl")));

	$arParams["REGISTER_URL"] = ($arParams["REGISTER_URL"] <> ''? $arParams["REGISTER_URL"] : $currentUrl);
	$arParams["FORGOT_PASSWORD_URL"] = ($arParams["FORGOT_PASSWORD_URL"] <> ''? $arParams["FORGOT_PASSWORD_URL"] : $arParams["REGISTER_URL"]);

	$url = urlencode($APPLICATION->GetCurPageParam("", array_merge($arParamsToDelete, array("backurl"))));

	$custom_reg_page = COption::GetOptionString('main', 'custom_register_page');
	$arResult["AUTH_REGISTER_URL"] = $arParams["REGISTER_URL"];
	$arResult["AUTH_FORGOT_PASSWORD_URL"] = $arParams["FORGOT_PASSWORD_URL"];
	$arResult["AUTH_LOGIN_URL"] = $APPLICATION->GetCurPageParam("login_form=yes", $arParamsToDelete);

	$arRes = array();
	foreach($arResult as $key=>$value)
	{
		$arRes[$key] = htmlspecialcharsbx($value);
		$arRes['~'.$key] = $value;
	}
	$arResult = $arRes;

    $arResult["FORM_TYPE"] = "login";

    $arVarExcl = array("USER_LOGIN"=>1, "USER_PASSWORD"=>1, "backurl"=>1, "auth_service_id"=>1, "TYPE"=>1, "AUTH_FORM"=>1);
    $arResult["GET"] = array();
    $arResult["POST"] = array();
    foreach($_POST as $vname=>$vvalue)
    {
        if(!isset($arVarExcl[$vname]))
        {
            if(!is_array($vvalue))
            {
                $arResult["POST"][htmlspecialcharsbx($vname)] = htmlspecialcharsbx($vvalue);
            }
            else
            {
                foreach($vvalue as $k1 => $v1)
                {
                    if(is_array($v1))
                    {
                        foreach($v1 as $k2 => $v2)
                        {
                            if(!is_array($v2))
                                $arResult["POST"][htmlspecialcharsbx($vname)."[".htmlspecialcharsbx($k1)."][".htmlspecialcharsbx($k2)."]"] = htmlspecialcharsbx($v2);
                        }
                    }
                    else
                    {
                        $arResult["POST"][htmlspecialcharsbx($vname)."[".htmlspecialcharsbx($k1)."]"] = htmlspecialcharsbx($v1);
                    }
                }
            }
        }
    }

    $loginCookieName = COption::GetOptionString("main", "cookie_name", "BITRIX_SM")."_LOGIN";
    $arResult["~LOGIN_COOKIE_NAME"] = $loginCookieName;
    $arResult["~USER_LOGIN"] = $_COOKIE[$loginCookieName];
    $arResult["USER_LOGIN"] = $arResult["LAST_LOGIN"] = htmlspecialcharsbx($arResult["~USER_LOGIN"]);
    $arResult["~LAST_LOGIN"] = $arResult["~USER_LOGIN"];

    $arResult["AUTH_SERVICES"] = false;
    $arResult["CURRENT_SERVICE"] = false;

    $arResult["SECURE_AUTH"] = false;


    if($APPLICATION->NeedCAPTHAForLogin($arResult["USER_LOGIN"]))
        $arResult["CAPTCHA_CODE"] = $APPLICATION->CaptchaGetCode();
    else
        $arResult["CAPTCHA_CODE"] = false;

	if(isset($APPLICATION->arAuthResult) && $APPLICATION->arAuthResult !== true)
		$arResult['ERROR_MESSAGE'] = $APPLICATION->arAuthResult;

	if($arResult['ERROR_MESSAGE'] <> '')
		$arResult['ERROR'] = true;
}
else
{
	$arResult["FORM_TYPE"] = "logout";

	$arResult["AUTH_URL"] = $currentUrl;
	$arResult["PROFILE_URL"] = $arParams["PROFILE_URL"].(strpos($arParams["PROFILE_URL"], "?") !== false? "&" : "?")."backurl=".urlencode($currentUrl);

	$arRes = array();
	foreach($arResult as $key=>$value)
	{
		$arRes[$key] = htmlspecialcharsbx($value);
		$arRes['~'.$key] = $value;
	}
	$arResult = $arRes;

	$arResult["USER_NAME"] = htmlspecialcharsEx($USER->GetFormattedName(false, false));
	$arResult["USER_LOGIN"] = htmlspecialcharsEx($USER->GetLogin());

	$arResult["POST"] = array();
	$arResult["GET"] = array();
	foreach($_GET as $vname=>$vvalue)
		if(!is_array($vvalue) && $vname!="backurl" && $vname != "login" && $vname != "auth_service_id")
			$arResult["GET"][htmlspecialcharsbx($vname)] = htmlspecialcharsbx($vvalue);
}

if(isset($_REQUEST["AUTH_FORM"]) && $_REQUEST["AUTH_FORM"] <> '')
{
    if($_REQUEST["TYPE"] == "AUTH")
    {
        $arResult["AUTH_RESULT"] = $GLOBALS["USER"]->Login($_REQUEST["USER_LOGIN"], $_REQUEST["USER_PASSWORD"], $_REQUEST["USER_REMEMBER"]);
    }
    if($arResult["AUTH_RESULT"]){
        LocalRedirect($APPLICATION->GetCurPage());
    }
}

$this->IncludeComponentTemplate();