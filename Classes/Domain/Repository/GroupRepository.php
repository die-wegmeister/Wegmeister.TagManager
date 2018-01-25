<?php
namespace Wegmeister\TagManager\Domain\Repository;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class GroupRepository extends Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'name' => QueryInterface::ORDER_ASCENDING
    ];


    /**
     * Find groups that are in the given group names.
     *
     * @param array<string> $names
     * @return mixed
     */
    public function findByNames(array $names = [], $caseSensitive = true, $cacheResult = false)
    {
        if ($names === []) {
            return $this->findAll();
        }
        $caseSensitive = (boolean)$caseSensitive;
        $cacheResult = (boolean)$cacheResult;
        $query = $this->createQuery();

        $constraints = [];
        foreach ($names as $name) {
            $constraints[] = $query->equals('name', $name, $caseSensitive);
        }
        $query->matching($query->logicalOr($constraints));

        return $query->execute($cacheResult);
    }
}
