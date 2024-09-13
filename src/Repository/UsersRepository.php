<?php
// src/Repository/UsersRepository.php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository; // Correct import statement

class UsersRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function createUser(array $userData): ?Users
    {
        $expirationDateNationalIdString = $userData['expirationDateNationalId'] ?? '';
        $expirationDateNationalId = new \DateTime($expirationDateNationalIdString);

        $passportExpirationDateString = $userData['passportExpirationDate'] ?? '';
        $passportExpirationDate = new \DateTime($passportExpirationDateString);

        $user = new Users();
        $user->setFullName($userData['fullName'] ?? '');
        $user->setMobileNumb($userData['mobileNumb'] ?? '');
        $user->setEmail($userData['email'] ?? '');
        $user->setBranchUnit($userData['branchUnit'] ?? '');
        $user->setBranchId((int)($userData['branchId'] ?? 0));
        $user->setMothersName($userData['mothersName'] ?? '');
        $user->setGender($userData['gender'] ?? '');
        $dob = !empty($userData['dob']) ? \DateTime::createFromFormat('Y-m-d', $userData['dob']) : false;
        if ($dob) {
            $user->setDob($dob);
        }
        $user->setPlaceOfBirth($userData['placeOfBirth'] ?? '');
        $user->setCountryOfOrigin($userData['countryOfOrigin'] ?? '');
        $user->setNationality($userData['nationality'] ?? '');
        $user->setNationalId($userData['nationalId'] ?? '');
        $user->setExpirationDateNationalId($expirationDateNationalId);
        $user->setRegisterPlaceNo($userData['registerPlaceAndNo'] ?? '');
        $user->setMaritalStatus($userData['maritalStatus'] ?? '');
        $user->setPassportNumber($userData['passportNumber'] ?? '');
        $user->setPlaceOfIssuePassport($userData['placeOfIssuePassport'] ?? '');
        $user->setExpirationDatePassport($passportExpirationDate);
        $user->setOtherNationalities($userData['otherNationalities'] ?? '');
        $user->setStatusInLebanon($userData['statusInLebanon'] ?? '');
        $user->setOtherCountriesTaxResidence($userData['otherCountriesOfTaxResidence'] ?? '');
        $user->setTaxResidencyIdNumber($userData['taxResidencyIdNumber'] ?? '');
        $user->setSpouseName($userData['spouseName'] ?? '');
        $user->setSpouseProfession($userData['spouseProfession'] ?? '');
        $user->setNoOfChildren((int)($userData['noOfChildren'] ?? 0));

        return $user;
    }
//    public function findAllWithDetails()
//    {
//        return $this->entityManager->createQueryBuilder('u')
//            ->leftJoin('u.addresses', 'a')
//            ->leftJoin('u.workDetails', 'w')
//            ->leftJoin('u.financialDetails', 'f')
//            ->leftJoin('u.politicalPositionDetails', 'p')
//            ->leftJoin('u.beneficiaryRightsOwners', 'b')
//            ->getQuery()
//            ->getResult();
//    }

public function createExistingUser(array $userData): ?Users
{
    
    $user = new Users();
    $user->setFullName($userData['fullName'] ?? '');
    $user->setMobileNumb($userData['mobileNumb'] ?? '');
    $user->setEmail($userData['email'] ?? '');
    $user->setBranchUnit($userData['branchUnit'] ?? '');
    $user->setBranchId((int)($userData['branchId'] ?? 0));

    return $user;
}
}
