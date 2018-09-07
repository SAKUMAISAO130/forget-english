<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/*
 * ログインコンポーネントクラス
 */
class CustomAuthComponent extends Component
{
    /*
     * データ名（SESSIO名）
     */
    public $data_name;

    /*
     * ユーザーEメール
     */
    public $email;

    /*
     * パスワード
     */
    public $password;

    /*
     * ログイン実行日時（最終ログイン日時）
     */
    public $last_login_date;

    /*
     * ログイン状態保持時間
     */
    public $password;

    /*
     * ハッシュアルゴリズム
     */
    public $hash_algo;

    /*
     * コンストラクタ
     */
    public function __construct(){
    }

    /*
     * コンストラクタ
     */
    public function set_value($key, $value){
    }

}