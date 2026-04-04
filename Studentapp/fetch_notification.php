<?php
session_start();
include '../database.php';

$user_id = $_SESSION['user_id'] ?? 0;

$data = [];

$q = mysqli_query($con, "

SELECT CONCAT('club_',id) nid, clubname title,'New Club Added' message FROM clubs
UNION ALL
SELECT CONCAT('event_',id),name,'New Event Added' FROM events
UNION ALL
SELECT CONCAT('cjr_',cjr.id),c.clubname,'Approved 🎉'
FROM club_join_requests cjr JOIN clubs c ON cjr.club_id=c.id
WHERE cjr.user_id='$user_id' AND cjr.status='approved'
UNION ALL
SELECT CONCAT('ejr_',ejr.id),e.name,'Approved 🎉'
FROM event_join_requests ejr JOIN events e ON ejr.event_id=e.id
WHERE ejr.user_id='$user_id' AND ejr.status='approved'
ORDER BY nid DESC LIMIT 5
");

while($row=mysqli_fetch_assoc($q)){
    if(!in_array($row['nid'], $_SESSION['hidden_notifications'] ?? [])){
        $data[] = $row;
    }
}

echo json_encode($data);