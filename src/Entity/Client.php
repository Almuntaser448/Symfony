<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 *  *@UniqueEntity(
 * fields={"email"},
 *   message="desoler le mail a ete deja utilise."
 *  )
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * 
     */
    private $nom;

    /**
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "votre mote de pass doit conitent 8 charachteres minimum",)
     */
    private $mdp;

    /**
     *@Assert\EqualTo(propertyPath="mdp",message="le mot de pass n'est pas identitque")
     */
    public $Confirm_mdp;
    public $RolesButton;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getUsername(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->mdp;
    }
    public function getMdp(): ?string
    {
        return $this->mdp;
    }
    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

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
    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
}
