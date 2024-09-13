<?php

// src/Repository/WorkDetailsRepository.php

namespace App\Repository;

use App\Entity\WorkDetails;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WorkDetailsRepository
{

    public function createWorkDetails(array $userData): ?WorkDetails
    {
        // Set properties for WorkDetails entity
        $workDetails = new WorkDetails();
        $workDetails->setProfession($userData['profession'] ?? '');
        $workDetails->setJobTitle($userData['jobTitle'] ?? '');
        $workDetails->setPublicSector($userData['publicSector'] ?? '');
        $workDetails->setActivitySector($userData['activitySector'] ?? '');
        $workDetails->setEntityName($userData['entityName'] ?? '');
        $workDetails->setEducationLevel($userData['educationLevel'] ?? '');
        $workDetails->setWorkAddress($userData['workAddress'] ?? '');
        $workDetails->setWorkTelephoneNumber($userData['workTelephoneNumber'] ?? '');
        $workDetails->setPlaceOfWorkListed($userData['placeOfWorkListed'] ?? false);
        $workDetails->setGrade($userData['grade'] ?? '');


        return $workDetails;
    }
}
