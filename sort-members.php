<?php

require_once(ABSPATH . '/wp-content/plugins/wp-committees/committees-array.php');

$committees = get_committees_array();

//var_dump($committees);
//exit;

$sortedCommittees = sort_members_by_role($committees);

function sort_members_by_role($committees)
{
    // Making it work for one committee
    $newCommittee = $committees[0];
    // assign roles priorities
    $chair = [];
    $coChair = [];
    $boardLiason = [];
    $president = [];
    $legPresident = [];
    $regMembers = [];

    $newArray = [
        "Name" => $committees[0]["Name"],
        "members" => []
    ];

    // filling arrays based on roles
    foreach ($newCommittee["members"] as $member) {

        switch ($member["Role"]) {
            case "Member":
                array_push($regMembers, $member);
                break;
            case "Co-Chair":
                array_push($coChair, $member);
                break;
            case "Chair":
                $chair = $member;
                break;
            case "Board Liaison":
                $boardLiason = $member;
                break;
            case "Legislative Director":
                $legPresident = $member;
                break;
        }
    }

    //var_dump($regMembers);
    //exit;

    //array_push($newArray["members"][], $chair, $boardLiason);
    //array_push($newArray["members"][], );
    $newArray["members"][] = $chair;
    $newArray["members"][] = $boardLiason;

    foreach ($regMembers as $rec) {
        $newArray["members"][] = $rec;
    }


    //var_dump($newArray);
    //exit;

    // return sorted array

    return $newArray;
}