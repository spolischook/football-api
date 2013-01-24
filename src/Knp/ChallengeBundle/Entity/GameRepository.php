<?php

namespace Knp\ChallengeBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Knp\ChallengeBundle\Entity\Game;
use Knp\ChallengeBundle\Entity\Team;

/**
 * GameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GameRepository extends EntityRepository
{
    public function existThisGame(Game $game)
    {
        if ($game->getHomeTeam()->getId() && $game->getAwayTeam()->getId()) {
            return $this->findOneBy(array(
                'homeTeam' => $game->getHomeTeam(),
                'awayTeam' => $game->getAwayTeam(),
                'date' => $game->getDate(),
            ));
        }
        return false;
    }

    public function getAllGamesByTeam(Team $team)
    {
        $qb = $this->createQueryBuilder('g');
        $qb->Where('g.homeTeam = :team');
        $qb->orWhere('g.awayTeam = :team');
        $qb->setParameter('team', $team);
        $qb->orderBy('g.date','desc');

        $query = $qb->getQuery();

        return $query->execute();
    }

    public function getAllGames()
    {
        $qb = $this->createQueryBuilder('g');
        $qb->orderBy('g.date','desc');

        $query = $qb->getQuery();

        return $query->execute();
    }
}
