# fullcalendar-reservation

Online demo is available at [fullcalendar-reservation](http://peihuishao.com/fullcalendar-reservation)

# DB Setting
A mysql database is currently used to provide the data of events. The db config setting is stored in echo_api/inc/dbcfg.inc.php. 

You will need at least a table "ed-event" for storing events, with the following fields:

1. eid: 
    
    Event id. This is the primary key and is auto-increment.
2. uid:

    User id.  You can establish user managment with a second table "ed-user" which identifies users with a unique user id. 
3. title:

    Event title.
4. start:

    Start time of event. datetime format. 
5. end:

    End time of event. datetime format. 
6. time:

    Datetime or timestamp format for storing event updating time. 




