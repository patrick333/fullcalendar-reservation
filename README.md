# fullcalendar-reservation

Online demo is available at http://peihuishao.com/fullcalendar-reservation

# DB Setting
A mysql database is currently used to provide the data of events. The db config setting is stored in echo_api/inc/dbcfg.inc.php. 

You will need at least a table "ed-event" for storing events:

eid-event id. auto-increment
uid-user id.  You can establish user managment with a second table "ed-user" which identifies users with a unique user id. 
title-event title.
start-start time of event. datetime format. 
end-end time of event. datetime format. 
time-datetime or timestamp format for storing event updating time. 
