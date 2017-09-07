<?php
namespace CakeDC\Forum\Controller;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\UnauthorizedException;

/**
 * Likes Controller
 *
 * @method \CakeDC\Forum\Model\Entity\Like[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\LikesTable $Likes
 * @mixin \Cake\Controller\Controller
 */
class LikesController extends AppController
{

    use \CakeDC\Forum\Controller\Traits\ForumTrait;

    /**
     * Initialization hook method.
     *
     * Implement this method to avoid having to overwrite
     * the constructor and call parent.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->deny('*');
    }

    /**
     * Add method
     *
     * @param string $categorySlug
     * @param string $threadSlug
     * @param int $postId
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($categorySlug, $threadSlug, $postId)
    {
        $post = $this->_getPost($categorySlug, $threadSlug, $postId);

        if ($this->Likes->find()->where(['user_id' => $this->Auth->user('id'), 'post_id' => $post->id])->first()) {
            throw new BadRequestException();
        }

        $like = $this->Likes->newEntity();
        $like->user_id = $this->Auth->user('id');
        $like->post_id = $post->id;

        if ($this->request->is(['post'])) {
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            if ($this->Likes->save($like)) {
                $this->Flash->success(__('The like has been saved.'));

                return $this->redirect(['controller' => 'Threads', 'action' => 'view', 'category' => $categorySlug, 'thread' => $threadSlug]);

            }
            $this->Flash->error(__('The like could not be saved. Please, try again.'));
        }

        $this->set(compact('like'));
    }
}
