<?php
namespace Wegmeister\TagManager\Domain\Repository;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Persistence\QueryInterface;
use Wegmeister\TagManager\Domain\Model\Group;

/**
 * @Flow\Scope("singleton")
 */
class TagRepository extends Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'taggroup.name' => QueryInterface::ORDER_ASCENDING,
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
        //$constraints[] = $query->in('taggroup', $groups);

        foreach ($groups as $group) {
            if ($group instanceof Group) {
                $group = $group->getName();
            }
            $constraints[] = $query->like('taggroup.name', $group, $caseSensitive);
        }
        $query->matching($query->logicalOr($constraints));

        return $query->execute($cacheResult);
    }
}
