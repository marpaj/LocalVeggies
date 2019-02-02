<?php

namespace App\Service;

class DistributionService
{
    public function getNextsDistributions()
    {
        $nextDistributionDateStr = strtotime("next Saturday");
        $nextDistributionDate = date("d M Y", $nextDistributionDateStr);

        $secondNextDistributionDateStr = strtotime("+1 weeks", $nextDistributionDateStr);
        $secondNextDistributionDate = date("d M Y", $secondNextDistributionDateStr);

        return [$nextDistributionDate, $secondNextDistributionDate];
    }
}