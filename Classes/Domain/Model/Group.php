<?php
namespace Wegmeister\TagManager\Domain\Model;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class Group
{

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="StringLength", options={ "maximum"=255 })
     * @Flow\Identity
     */
    protected $name;


    /**
     * Get Group identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->Persistence_Object_Identifier;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
