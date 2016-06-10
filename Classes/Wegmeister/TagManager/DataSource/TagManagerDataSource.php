<?php
namespace Wegmeister\TagManager\DataSource;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Neos\Service\DataSource\AbstractDataSource;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

class TagManagerDataSource extends AbstractDataSource
{
    /**
     * @Flow\Inject
     * @var \Wegmeister\TagManager\Domain\Repository\TagRepository
     */
    protected $tagRepository;

    /**
     * @var string
     */
    static protected $identifier = 'wegmeister-tagmanager-sources';

    /**
     * Get data
     *
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(NodeInterface $node = NULL, array $arguments) {
        $tags = [];
        if (isset($arguments['groups'])) {
            $tagsFromDb = $this->tagRepository->findByGroups($arguments['groups']);
            foreach ($tagsFromDb as $tag) {
                $tags[] = [
                    'label' => $tag->getName(),
                    'value' => $tag->getName()
                ];
            }
        } else {
            $tagsFromDb = $this->tagRepository->findAll();
            foreach ($tagsFromDb as $tag) {
                $tags[] = [
                    'label' => $tag->getName(),
                    'value' => $tag->getName(),
                    'group' => $tag->getGroup()->getName()
                ];
            }
        }

        return $tags;
    }
}
