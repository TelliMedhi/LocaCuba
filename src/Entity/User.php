<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function eraseCredentials(){}

    public function getSalt(){
        return null;
    }

    public function getRoles(){

        return ['ROLE_ADMIN'];
    }
    public function serialize(){
      return serialize([$this->id,
                       $this->username,
                       $this->email,
                       $this->password
                        ]);

    }
    public function unserialize($serialized){

          list ($this->id,
                $this->username,
                $this->email,
                $this->password
              ) = unserialize($serialized, ['allowed_classes' => false]);
    }

}
