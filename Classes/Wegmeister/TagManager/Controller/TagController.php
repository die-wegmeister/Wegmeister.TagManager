<?php
namespace Wegmeister\TagManager\Controller;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Wegmeister\TagManager\Domain\Model\Tag;

class TagController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Wegmeister\TagManager\Domain\Repository\TagRepository
     */
    protected $tagRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('tags', $this->tagRepository->findAll());
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function showAction(Tag $tag)
    {
        $this->view->assign('tag', $tag);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param Tag $newTag
     * @return void
     */
    public function createAction(Tag $newTag)
    {
        $newTag->setName(trim($newTag->getName()));
        $this->tagRepository->add($newTag);
        $this->addFlashMessage('Neuen tag erstellt.');
        $this->redirect('index');
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function editAction(Tag $tag)
    {
        $this->view->assign('tag', $tag);
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function updateAction(Tag $tag)
    {
        $tag->setName(trim($tag->getName()));
        $this->tagRepository->update($tag);
        $this->addFlashMessage('Tag aktualisiert.');
        $this->redirect('index');
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function deleteAction(Tag $tag)
    {
        $this->tagRepository->remove($tag);
        $this->addFlashMessage('Tag entfernt.');
        $this->redirect('index');
    }

}
