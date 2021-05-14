<style type="text/css">
.table-headers {
    display: none;
}

#intro {
    line-height: 10px;
    font-size: 18px;
}

tr {
    text-align: left;
}

h3 {
    color: #bf9500;
}

@media screen and (min-width: 800px) {
    .table-headers {
        display: table-row;
    }
}
</style>


<?php
// Helper function that determines wether a member entry should be bold based on a Role
function checkRole($member)
{
    $roles = ["Chair", "Board Liaison", "President"];
    if (in_array($member["Role"], $roles) || $member["Name"] == "Bob Thuemmel") {
        echo 'bold';
    }
}
?>

<div>
    <h2 class="ml-5" style="padding-left: 12px;">OCDLA Committees</h2>
</div>

<div id="intro" class="m-5 text-muted" style="padding-left: 12px;">
    <p>Welcome to OCDLA's Committees Page. Below is the list of all the committees and their respective members.</p>
    <p>You may navigate to a member's contact information by clicking on a specific member's link associated </p>
    <p>with the committee of interest.</p>
</div>

<?php if (!isset($committees) || (isset($committees) && count($committees) < 1)) : ?>
<ul class="table-row">
    <li>There are no committees to display.</li>
</ul>

<?php else : ?>

<?php foreach ($committees as $committee) : ?>

<h3 class="ml-5" style="padding-left: 12px;"><?php print $committee["Name"]; ?></h3>
<table class=" table w-auto ml-5 mt-3 mb-5 mr-5">
    <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Phone</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php $members = $committee["members"]; ?>
        <?php foreach ($members as $member) : ?>
        <tr style="font-weight:<?php checkRole($member) ?>;">
            <td>
                <a href="https://members.ocdla.org/directory/member/<?php print $member["Id"]; ?>">
                    <?php print $member["Title"] . " " . $member["Name"]; ?>
                </a>
            </td>
            <td>
                <?php print $member["Role"]; ?>
            </td>
            <td>
                <?php print $member["Phone"]; ?>
            </td>
            <td>
                <?php print $member["Email"]; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>


    <?php endforeach; ?>
    <?php endif; ?>