<?php

namespace app\models;


/**
 * This is the model class for table "zakaz_tag".
 *
 * @property integer $id
 * @property integer $zakaz_id
 * @property integer $tag_id
 *
 * @property mixed $financy
 */
class ZakazTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zakaz_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zakaz_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zakaz_id' => 'Zakaz ID',
            'tag_id' => 'Tag ID',
        ];
    }

    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @param $post
     * @param $arr
     * @param $id_zakaz
     */
    public function getZakazForm($post, $arr, $id_zakaz)
    {
        foreach ($post as $one){
            if (!in_array($one, $arr)){
                $this->zakaz_id = $id_zakaz;
                $this->tag_id = $one;
                $this->save();
            }
            if (isset($arr[$one])){
                unset($arr[$one]);
            }
        }
        ZakazTag::deleteAll(['tag_id' => $arr]);
    }

    /**
     * @param $id
     */
    public  function getFinancy($id)
    {
        $this->zakaz_id = $id;
        $this->tag_id = Tag::TAG_PAID;
        $this->save();
    }
}
