<?php

require_once(ABSPATH . '/wp-content/plugins/wp-salesforce/wp-salesforce.php');
require_once(ABSPATH . '/wp-content/plugins/wp-committees/Template.php');

function get_committees_array()
{
    $tpl = new Template("test-list.tpl.php");
    $tpl->addPath(ABSPATH . '/wp-content/plugins/wp-committees/templates/');

    // Test
    //var_dump($tpl);
    //exit;

    $committeeRecords = get_committee_records();
    //var_dump($committeeRecords);
    //exit;

    $formattedCommitteesArray = includeMemberInfo($committeeRecords);

    return $formattedCommitteesArray;

    //Testing...
    //var_dump($formattedCommitteesArray);
    //exit;
    //

    //return $tpl->render(array(
    //"committees" => $formattedCommitteesArray,
    //"isAdmin" => false,
    //"isMember" => true // is_authenticated()
    //));
}


// This function parses an array with 'raw' data containing committee and member information
// It then takes necessary attributes and puts them into a new formatted 'human-friendly' array
function includeMemberInfo($committeeRecords)
{
    $committees = array(); // Initializing an empty array that will hold all the necessary data

    foreach ($committeeRecords as $record) {
        $committee = []; // Initializing an empty array for a single committee object (local to the loop)
        // creating and assigning an array that contains all members (raw data) of the committee that is being added
        $members = $record['Relationships__r']['records'];

        $committee["Name"] = $record["Name"]; // getting a committee name
        foreach ($members as $rec) {
            $member = array( // Settting each member's attributes for the committee
                "Id" => $rec["Contact__r"]["Id"],
                "Title" => $rec["Contact__r"]["Title"],
                "Role" => $rec["Role__c"],
                "Name" => $rec["Contact__r"]["Name"],
                "Phone" => $rec["Contact__r"]["Phone"],
                "Email" => $rec["Contact__r"]["Email"]
            );
            $committee["members"][] = $member; // adding a member entry to the 'members' array
            //var_dump($member);
            //exit;
        }
        $committees[] = $committee; // filling 'committees' array with committee/members data after every itireation
    }
    //var_dump($committees); // TESTING
    //exit;
    return $committees;
}