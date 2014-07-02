<?php

class SiteController extends Controller
{

    public $layout = '//layouts/main';
    public $numItemsInPage = 12;

    public function actionIndex()
    {
        //$this->forward('uploadimg');
        $this->renderCategory(null);
    }

    public function actionEtno()
    {
        $this->renderCategory(1);
    }

    public function actionClassic()
    {
        $this->renderCategory(2);
    }

    public function actionStones()
    {
        $this->renderCategory(3);
    }

    public function actionModern()
    {
        $this->renderCategory(4);
    }

    public function actionBraces()
    {
        $this->renderCategory(5);
    }

    public function actionContacts()
    {
        $this->render("contacts");
    }
    
    public function actionDetailed($id, $category="index", $page)
    {
        $colors = DBManager::getItemColors($id);
        
        $item_query_data = new ItemQueryData();
        $item_query_data->color = $colors[0]["Color_ID"];
        $same_items = DBManager::getItems($item_query_data);
        
        $this->render("detailed", array(
            "items" => $same_items,
            "item" => DBManager::getItemById($id)));
    }
    
    public function renderCategory($categoryID)
    {
        $queryData = new ItemQueryData();
        $queryData->category = $categoryID;
        $queryData->color = $_GET["Color"];
        $queryData->material = $_GET["Material"];
        $queryData->from_length = $_GET["FromHeight"];
        $queryData->to_length = $_GET["ToHeight"];
        $queryData->from_width = $_GET["FromWidth"];
        $queryData->to_width = $_GET["ToWidth"];
        $queryData->from_price = $_GET["FromPrice"];
        $queryData->to_price = $_GET["ToPrice"];
        
        $this->render('index', array(
            "items" => DBManager::getItems($queryData),
            "categoryID"=>$categoryID
        ));
    }
    
    public function getFilterParams()
    {
        return array(
            "Color" => $_GET["Color"],
            "Material" => $_GET["Material"],
            "FromHeight" => $_GET["FromHeight"],
            "ToHeight" => $_GET["ToHeight"],
            "FromWidth" => $_GET["FromWidth"],
            "ToWidth" => $_GET["ToWidth"],
            "FromPrice" => $_GET["FromPrice"],
            "ToPrice" => $_GET["ToPrice"]);
    }

    public function parseFilterParams()
    {
        $getPagams = $this->getFilterParams();
        $param = http_build_query($getPagams);
        if ($param != '') {
            $param = "&" . $param;
        }
        return  $param;
    }
    
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function ActionAdditem()
    {
        if (isset($_POST['AddItemForm'])) {
            $model = new AddItemForm();
            $model->setAttributes($_POST['AddItemForm'], false);
            if ($model->validate()) {
                $itemId = DBManager::addItem($model);
                $tmpImg = Yii::getPathOfAlias('webroot') . '/images/tmp.jpg';
                $newImg = Yii::getPathOfAlias('webroot') . "/images/$itemId.jpg";
                rename($tmpImg, $newImg);
                $this->forward('uploadimg');
            } else {
                header('Content-type: application/json');
                echo json_encode(array("error" => true));
                Yii::app()->end();
            }
        } else {
            $this->render('additem');
        }
    }

    public function ActionUploadimg()
    {
        if (isset($_FILES['file'])) {
            $fileDestination = Yii::getPathOfAlias('webroot') . '/images/tmp.jpg';
            if (file_exists($fileDestination)) {
                unlink($fileDestination);
            }
            move_uploaded_file($_FILES['file']['tmp_name'], $fileDestination);
            $this->forward("additem");
        } else {
            $this->render('uploadImg');
        }
    }

    
    
}
