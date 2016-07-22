<?php
namespace uguranyum\icalenderexport;

use Yii;

class CalenderExport{

    public function lookDb($list_id){
        $getLists    = Yii::$app->db2->createCommand("Select * From `calendar` Where `list_id` Like ".$list_id." And `availability` Not Like 'Available' ")->queryAll();

        $ical   =  "BEGIN:VCALENDAR\nPRODID;X-RICAL-TZSOURCE=TZINFO:-//Wiflap Com//Wiflap Hosted Calendar 0.2//EN\nCALSCALE:GREGORIAN\nVERSION:2.0\n";
        foreach($getLists as $list){
            $dtstart = str_replace('-','',$list["booked_date"]);
            $ical .= "BEGIN:VEVENT \n";
            $ical .= "DTEND;VALUE=DATE:".$dtstart."\n";
            $ical .= "DTSTART;VALUE=DATE:".$dtstart."\n";
            $ical .= "UID:Wiflap List Number : ".$list["list_id"]."\n";
            $ical .= "DESCRIPTION: ".$list["availability"]."\n";
            $ical .= "SUMMARY: ".$list["notes"]."\n";
            $ical .= "END:VEVENT"."\n";
        }
        $ical .= "END:VCALENDAR";

        //set correct content-type-header
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename=calendar.ics');
        echo $ical;
        exit;
    }

}