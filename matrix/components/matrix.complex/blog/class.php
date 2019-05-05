<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();
if(class_exists("MatrixPersonal"))
    return;

/**
 * Class MatrixPersonal
 */
class MatrixPersonal extends CMatrixComponent
{
    private $_componentPage;
    private $_baseUrl;
    /**
     * parse url to array
     * @param mixed $componentPage
     */
    public function setComponentPage()
    {
        global $request;
        $componentPage = $request->getDecodedUri();
        $componentPage = explode("/", $componentPage);
        $this->_baseUrl = $this->arParams["SEF_BASE_URL"];
        $this->_baseUrl = explode("/", $this->_baseUrl);
        if(empty(end($this->_baseUrl)))
            array_pop($this->_baseUrl);

        if(empty(end($componentPage)))
            array_pop($componentPage);

        if(count($componentPage) > count($this->_baseUrl)){
            $end = end($componentPage);
            if(!empty($end)){
                $this->arResult["POST"] = $componentPage;
                if($end == "addpost"){
                    $componentPage = "add";
                }else{
                    $componentPage = "post";
                }
            }else{
                $componentPage = "list";
            }
        }else{
            $componentPage = "list";
        }

        $this->_componentPage = $componentPage;
    }

    /**
     * Check componentPage element 2
     * @return mixed
     */
    public function getComponentPage()
    {
        return $this->_componentPage;
    }

    /**
     * Execution
     */
    public function executeComponent()
    {
        $this->setComponentPage();
        $this->IncludeComponentTemplate($this->getComponentPage());
    }
}
