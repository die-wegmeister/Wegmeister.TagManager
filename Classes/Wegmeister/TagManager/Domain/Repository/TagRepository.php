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
        'group.name' => QueryInterface::ORDER_ASCENDING,
        'name' => QueryInterface::ORDER_ASCENDING
    ];


    /**
     * Find tags that are in one of the given groups.
     *
     * @param array $groups
     * @return mixed
     */
    public function findByGroups(array $groups)
    {
        /**
         * @TODO
         */
        return $this->findAll();
    }

}
