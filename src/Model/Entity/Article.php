<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
//DB使用のため
use Cake\Datasource\ConnectionManager;


/**
 * Article Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property bool $published
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tag[] $tags
 */
class Article extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
//         'user_id' => true,
//         'title' => true,
//         'slug' => true,
//         'body' => true,
//         'published' => true,
//         'created' => true,
//         'modified' => true,
//         'user' => true,
//         'tags' => true
        '*' => true,
    ];


    /**
     * 重複している登録単語のカウント
     */
    public function countDuplicate($user_id = 1)
    {
        /**
         * DBオブジェクト作成
         */
        $connection = ConnectionManager::get('default');
        /**
         * SQL文作成
         */
        $sql_str  = 'SELECT ';
        $sql_str .= '    COUNT(title) duplicate_count,title ';
        $sql_str .= 'FROM ';
        $sql_str .= '    articles ';
        $sql_str .= 'WHERE ';
        $sql_str .= '    user_id = :user_id ';
        $sql_str .= '    AND published = 1 ';
        $sql_str .= '    AND deleted IS NULL ';
        $sql_str .= 'GROUP BY ';
        $sql_str .= '    title ';
        $sql_str .= 'HAVING ';
        $sql_str .= '    COUNT(title) > 1 ';
        $sql_str .= 'ORDER BY ';
        $sql_str .= '    duplicate_count DESC ';
        $sql_str .= 'LIMIT 10 ';
        /**
         * SQLと値を結合
         */
        $query = $connection->execute($sql_str,['user_id' => $user_id]);
        /**
         * SQL実行
         */
        return $query->fetchAll('assoc');
    }

    /**
     * 重複している登録単語のカウント
     */
    public function countWeek($user_id = 1)
    {
        /**
         * DBオブジェクト作成
         */
        $connection = ConnectionManager::get('default');

        /**
         * SQL文作成
         */
        $sql_str  = 'SELECT ';
        $sql_str .= '    date_format(created, "%Y-%m-%d") as c_col, ';
        $sql_str .= '    count(*) as count ';
        $sql_str .= 'FROM ';
        $sql_str .= '    articles ';
        $sql_str .= 'WHERE ';
        $sql_str .= '    user_id = :user_id ';
        $sql_str .= '    AND created BETWEEN (CURDATE() - INTERVAL 7 DAY) AND (CURDATE() + INTERVAL 1 DAY)';
        $sql_str .= '    AND published = 1 ';
        $sql_str .= '    AND deleted IS NULL ';
        $sql_str .= 'GROUP BY ';
        $sql_str .= '    c_col ';
        $sql_str .= 'ORDER BY ';
        $sql_str .= '    c_col ASC ';
        $sql_str .= 'LIMIT 7 ';
        /**
         * SQLと値を結合
         */
        $query = $connection->execute($sql_str,['user_id' => $user_id]);
        /**
         * SQL実行
         */
        return $query->fetchAll('assoc');
    }

}
