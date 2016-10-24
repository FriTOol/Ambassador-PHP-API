<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 12:41
 */

include 'vendor/autoload.php';
use AmbassadorApi\Ambassador;
$user = 'spiritofdrini';
$key = '621ce3ba498d8f1f9479c6fa44c13ade';
$ambassador = new Ambassador($user, $key, ['http_client' => ['timeout' => 10]]);


$company = $ambassador->getCompany();

var_dump($company->getName());
/** @var \AmbassadorApi\Resource\Campaign $campaign */
foreach ($company->getCampaigns() as $campaign) {
    var_dump($campaign->isFacebookEnabled());
    echo $campaign->getName() . "\n";
}