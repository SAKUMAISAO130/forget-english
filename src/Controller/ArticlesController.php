<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\TranslateComponent;
use App\Controller\Component\CustomUtilityComponent;
use App\Model\Entity\Article;


/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        /**
         * SQL発行用エンティティクラスをインスタンス化
         */
        $entity_class = new Article();
        /**
         * SQL実行
         */
        $result_count = $entity_class->countDuplicate();
        $result_count_week = $entity_class->countWeek();

        /**
         * ページネーション設定
         */
        $this->paginate = [
            'contain' => ['Users'],
            'limit' => 10,
            'order' => [
                'Articles.created' => 'desc',
            ],
        ];

        /**
         * 条件別データ取得
         */
        if ($_GET) {
            if ($_GET['type'] === 'search' && $_GET['keyword'] != '' ) {
                /**
                 * 検索時データ取得
                 */
                $keyword = $_GET['keyword'];
                $result_data = $this->Articles->find()
                ->where(['OR' => [
                    ['title LIKE' => '%' . $keyword .'%'],
                    ['sentence LIKE' => '%' . $keyword .'%'],
                ]
                ]);

            }else{
                /**
                 * 通常一覧データ取得
                 */
                $result_data = $this->Articles->find()
                ->where(['deleted IS NULL']);
            }
        }else{
            /**
             * 通常一覧データ取得
             */
            $result_data = $this->Articles->find()
            ->where(['deleted IS NULL']);
        }

        /**
         * データをページャーにセット
         */
        $articles = $this->paginate($result_data);

        /**
         * view変数にバインド
         */
        $articles_add = $this->Articles->newEntity();
        $this->set(compact('articles', 'result_count', 'keyword','articles_add', 'result_count_week'));


    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->redirect(['controller' => 'Articles', 'action' => 'index']);
        $article = $this->Articles->get($id, [
            'contain' => ['Users', 'Tags']
        ]);
        $this->set('article', $article);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {

            $get_data = $this->request->getData();

            /*
             * 空白削除
             */
            $utilty_obj = new CustomUtilityComponent(new ComponentRegistry());
            foreach ($get_data as $k => $v) {
                if(!is_array($v)){
                    $get_data[$k] = $utilty_obj->space_trim($v);
                }
            }

            $article = $this->Articles->patchEntity($article, $get_data);
            $trans_obj = new TranslateComponent(new ComponentRegistry());
            $article->translate = $trans_obj->custom_trans_lang($article->title);
            $article->slug = Security::hash(uniqid("", true), Configure::read("encrypt_type_soft"), Configure::read("encrypt_salt"));
            $article->user_id = 1;


            if ($this->Articles->save($article)) {
                $this->Flash->success(__('登録が完了しました.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('登録エラーです。'));
        }else{
            $this->redirect(['controller' => 'Articles', 'action' => 'index']);
        }
        $users = $this->Articles->Users->find('list', ['limit' => 200]);
        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
        $this->set(compact('article', 'users', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $sentence_old = $article->sentence;
            $sentence_created_old = $article->sentence_created;

            $get_data = $this->request->getData();
            /*
             * 空白削除
             */
            $utilty_obj = new CustomUtilityComponent(new ComponentRegistry());
            foreach ($get_data as $k => $v) {
                if(!is_array($v)){
                    $get_data[$k] = $utilty_obj->space_trim($v);
                }
            }

            $article = $this->Articles->patchEntity($article, $this->request->getData());

            /*
             * 空白削除（再度）
             */
            $article->sentence = $utilty_obj->space_trim($article->sentence);
            /**
             * 初回登録かどうかの判定
             * カラムがともにNULLであれば初回登録とみなす
             * 空文字更新はNULLが入るようにしているので「''」の''がカラムに入ることはない
             */
            if($sentence_old === NULL && $sentence_created_old === NULL){
                if ($article->sentence !== '') {
                    /**
                     * 自作文章がある状態(空文字以外)になった場合は、登録用データに文章作成日時を追加する
                     * それ以外の場合はなにもしない
                     */
                    $article->sentence_created = date("Y-m-d H:i:s");;
                }

//                 echo '<pre>';
//                 var_dump('初回登録です');
//                 exit();
            }

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('更新しました'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('更新エラーです。'));
        }
        $users = $this->Articles->Users->find('list', ['limit' => 200]);
        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
        $this->set(compact('article', 'users', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('削除しました。'));
        } else {
            $this->Flash->error(__('削除できませんでした。'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
