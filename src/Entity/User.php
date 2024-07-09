<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?merchant $merchant = null;

    /**
     * @var Collection<int, order>
     */
    #[ORM\OneToMany(targetEntity: order::class, mappedBy: 'user')]
    private Collection $order_user;

    public function __construct()
    {
        $this->order_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMerchant(): ?merchant
    {
        return $this->merchant;
    }

    public function setMerchant(?merchant $merchant): static
    {
        $this->merchant = $merchant;

        return $this;
    }

    /**
     * @return Collection<int, order>
     */
    public function getOrderUser(): Collection
    {
        return $this->order_user;
    }

    public function addOrderUser(order $orderUser): static
    {
        if (!$this->order_user->contains($orderUser)) {
            $this->order_user->add($orderUser);
            $orderUser->setUser($this);
        }

        return $this;
    }

    public function removeOrderUser(order $orderUser): static
    {
        if ($this->order_user->removeElement($orderUser)) {
            // set the owning side to null (unless already changed)
            if ($orderUser->getUser() === $this) {
                $orderUser->setUser(null);
            }
        }

        return $this;
    }
}
