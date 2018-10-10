<?php

namespace app\models;

use app\models\query\CommentQuery;
use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $sotrud
 * @property integer $id_zakaz
 * @property integer $id_todoist
 * @property integer $id_helpdesk
 * @property string $date
 * @property string $comment
 * @property integer $category
 *
 * @property Helpdesk $idHelpdesk
 * @property User $idUser
 * @property User $sotrud0
 * @property Zakaz $idZakaz
 * @property Todoist $idTodoist
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'sotrud', 'id_zakaz', 'id_todoist', 'id_helpdesk', 'category'], 'integer'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['id_helpdesk'], 'exist', 'skipOnError' => true, 'targetClass' => Helpdesk::className(), 'targetAttribute' => ['id_helpdesk' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['sotrud'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sotrud' => 'id']],
            [['id_zakaz'], 'exist', 'skipOnError' => true, 'targetClass' => Zakaz::className(), 'targetAttribute' => ['id_zakaz' => 'id_zakaz']],
            [['id_todoist'], 'exist', 'skipOnError' => true, 'targetClass' => Todoist::className(), 'targetAttribute' => ['id_todoist' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'sotrud' => 'Sotrud',
            'id_zakaz' => 'Id Zakaz',
            'id_todoist' => 'Id Todoist',
            'id_helpdesk' => 'Id Helpdesk',
            'date' => 'Date',
            'comment' => 'Comment',
            'category' => 'Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHelpdesk()
    {
        return $this->hasOne(Helpdesk::className(), ['id' => 'id_helpdesk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSotrud0()
    {
        return $this->hasOne(User::className(), ['id' => 'sotrud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdZakaz()
    {
        return $this->hasOne(Zakaz::className(), ['id_zakaz' => 'id_zakaz']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTodoist()
    {
        return $this->hasOne(Todoist::className(), ['id' => 'id_todoist']);
    }

    /**
     * @inheritdoc
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }

}
