<?php

namespace Application\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Product
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\Valid
     */
    protected $translations;

    public function getId()
    {
        return $this->id;
    }
}
