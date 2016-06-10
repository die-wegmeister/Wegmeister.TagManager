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
class GroupRepository extends Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'name' => QueryInterface::ORDER_ASCENDING
    ];

}
