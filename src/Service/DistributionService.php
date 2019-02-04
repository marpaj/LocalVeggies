<?php

namespace App\Service;

class DistributionService
{
    public function getNextsDistributions()
    {
        $nextDistributionDateTime = strtotime("next Saturday");
        $nextDistributionDateStr = date("l d M Y", $nextDistributionDateTime);

        $secondNextDistributionDatetime = strtotime("+1 weeks", $nextDistributionDateTime);
        $secondNextDistributionDateStr = date("l d M Y", $secondNextDistributionDatetime);

        return [
            $nextDistributionDateStr => $nextDistributionDateTime, 
            $secondNextDistributionDateStr => $secondNextDistributionDatetime
        ];
    }
}