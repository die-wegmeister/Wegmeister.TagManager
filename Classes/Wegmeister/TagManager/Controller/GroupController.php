<?php
namespace Wegmeister\TagManager\Controller;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Wegmeister\TagManager\Domain\Model\Group;

class GroupController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Wegmeister\TagManager\Domain\Repository\GroupRepository
     */
    protected $groupRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('tags', $this->groupRepository->findAll());
    }

    /**
     * @param Group $group
     * @return void
     */
    public function showAction(Group $group)
    {
        $this->view->assign('group', $group);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param Group $newGroup
     * @return void
     */
    public function createAction(Group $newGroup)
    {
        $newGroup->setName(trim($newGroup->getName()));
        $this->groupRepository->add($newGroup);
        $this->addFlashMessage('Neue Gruppe erstellt.');
        $this->redirect('index');
    }

    /**
     * @param Group $group
     * @return void
     */
    public function editAction(Group $group)
    {
        $this->view->assign('group', $group);
    }

    /**
     * @param Group $group
     * @return void
     */
    public function updateAction(Group $group)
    {
        $group->setName(trim($group->getName()));
        $this->groupRepository->update($group);
        $this->addFlashMessage('Gruppe aktualisiert.');
        $this->redirect('index');
    }

    /**
     * @param Group $group
     * @return void
     */
    public function deleteAction(Group $group)
    {
        $this->groupRepository->remove($group);
        $this->addFlashMessage('Gruppe entfernt.');
        $this->redirect('index');
    }

}
