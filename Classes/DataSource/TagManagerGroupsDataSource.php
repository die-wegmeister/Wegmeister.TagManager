<?php
namespace Wegmeister\TagManager\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;

class TagManagerGroupsDataSource extends AbstractDataSource
{
    /**
     * @Flow\Inject
     * @var \Wegmeister\TagManager\Domain\Repository\GroupRepository
     */
    protected $groupRepository;

    /**
     * @var string
     */
    protected static $identifier = 'wegmeister-tagmanager-groups';

    /**
     * Get data
     *
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(NodeInterface $node = null, array $arguments)
    {
        $groups = [];
        $groupsFromDb = $this->groupRepository->findAll();
        foreach ($groupsFromDb as $group) {
            $groups[] = [
                'label' => $group->getName(),
                'value' => $group->getName()
            ];
        }

        return $groups;
    }
}
