<?php
namespace Wegmeister\TagManager\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;

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
            foreach ($tagsFromDb as $tag) {
                $tags[] = [
                    'label' => $tag->getName(),
                    'value' => $tag->getName(),
                    'group' => $tag->getGroupname()->getName()
                ];
            }
        } else {
            $tagsFromDb = $this->tagRepository->findAll();
            foreach ($tagsFromDb as $tag) {
                $tags[] = [
                    'label' => $tag->getName(),
                    'value' => $tag->getName(),
                    'group' => $tag->getGroupname()->getName()
                ];
            }
        }

        return $tags;
    }
}
