<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BookmarksTags Controller
 *
 * @property \App\Model\Table\BookmarksTagsTable $BookmarksTags
 *
 * @method \App\Model\Entity\BookmarksTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BookmarksTagsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Bookmarks', 'Tags']
        ];
        $bookmarksTags = $this->paginate($this->BookmarksTags);

        $this->set(compact('bookmarksTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Bookmarks Tag id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookmarksTag = $this->BookmarksTags->get($id, [
            'contain' => ['Bookmarks', 'Tags']
        ]);

        $this->set('bookmarksTag', $bookmarksTag);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bookmarksTag = $this->BookmarksTags->newEntity();
        if ($this->request->is('post')) {
            $bookmarksTag = $this->BookmarksTags->patchEntity($bookmarksTag, $this->request->getData());
            if ($this->BookmarksTags->save($bookmarksTag)) {
                $this->Flash->success(__('The bookmarks tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookmarks tag could not be saved. Please, try again.'));
        }
        $bookmarks = $this->BookmarksTags->Bookmarks->find('list', ['limit' => 200]);
        $tags = $this->BookmarksTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('bookmarksTag', 'bookmarks', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookmarks Tag id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookmarksTag = $this->BookmarksTags->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookmarksTag = $this->BookmarksTags->patchEntity($bookmarksTag, $this->request->getData());
            if ($this->BookmarksTags->save($bookmarksTag)) {
                $this->Flash->success(__('The bookmarks tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookmarks tag could not be saved. Please, try again.'));
        }
        $bookmarks = $this->BookmarksTags->Bookmarks->find('list', ['limit' => 200]);
        $tags = $this->BookmarksTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('bookmarksTag', 'bookmarks', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bookmarks Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookmarksTag = $this->BookmarksTags->get($id);
        if ($this->BookmarksTags->delete($bookmarksTag)) {
            $this->Flash->success(__('The bookmarks tag has been deleted.'));
        } else {
            $this->Flash->error(__('The bookmarks tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
