<?php
    class eventsM {
        private $db;

        public function __construct() {
            $this->db = new Database; 
        }

        public function getLastID() {
            $this->db->query('SELECT eventID from event ORDER BY eventID DESC LIMIT 1');
            $row = $this->db->single();
            return $row;
        }

        //getUserTag
        public function getUserTag() {
            $this->db->query('SELECT tag FROM usertag WHERE userID = :userID');
            $this->db->bind(':userID', $_SESSION['userID']);
            $row = $this->db->resultSet();
            return $row;
        }

        //****************************************************************Retrive Events************************************************************************************************************* */

        //getEvents 
        public function getevents($tags) {
            $this->db->query('SELECT DISTINCT event.eventID as EID, event.eventTitle as title, event.date as date, event.time as time, 
            event.zoomlink as zoomlink, event.description as content, event.userID as userID, eventhandling.moderatorID as modID FROM event JOIN 
            user ON event.userID = user.userID JOIN eventhandling ON event.eventID = eventhandling.eventID AND 
            eventhandling.moderatorID = event.userID join eventtag ON eventtag.eventID = event.eventID WHERE ' . $tags .' ORDER BY event.date ASC;');
            $row = $this->db->resultSet();
            return $row;
        }

        //getEventTags
        public function getEventTags() {
            $this->db->query('SELECT eventID as EID, GROUP_CONCAT(eventtag.tag SEPARATOR ",") as tags FROM eventtag GROUP BY eventID' );
            $row = $this->db->resultSet();
            return $row;
        }

        //get Resource Person
        public function getResourcePerson() {
            $this->db->query('SELECT user.userID as userID, CONCAT(user.firstName, " ", user.lastName) as name, user.email as email, user.pfp as 
            pfp, eventhandling.eventID as EID, expert.qualification as qual FROM user JOIN eventhandling ON eventhandling.expertID = user.userID 
            JOIN expert ON expert.expertID = eventhandling.expertID;');
            $row = $this->db->resultSet();
            return $row;
        }

        
    }
?>