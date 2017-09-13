<?php
namespace Wegmeister\TagManager\Controller;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Wegmeister\TagManager\Domain\Model\Group;
use Wegmeister\TagManager\Domain\Model\Tag;

class TagController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Wegmeister\TagManager\Domain\Repository\GroupRepository
     */
    protected $groupRepository;

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
        $this->view->assign('groups', $this->groupRepository->findAll());
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
     * @Flow\Validate(argumentName="$newGroup", type="UniqueEntity")
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
     * @Flow\Validate(argumentName="$group", type="UniqueEntity")
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
        $tags = $this->tagRepository->findByGroups([$group]);
        foreach ($tags as $tag) {
            $this->tagRepository->remove($tag);
        }
        $this->groupRepository->remove($group);
        $this->addFlashMessage('Gruppe und zugehörige Tags entfernt.');
        $this->redirect('index');
    }


    /**
     * @param Group $group
     * @return void
     */
    public function listTagsAction(Group $group)
    {
        $this->view->assign('tags', $this->tagRepository->findByGroups([$group]));
        $this->view->assign('group', $group);
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function showTagAction(Tag $tag)
    {
        $this->view->assign('tag', $tag);
    }

    /**
     * @param Group $group
     * @return void
     */
    public function newTagAction(Group $group)
    {
        $this->view->assign('group', $group);
    }

    /**
     * @param Tag $newTag
     * @return void
     * @Flow\Validate(argumentName="$newTag", type="UniqueEntity")
     */
    public function createTagAction(Tag $newTag)
    {
        $newTag->setName(trim($newTag->getName()));
        $this->removeInvalidAdditionalValues($newTag);

        $this->tagRepository->add($newTag);
        $this->addFlashMessage('Neuen tag erstellt.');
        $this->redirect('listTags', null, null, ['group' => $newTag->getGroup()]);
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function editTagAction(Tag $tag)
    {
        $this->view->assign('tag', $tag);
    }

    /**
     * @param Tag $tag
     * @return void
     * @Flow\Validate(argumentName="$tag", type="UniqueEntity")
     */
    public function updateTagAction(Tag $tag)
    {
        $tag->setName(trim($tag->getName()));
        $this->removeInvalidAdditionalValues($tag);

        $this->tagRepository->update($tag);
        $this->addFlashMessage('Tag aktualisiert.');
        $this->redirect('listTags', null, null, ['group' => $tag->getGroup()]);
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function deleteTagAction(Tag $tag)
    {
        $this->tagRepository->remove($tag);
        $this->addFlashMessage('Tag entfernt.');
        $this->redirect('listTags', null, null, ['group' => $tag->getGroup()]);
    }

    /**
     * Remove invalid additional values from tag.
     * @param Tag $tag
     * @return void
     */
    protected function removeInvalidAdditionalValues(Tag $tag)
    {
        $additionalValues = $tag->getAdditionalValues();
        foreach ($additionalValues as $key => $value) {
            if ($key === '' || $key === '---' || is_int($key)) {
                unset($additionalValues[$key]);
            }
        }
        $tag->setAdditionalValues($additionalValues);
    }

}
