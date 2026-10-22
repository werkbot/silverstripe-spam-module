<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
  ->withPaths([
    __DIR__ . '/src',
  ])
  // uncomment to reach your current PHP version
  ->withPhpSets()
  ->withSets([
    SilverstripeSetList::CODE_STYLE,
    SilverstripeLevelSetList::UP_TO_SS_6_1
  ])
  ->withTypeCoverageLevel(0)
  ->withDeadCodeLevel(0)
  ->withCodeQualityLevel(0);

