<?php

namespace App\Model\Test;

class ModelTest
{
    /**
    * @var int
    */
    private $userId;

    /**
    * @var string
    */
    private $name = '';

    /**
    * @var string
    */
    private $username = '';

    /**
    * @var string
    */
    private $firstName = '';

    /**
    * @var string
    */
    private $lastName = '';

    /**
     * ModelTest constructor.
     */
     public function __construct()
     {
     }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param int $userId
     * @return ModelTest
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param string $name
     * @return ModelTest
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $username
     * @return ModelTest
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $firstName
     * @return ModelTest
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param string $lastName
     * @return ModelTest
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

}