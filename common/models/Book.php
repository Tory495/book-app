<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $image
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @var ?int[]
     */
    public ?array $author_ids = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['author_ids', 'filter', 'filter' => fn ($value) => $value === '' ? [] : (array)$value],
            ['author_ids', 'required', 'message' => Yii::t('app', 'Select at least 1 author')],
            ['author_ids', 'each', 'rule' => ['integer']],
            [['description', 'image'], 'default', 'value' => null],
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer', 'min' => 1900, 'max' => date('Y')],
            [['description'], 'string'],
            [['title', 'image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            [['isbn'], 'unique'],
            [['isbn'], 'match', 'pattern' => '/^(?:\d{10}|\d{13})$/', 'message' => Yii::t('app', 'ISBN must be 10 or 13 digits')],
            [['image'], 'image', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'year' => Yii::t('app', 'Year'),
            'description' => Yii::t('app', 'Description'),
            'isbn' => Yii::t('app', 'Isbn'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getAuthorIds(): array
    {
        return $this->getAuthors()->select('id')->column();
    }

}
