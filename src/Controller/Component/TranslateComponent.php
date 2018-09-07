<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/*
 * 翻訳コンポーネントクラス
 */
class TranslateComponent extends Component {

    /*
     * 翻訳関数
     * ※参考サイト　http://blog.knockoutmarch.com/2008/02/22/0438.html
     * @params $trans_text 翻訳するテキスト
     * @params $trans_from 翻訳元テキストの言語
     * @params $trans_to 翻訳先テキストの言語
     */
    public function custom_trans_lang($trans_text, $trans_from = 'en', $trans_to = 'ja'){

        /*
         * 翻訳タイプを整形
         */
        $trans_type = $trans_from . '|' . $trans_to;

        /*
         * url整形
         */
        $get_url = "http://translate.google.com/translate_t?langpair=" . $trans_type . "&ie=UTF8&oe=UTF8&text=" . urlencode($trans_text);

        /*
         * 翻訳実行HTMLを取得
         */
        $html = file_get_contents($get_url);

        /*
         * 取得DOMから属性を削除
         */
        $html = preg_replace('/<span ("[^"]*"|\'[^\']*\'|[^\'">])*>/', '<span>', $html);

        /*
         * パターンマッチ
         */
        $pattern = '/<span>(.*?)<\/span>/u';
        preg_match_all($pattern, $html, $matche);

        /*
         * 32番目のDOM要素が結果なので取得
         */
        return strip_tags($matche[0][32]);

    }

}