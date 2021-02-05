<?php

namespace App\Repository;

use App\Entity\User;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Récupère les candidats en lien avec une recherche
     * @return User[]
     */

     public function findSearch(SearchData $search): array 
     {
        $query = $this
            ->createQueryBuilder('p')
            ->join('p.job', 'j')
            ->join('p.techno', 't');;

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.firstname LIKE :q')
                ->setParameter('q', "%{$search->q}%");
            }
        
        if (!empty($search->job)) {
            $query = $query
                ->andWhere('j.id IN (:job)')
                ->setParameter('job', $search->job);
        }

        if (!empty($search->techno)) {
            $query = $query
                ->andWhere('t.id IN (:techno)')
                ->setParameter('techno', $search->techno);
        }

        return $query->getQuery()->getResult();
     }

}
