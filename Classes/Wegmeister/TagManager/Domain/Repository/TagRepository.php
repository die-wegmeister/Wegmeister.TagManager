<?php
namespace Wegmeister\TagManager\Domain\Repository;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class TagRepository extends Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'groupname.name' => QueryInterface::ORDER_ASCENDING,
        'name' => QueryInterface::ORDER_ASCENDING
    ];


    /**
     * Find tags that are in one of the given groups.
     *
     * @param array<\Wegmeister\TagManager\Domain\Model\Group> $groups
     * @return mixed
     */
    public function findByGroups(array $groups = [], $caseSensitive = true, $cacheResult = false)
    {
        if ($groups === []) {
            return $this->findAll();
        }
        $caseSensitive = (boolean)$caseSensitive;
        $cacheResult = (boolean)$cacheResult;
        $query = $this->createQuery();

        $constraints = [];
        // $constraints[] = $query->in('groupname', $groups);
        foreach ($groups as $group) {
            if ($group instanceof Wegmeister\TagManager\Domain\Model\Group) {
                $group = $group->getName();
            }
            $constraints[] = $query->like('groupname.name', $group, $caseSensitive);
        }
        $query->matching($query->logicalOr($constraints));

        return $query->execute($cacheResult);
    }

}
