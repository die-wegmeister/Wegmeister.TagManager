<?php
namespace Wegmeister\TagManager\Domain\Model;

/*
 * This file is part of the Wegmeister.TagManager package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Tag
{

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="StringLength", options={ "maximum"=255 })
     * @Flow\Identity
     */
    protected $name;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="\Wegmeister\TagManager\Domain\Model\Group")
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Identity
     */
    protected $groupname;


    /**
     * Get Tag identifier.
     * @return string
     */
    public function getIdentifier()
    {
        return $this->Persistence_Object_Identifier;
    }

    /**
     * Get the name of this tag.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of this tag.
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the group of this tag.
     * @return Group
     */
    public function getGroupname()
    {
        return $this->groupname;
    }

    /**
     * Set the group of this tag.
     * @param Group $groupname
     * @return void
     */
    public function setGroupname(Group $groupname)
    {
        $this->groupname = $groupname;
    }

}
