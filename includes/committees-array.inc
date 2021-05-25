<?php



require_once(ABSPATH . '/wp-content/plugins/wp-salesforce/records.php');

function get_committees_array()
{
    //$tpl = new Template("test-list.tpl.php");
    //$tpl->addPath(ABSPATH . '/wp-content/plugins/wp-committees/templates/');

    // Calling get_records() function with "committees" param to get committee/member records
    $committeeRecords = get_committee_records(); // <- add "committees" string param to query within wp-salesfoce
    //var_dump($committeeRecords);
    //exit;

    $formattedCommitteesArray = includeMemberInfo($committeeRecords);

    // Sorting in alphabetic order
    sort($formattedCommitteesArray);

    //Testing...
    //var_dump($formattedCommitteesArray);
    //exit;
    //

    // Calls function 'sort_members_by_role' to get a sorted array
    $sortedByRole = sort_members_by_role($formattedCommitteesArray);

    return $sortedByRole;

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
                "City" => $rec["Contact__r"]["Ocdla_Home_City__c"],
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

// This function recreates an array based on member roles and their priorities
function sort_members_by_role($committees)
{
    // Sorted array based on roles
    $sortedCommitteesArray = [];

    foreach ($committees as $rec) {

        // An array that will hold related records based on role priorities
        $newArray = [
            "Name" => $rec["Name"],
            "members" => []
        ];

        // Define the order of roles
        // Members not assigned a role will not appear on the list
        $roles = [
            "Chair",
            "Co-chair",
            "Board Liaison",
            "Legislative Director",
            "Executive Director",
            "President",
            "Vice President",
            "Secretary",
            "Willamette University",
            "University of Oregon",
            "Ex Officio Member",
            "Consulting Member",
            "Advisory Member",
            "Voting Member",
            "Member"
        ];

        // The list of members in the order it will be displayed on the page
        $list = [];

        // Will hold members grouped by their respective roles
        $grouped = [];

        // Grouping by roles
        foreach ($rec["members"] as $member) {
            $role = $member["Role"];
            $grouped[$role][] = $member;
        }

        // Filling $list array based on the role order
        foreach ($roles as $role) {
            if ($grouped[$role] != null) {
                $list[$role] = $grouped[$role];
            }
        }

        // Calling a function that returns a flattened version of members based on their roles
        $newArray["members"] = flatten_array($list, $roles);

        $sortedCommitteesArray[] = $newArray;
    }

    //var_dump($sortedCommitteesArray);
    //exit;

    return $sortedCommitteesArray;
}

// Flattening the array containing roles
function flatten_array($list, $roles)
{
    $flatArray = [];
    // comparing roles in the list array against our "master" role values
    for ($i = 0; $i < count($roles); $i++) {
        if ($list[$roles[$i]] != null) {
            foreach ($list[$roles[$i]] as $role) {
                array_push($flatArray, $role);
            }
        }
    }
    return $flatArray;
}