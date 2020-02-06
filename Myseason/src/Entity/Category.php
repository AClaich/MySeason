<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="ce champ doit être renseigné")
     * @ORM\Column(type="string", length=1500)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Food", mappedBy="category")
     */
    private $food;

    public function __construct()
    {
        $this->food = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Food[]
     */
    public function getFood(): Collection
    {
        return $this->food;
    }

    public function addFood(Food $food): self
    {
        if (!$this->food->contains($food)) {
            $this->food[] = $food;
            $food->setCategory($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->food->contains($food)) {
            $this->food->removeElement($food);
            // set the owning side to null (unless already changed)
            if ($food->getCategory() === $this) {
                $food->setCategory(null);
            }
        }

        return $this;
    }
}
