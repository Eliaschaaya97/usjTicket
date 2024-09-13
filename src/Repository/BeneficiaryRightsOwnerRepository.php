<?php

// src/Repository/BeneficiaryRightsOwnerRepository.php

namespace App\Repository;

use App\Entity\BeneficiaryRightsOwner;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BeneficiaryRightsOwnerRepository
{
    public function createBeneficiary(array $userData): ?BeneficiaryRightsOwner
    {
        $expirationDateString = $beneficiaryData['expirationDate'] ?? '';
        $expirationDate = new \DateTime($expirationDateString);

        $beneficiary = new BeneficiaryRightsOwner();
        $beneficiary->setCustomerSameAsBeneficiary($userData['customerSameAsBeneficiary'] ?? false);
        $beneficiary->setBroNationality($userData['broNationality'] ?? '');
        $beneficiary->setBeneficiaryName($userData['beneficiaryName'] ?? '');
        $beneficiary->setRelationship($userData['relationship'] ?? '');
        $beneficiary->setBroCivilIdNumber($userData['broCivilIdNumber'] ?? '');
        $beneficiary->setExpirationDate($expirationDate);
        $beneficiary->setReasonOfBro($userData['reasonOfBro'] ?? '');
        $beneficiary->setAddress($userData['address'] ?? '');
        $beneficiary->setProfession($userData['profession'] ?? '');
        $beneficiary->setIncomeWealthDetails($userData['incomeWealthDetails'] ?? '');


        return $beneficiary;
    }
}
