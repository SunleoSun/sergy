<?php

class DBManager
{
    public static function getItems(ItemQueryData $item_query_data)
    {
        $whereStr = "";
        
        if(isset($item_query_data->category)) {
            $whereStr .= "item.Category_ID = $item_query_data->category";
        }
        if (isset($item_query_data->color)) {
            if ($whereStr != "") {
                $whereStr .= " AND ";
            }
            $whereStr .= "item_color.Color_ID = $item_query_data->color";
        }
        if (isset($item_query_data->material)) {
            if ($whereStr != "") {
                $whereStr .= " AND ";
            }
            $whereStr .= "item_material.Material_ID = $item_query_data->material";
        }
        $elseWhere = self::getPartWhere(
                $item_query_data->from_length,
                $item_query_data->to_length,
                "Length"
            );
        $elseWhere.=
            self::getPartWhere(
                $item_query_data->from_width,
                $item_query_data->to_width,
                "Width",
                $elseWhere!= ""
            );
        $elseWhere.=
            self::getPartWhere(
                $item_query_data->from_price,
                $item_query_data->to_price,
                "Price",
                $elseWhere!= ""
            );
        if($elseWhere != "" ) {
            if ($whereStr != "") {
                $whereStr .= " AND ". $elseWhere;
            }else{
                $whereStr = $elseWhere;
            }
        }
        
        $command = Yii::app()->db->createCommand()
            ->selectDistinct(
                    'item.Item_ID,
                    item.Name,
                    category.Name Category,
                    Width,
                    Length,
                    Diameter,
                    Description,
                    Price')
            ->from('item')
            ->join('category', 'category.Category_ID = item.Category_ID')
            ->join('item_color', 'item.Item_ID = item_color.Item_ID')
            ->join('item_material', 'item.Item_ID = item_material.Item_ID')
            ->where($whereStr)
            ->order("item.Name");
        $itemsDB = $command->queryAll();

        $items = array();
        foreach($itemsDB as $itemDB){
            $item = new ItemData();
            $item->id =             $itemDB["Item_ID"];
            $item->name =           $itemDB["Name"];
            $item->category =       $itemDB["Category"];
            $item->width =          $itemDB["Width"];
            $item->length =         $itemDB["Length"];
            $item->diameter =       $itemDB["Diameter"];
            $item->description =    $itemDB["Description"];
            $item->price =          $itemDB["Price"];
            $items[] = $item;
        }
        return $items;
    }

    private static function getPartWhere($from, $to, $itemWhere, $needAND = false)
    {
        $from_str = $to_str = "";
        $issetFrom = isset($from) && $from != "";
        $issetTo = isset($to) && $to != "";
        if(!$issetFrom and !$issetTo) {
            return "";
        }
        if($issetFrom) {
            $from_str = " $from <= $itemWhere ";
        }
        if($issetTo && $issetFrom) {
            $to_str = "AND $itemWhere <= $to ";
        }elseif ($issetTo) {
            $to_str = "$itemWhere <= $to ";
        }
        $res = "";
        if($needAND) {
            $res .= "AND ";
        }
        $res .= $from_str . $to_str;
        return $res;
    }
    
    public static function getItemColors($id)
    {
        $sql = "SELECT Color_ID, Name "
             . "FROM color "
             . "JOIN item_color USING(Color_ID) "
             . "WHERE item_color.Item_ID = $id";
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll();
    }

    public static function getItemById($id)
    {
        $sql = "SELECT * FROM item WHERE item.Item_ID=$id";
        $command = Yii::app()->db->createCommand($sql);
        $temp_data = $command->queryRow();
        
        $itemData = new ItemData();
        $itemData->id = $id;
        $itemData->name = $temp_data["Name"];
        $itemData->length = $temp_data["Length"];
        $itemData->width = $temp_data["Width"];
        $itemData->price = $temp_data["Price"];
        $itemData->description = $temp_data["Description"];
        $itemData->diameter = $temp_data["Diameter"];
        
        $sql = "SELECT category.Name "
             . "FROM category "
             . "JOIN item USING(Category_ID) "
             . "WHERE item.Item_ID = $id";
        $command = Yii::app()->db->createCommand($sql);
        $arr = $command->queryRow();
        $itemData->category = $arr["Name"];
        
        $sql = "SELECT Name "
             . "FROM color "
             . "JOIN item_color USING(Color_ID) "
             . "WHERE item_color.Item_ID = $id";
        $command = Yii::app()->db->createCommand($sql);
        $itemData->colors = $command->queryAll();
        
        $sql = "SELECT Name "
             . "FROM material "
             . "JOIN item_material USING(Material_ID) "
             . "WHERE item_material.Item_ID = $id";
        $command = Yii::app()->db->createCommand($sql);
        $itemData->materials = $command->queryAll();
        return $itemData;
    }

    public static function getCategories()
    {
        return self::getColumn('Category_ID', 'Name', 'category');
    }

    public static function getColors()
    {
        return self::getColumn('Color_ID','Name', 'color');
    }

    public static function getMaterials()
    {
        return self::getColumn('Material_ID','Name', 'material');
    }

    public static function addItem($addedItem)
    {
        $item = new Item();
        $item->Category_ID = $addedItem->category;
        $item->Name = $addedItem->name;
        $item->Width = $addedItem->width;
        $item->Length = $addedItem->length;
        $item->Diameter = $addedItem->diameter;
        $item->Price = $addedItem->price;
        $item->Description = $addedItem->description;
        $item->save();

        $insertedItemID = $item->getPrimaryKey();


        foreach($addedItem->colors as $color){
            try{
                $item_color = new ItemColor();
                $item_color->Item_ID = $insertedItemID;
                $item_color->Color_ID = $color;
                $item_color->insert();
            }catch (CException $ex){
                continue;
            }
        }

        foreach($addedItem->materials as $material){
            try{
                $item_material = new ItemMaterial();
                $item_material->Item_ID = $insertedItemID;
                $item_material->Material_ID = $material;
                $item_material->insert();
            }catch (CException $ex){
                continue;
            }
        }
        return (int)$insertedItemID;
    }

    private static function getColumn($columnID, $columnName, $table)
    {
        $con = Yii::app()->db;
        $sql = 'SELECT * FROM '.$table.';';
        $command = $con->createCommand($sql);
        $array = $command->queryAll();
        $res = array();
        foreach($array as $el){
            $res[$el[$columnID]] = $el[$columnName];
        }
        return $res;
    }


}

class Item extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

class ItemColor extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'item_color';
    }
}

class ItemMaterial extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'item_material';
    }
}