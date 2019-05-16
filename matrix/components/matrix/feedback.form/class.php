<?
/**
 * Matrix Framework
 * @package matrix
 * @subpackage main
 * @copyright 2017 Matrix
 * Matrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @param array $arParams
 * @param array $arResult
 * @param CMatrixComponent $this
 */

use Koorochka\Persona\FeedbackTable,
    Matrix\Main\Loader,
    Matrix\Main\Localization\Loc,
    Matrix\Main\Type\DateTime;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(class_exists("MatrixFeedbackFormComponent"))
    return;

class MatrixFeedbackFormComponent extends CMatrixComponent
{
    private $_fields;

    // <editor-fold defaultstate="collapsed" desc="# Component params">
    /**
     * @param $arParams
     * @return mixed
     */
	public function onPrepareComponentParams($arParams)
	{
        $arParams["DELAY"] = (isset($arParams["DELAY"]) && $arParams["DELAY"] == "Y" ? "Y" : "N");
		return $arParams;
	}
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="# Fields">
    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * @param mixed $fields
     */
    public function setFields()
    {
        $arFields = array();
        $fields = FeedbackTable::getMap();

        foreach ($this->arParams["FIELDS"] as $FIELD){
            if(is_set($fields[$FIELD])){
                $arFields[$FIELD] = array_merge($fields[$FIELD], array("value" => ""));
            }
        }

        $this->_fields = $arFields;
    }

    public function clearFields(){
        foreach ($this->_fields as $id=>$field){
            $this->_fields[$id]["value"] = false;
        }
    }
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="# Respond">
    public function responce()
    {
        global $request;
        $arFields = array();
        // Set fields
        foreach ($this->_fields as $id=>$field){
            $arFields[$id] = trim(htmlspecialchars($request->get("feedback-".$id)));
            $this->_fields[$id]["value"] = $arFields[$id];
            // validation
            switch ($id){
                case "EMAIL":
                    if(!check_email($arFields[$id])){
                        $this->arResult["MESSAGE"] = array(
                            "TYPE" => "ERROR",
                            "TEXT" => Loc::getMessage("FEEDBACK_TABLE_ERROR_EMAIL")
                        );
                    }
                    break;
                case "PHONE":
                    #$phone = "+7(495) 123-25-52";
                    if(!preg_match(
                        "#^[-+0-9()\s]+$#",
                        $arFields[$id],
                        $out
                    ))
                    {
                        $this->arResult["MESSAGE"] = array(
                            "TYPE" => "ERROR",
                            "TEXT" => Loc::getMessage("FEEDBACK_TABLE_ERROR_PHONE")
                        );
                    }
                    break;
            }

        }
        // ad to db
        $arFields["TIMESTAMP_X"] = new DateTime();
        $arFields["ACTIVE"] = "Y";
        $arFields["SORT"] = 100;

        if($this->arResult["MESSAGE"]["TYPE"] !== "ERROR"){
            d("GO");
        }

        /*
        $result = FeedbackTable::add($arFields);
        if($result->isSuccess()){
            // claer values in fields
            $this->clearFields();
            // create message
            $this->arResult["MESSAGE"] = array(
                "TYPE" => "SUCCESS",
                "TEXT" => Loc::getMessage("FEEDBACK_TABLE_SUCCESS_ADD")
            );
            // Todo Send letter

        }
        else{
            $this->arResult["MESSAGE"] = array(
                "TYPE" => "ERROR",
                "TEXT" => $result->getErrorMessages()
            );
        }
        */

    }

    // </editor-fold>

    /**
     * Execution
     */
    public function executeComponent()
    {
        if(!Loader::includeModule("koorochka.persona"))
            return false;
        global $request;
        /**
         * start work with cache
         */
        if($this->startResultCache(false))
        {
            $this->setFields();
            $this->endResultCache();
        }

        if($request->isPost()){
            $this->responce();
        }

        $this->arResult["FILDS"] = $this->getFields();

        $this->IncludeComponentTemplate();
    }
}