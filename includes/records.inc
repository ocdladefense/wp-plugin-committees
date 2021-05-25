<?php

function get_committee_records()
{
    $api = load_api();
    //TEST: List commiittees and related contact info for each member
    //require_once(ABSPATH . '/wp-content/plugins/wp-salesforce/queries/committees-query.php');
    //$committees_query = $committees_query_string;

    // GET this query if var passed in equals "committees", else query for "donors"

    $resp = $api->query('SELECT id, Name, (SELECT Contact__r.Id, Contact__r.Title, Contact__r.Name, Role__c, Contact__r.Ocdla_Home_City__c, Contact__r.Email, Contact__r.Phone FROM Relationships__r) FROM Committee__c');

    if (!$resp->isSuccess()) {

        var_dump($resp);
        exit;
    }

    $records = $resp->getRecords();
    // TESTING:
    //var_dump($records);
    //exit;
    /////////////////////////

    return $records;
}