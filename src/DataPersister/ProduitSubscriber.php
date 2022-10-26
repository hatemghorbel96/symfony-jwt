<?php

namespace App\DataPersister;

use DateTime;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProduitSubscriber implements DataPersisterInterface
{
    private $entityManager;
    private $slugger;

    public function __construct(EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage,SluggerInterface  $slugger)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->slugger  = $slugger ;
    }

    public function supports($data):bool
    {
        return $data instanceof Produit;
    }

    /**
     * @param Produit $data
     */
    public function persist($data)
    {
            $time = new DateTime();
            
            $data->setCreatedAt($time);
          
        

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}