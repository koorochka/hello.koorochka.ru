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

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(class_exists("MatrixFeedbackListComponent"))
    return;

use Matrix\Main\Loader,
    Koorochka\Persona\FeedbackTable;

class MatrixFeedbackListComponent extends CMatrixComponent
{
    private $_messages;

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

    // <editor-fold defaultstate="collapsed" desc="# Messages">
    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Set messages from db
     */
    public function setMessages()
    {
        if(!Loader::includeModule("koorochka.persona"))
            return false;
        $messages = array();
        $result = FeedbackTable::getList();
        while ($message = $result->fetch()){
            $messages[] = $message;
        }
        $this->_messages = $messages;
    }
    // </editor-fold>

    /**
     * Execution
     */
    public function executeComponent()
    {

        /**
         * start work with cache
         */
        if($this->startResultCache(false))
        {
            $this->getMessages();
            $this->endResultCache();
        }

        $this->arResult["MESSAGES"] = $this->getMessages();

        $this->IncludeComponentTemplate();
    }
}