<?php
namespace Wegmeister\TagManager\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Utility\TypeHandling;
use Wegmeister\TagManager\Domain\Model\Tag;

class TagManagerDataSource extends AbstractDataSource
{
    /**
     * @Flow\Inject
     * @var \Wegmeister\TagManager\Domain\Repository\TagRepository
     */
    protected $tagRepository;

    /**
     * @Flow\Inject
     * @var \Wegmeister\TagManager\Domain\Repository\GroupRepository
     */
    protected $groupRepository;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var string
     */
    static protected $identifier = 'wegmeister-tagmanager-tags';

    /**
     * Get data
     *
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(NodeInterface $node = NULL, array $arguments) {
        $tags = [];
        if (isset($arguments['groups']) && $arguments['groups'] !== [] && $arguments['groups'] !== '') {
            if (!is_array($arguments['groups'])) {
                $arguments['groups'] = [$arguments['groups']];
            }
            $groups = $this->groupRepository->findByNames($arguments['groups'])->toArray();
            $tagsFromDb = $this->tagRepository->findByGroups($groups);
        } else {
            $tagsFromDb = $this->tagRepository->findAll();
        }

        if (isset($arguments['extended']) && ($arguments['extended'] === true || $arguments['extended'] === 'true')) {
            $extended = true;
        } else {
            $extended = false;
        }
        foreach ($tagsFromDb as $tag) {
            $tags[] = [
                'label' => $tag->getName(),
                'value' => $this->getValue($tag),
                'group' => $tag->getGroup()->getName()
            ];
        }

        return $tags;
    }

    /**
     * Create the value to return. Depends on how the data should be returned.
     * If argument "extended" is set to true, this will return an identity,
     * so we can access all attributes of the tag.
     * Otherwise this will return only the name of the tag.
     *
     * @param Tag $tag The tag to get the value for.
     * @param boolean $extended Output extended value or only the name.
     * @return string - Either just the name or a json encoded identity/type string.
     */
    protected function getValue(Tag $tag, bool $extended = false)
    {
        if ($extended) {
            $value = json_encode([
                '__identity' => $this->persistenceManager->getIdentifierByObject($tag),
                '__type' => TypeHandling::getTypeForValue($tag)
            ]);
        } else {
            $value = $tag->getName();
        }
        return $value;
    }
}
