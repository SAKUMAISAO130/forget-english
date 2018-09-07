<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/*
 * 便利系メソッド軍
 */
class CustomUtilityComponent extends Component {

    /*
     * 前後のスペースを取り除きたい（Cakeは半角しか除去しないため独自に作成）
     * ※参考サイト　http://raining.bear-life.com/php/文字列の先頭、末尾の半角全角スペース削除
     * @params $str
     */
    public function space_trim($str) {
        // 行頭の半角、全角スペースを、空文字に置き換える
        $str = preg_replace('/^[ 　]+/u', '', $str);

        // 末尾の半角、全角スペースを、空文字に置き換える
        $str = preg_replace('/[ 　]+$/u', '', $str);

        return $str;
    }

}