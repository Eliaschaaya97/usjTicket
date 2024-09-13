<?php

// src/Repository/PoliticalPositionDetailsRepository.php

namespace App\Repository;

use App\Entity\PoliticalPositionDetails;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PoliticalPositionDetailsRepository
{
    public function createPoliticalPosition(array $userData): ?PoliticalPositionDetails
    {
        $yearOfRetirementString = $userData['yearOfRetirement'] ?? '';
        $yearOfRetirement = $yearOfRetirementString !== '' ? (int)$yearOfRetirementString : null;

// Set properties for PoliticalPositionDetails entity
        $politicalPosition = new PoliticalPositionDetails();
        $politicalPosition->setPoliticalPosition($userData['politicalPosition'] ?? '');
        $politicalPosition->setCurrentPrevious($userData['currentOrPrevious'] ?? '');
        $politicalPosition->setYearOfRetirement($yearOfRetirement);
        $politicalPosition->setPepName($userData['pepName'] ?? '');
        $politicalPosition->setRelationship($userData['relationship'] ?? '');
        $politicalPosition->setPepPosition($userData['pepPosition'] ?? '');



        return $politicalPosition;
    }
}
