<?php

namespace Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Constraints as CustomAssert;

class Ad
{
    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $categoryId;

    /**
     * @var string
     */
    private $privateBusiness;

    /**
     * @var string
     */
    private $person;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $images;

    /**
     * This method is where you define your validation rules.
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('title', [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 5, 'max' => 255])
            ])
            ->addPropertyConstraints('categoryId', [
                new Assert\NotBlank(),
                new Assert\Type('int'),
                new CustomAssert\Ad\Category()
            ])
            ->addPropertyConstraints('privateBusiness', [
                new Assert\NotBlank(),
                new Assert\Choice(['private', 'business'])
            ])
            ->addPropertyConstraints('person', [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 5, 'max' => 100])
            ])
            ->addPropertyConstraints('email', [
                new Assert\Blank([
                    'groups' => ['AuthorizedUser']
                ]),
                new Assert\NotBlank([
                    'groups' => ['UnauthorizedUser']
                ]),
                new Assert\Email([
                    'groups' => ['UnauthorizedUser']
                ])
            ])
            ->addPropertyConstraints('phone', [
                new CustomAssert\Phone()
            ])
            ->addPropertyConstraints('params', [
                new Assert\NotBlank(),
                new CustomAssert\Ad\Parameters()
            ])
            ->addPropertyConstraints('images', [
                new Assert\All(
                    new Assert\Collection([
                        'fields' => [
                            'href' => new Assert\Url()
                        ],
                        'allowMissingFields' => false,
                        'allowExtraFields' => false
                    ])
                )
            ]);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateBusiness()
    {
        return $this->privateBusiness;
    }

    /**
     * @param string $privateBusiness
     */
    public function setPrivateBusiness($privateBusiness)
    {
        $this->privateBusiness = $privateBusiness;
        return $this;
    }

    /**
     * @return string
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param string $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }
}