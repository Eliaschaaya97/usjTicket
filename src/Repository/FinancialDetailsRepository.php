<?php
// src/Repository/FinancialDetailsRepository.php

namespace App\Repository;

use App\Entity\FinancialDetails;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FinancialDetailsRepository
{
	public function createFinancialDetails(array $userData, $imageFront, $imageBack, $imageRealEState = null, $imageFrontaccoountStat = null,  $imageotherdoc  = null, $imageEmployerLetter = null): ?FinancialDetails
	{
		$financialDetails = new FinancialDetails();
		$financialDetails->setSourceOfFunds($userData['sourceOfFunds'] ?? '');
		$financialDetails->setCurrency($userData['currency'] ?? '');
		$financialDetails->setMonthlyBasicSalary($userData['monthlyBasicSalary'] ?? 0.0);
		$financialDetails->setMonthlyAllowances($userData['monthlyAllowances'] ?? 0.0);
		$additionalIncomeSources = $userData['additionalIncomeSources'] ?? [];
		if (is_string($additionalIncomeSources)) {
			$additionalIncomeSources = [$additionalIncomeSources];
		}
		$financialDetails->setAdditionalIncomeSourcesArray($additionalIncomeSources);
		$financialDetails->setTotalEstimatedMonthlyIncome((float)($userData['totalEstimatedMonthlyIncome'] ?? 0.0));
		$financialDetails->setIsWealthInherited($userData['isWealthInherited'] ?? false);
		$financialDetails->setExpectedNumberOfTransactions((int)($userData['expectedNumberOfTransactions'] ?? 0));
		$financialDetails->setExpectedValueOfTransactions((float)($userData['expectedValueOfTransactions'] ?? 0.0));
		$financialDetails->setFrequency($userData['frequency'] ?? '');
		$financialDetails->setHasOtherAccounts($userData['hasOtherAccounts'] ?? false);
		$financialDetails->setBankName($userData['bankName'] ?? '');
		$financialDetails->setCountry($userData['country'] ?? '');
		$financialDetails->setAccountBalance((float)($userData['accountBalance'] ?? 0.0));
		$financialDetails->setNatureOfRelation($userData['natureOfRelation'] ?? '');
		$financialDetails->setPurposeOfRelation($userData['purposeOfRelation'] ?? '');
		$financialDetails->setOthersSourceOfFound($userData['othersSourceOfFound'] ?? '');
		$financialDetails->setEstimatedWealthAmount($userData['estimatedWealthAmount'] ?? '');
		$financialDetails->setSourcesOfWealth($userData['sourcesOfWealth'] ?? '');
		$financialDetails->setIncomeCategory($userData['incomeCategory'] ?? '');
		$financialDetails->setSecondBankName($userData['bankName2'] ?? '');
		$financialDetails->setSecondCountry($userData['country2'] ?? '');
		$financialDetails->setSecondBankBalance((float)($userData['accountBalance2'] ?? 0.0));
		$financialDetails->setThirdBankName($userData['bankName3'] ?? '');
		$financialDetails->setThirdAccountCountry($userData['country3'] ?? '');
		$financialDetails->setThirdAccountBalance((float)($userData['accountBalance3'] ?? 0.0));
		$financialDetails->setFrontImageID('/' . $imageFront);
		$financialDetails->setSelectIDType($userData['selectIDType'] ?? '');
		$financialDetails->setBackImageID('/' . $imageBack);
		$financialDetails->setRealEstateTitle('/' . $imageRealEState);
		$financialDetails->setAccountStatement('/' . $imageFrontaccoountStat);
		$financialDetails->setOtherDocument('/' . $imageotherdoc);
		$financialDetails->setEmployerLetter('/' . $imageEmployerLetter);



		return $financialDetails;
	}
}
