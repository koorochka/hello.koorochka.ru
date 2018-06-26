<?
/**
 * @var CMain $APPLICATION
 * @var CUser $USER
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/matrix/header.php");
$APPLICATION->SetTitle($USER->GetFullName());
$APPLICATION->AddChainItem("Редактор композиций");
//define("NEED_AUTH", true);
if(!$USER->IsAuthorized()){
    LocalRedirect("/personal/");
}
?>



<?require_once($_SERVER["DOCUMENT_ROOT"]."/matrix/footer.php");?>