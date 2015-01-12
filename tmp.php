<?php

function GetVenuesFromZipRadius2($mRadius, $Zip) {
    $t = 0;
    $sql = "SELECT distinct zip_name,latitude, longitude,state_abrev from geo_loc WHERE zip = '" . $Zip . "' limit 1";
    if (!$LocResult = mysql_query($sql)) {
        return FALSE;
    } else {
        if (mysql_num_rows($LocResult) > 0) {
            $t = 1;
            $row = mysql_fetch_row($LocResult);
            $city = $row[0];
            $custLatitude = $row[1];
            $custLongitude = $row[2];
            $state = $row[3];
        } else {

            $sql2 = "SELECT distinct city,latitude, longitude
                     FROM `ip_group_city`
                     WHERE `zipcode` = '" . $Zip . "' limit 1";
            if (!$LocResult2 = mysql_query($sql2)) {
                return FALSE;
            } else {
                if (mysql_num_rows($LocResult2) > 0) {
                    $t = 2;
                    $row2 = mysql_fetch_row($LocResult2);
                    $city = $row2[0];
                    $custLatitude = $row2[1];
                    $custLongitude = $row2[2];
                    if ($city != '') {
                        $sttSql = "SELECT  distinct State FROM venue_list_active WHERE  City='" . mysql_real_escape_string($city) . "' limit 1";
                        if ($sttResult = mysql_query($sttSql)) {
                            $sttrow = mysql_fetch_array($sttResult);
                            if ($sttrow['State'] != '')
                                $state = $sttrow['State'];
                        }
                    }
                }
            }
        }
    }

    if ($t == 1) {

        list($LowLatitude, $HighLatitude, $LowLongitude, $HighLongitude) = GetMileRadius($custLatitude, $custLongitude, $mRadius);
        $VenueSql = "SELECT  distinct VenueID,longitude,latitude FROM geo_loc,venue_list_active WHERE (zip_name = venue_list_active.City  AND  latitude <= $HighLatitude AND latitude >= $LowLatitude AND longitude >= $LowLongitude AND longitude <= $HighLongitude) ";
        if (!$VenueResult = mysql_query($VenueSql)) {
            return FALSE;
        } else {
            $VenueArray = array();
            while ($row = mysql_fetch_array($VenueResult)) {
                $VenueDistance = GetDistance($row['latitude'], $row['longitude'], $custLatitude, $custLongitude, "M");
                if ($VenueDistance <= $mRadius && !in_array($row['VenueID'], $VenueArray))
                    $VenueArray[$row['VenueID']] = $row['VenueID'];
            }
            return $VenueArray;
        }
    }

    elseif ($t == 2 && $city != '') {
        $VenueSql = "SELECT  distinct VenueID FROM venue_list_active WHERE  City='" . mysql_real_escape_string($city) . "' ";
        if ($state != '') {
            $VenueSql .= " OR State='" . mysql_real_escape_string($state) . "'";
        }
        if (!$VenueResult = mysql_query($VenueSql)) {
            return FALSE;
        } else {
            $VenueArray = array();
            while ($row = mysql_fetch_array($VenueResult)) {
                $VenueArray[$row['VenueID']] = $row['VenueID'];
            }
            return $VenueArray;
        }
    }
    return false;
}

array( 103450 ,118937 ,109285 ,134510 ,104269 ,108132 ,137016 ,133386 ,138409 ,139139 ,113351 ,138823 ,120494 ,105224 ,115338 ,114114 ,104727 ,104938 ,115776 ,103452 ,116395 ,117736 ,105239 ,103986 ,111493 ,139319 ,133491 ,138463 ,109052 ,135181 ,108083 ,108095 ,111627 ,106419 ,114871 ,111019 ,123153 ,111770 ,111793 ,134377 ,139334 ,133683 ,133623 ,114995 ,118419 ,133599 ,138336 ,121581 ,123162 ,121420 ,138780 ,133007 ,133907 ,133664 ,133804 ,104275 ,138599 ,104327 ,121093 ,137523 ,102896 ,106286 ,110938 ,122577 ,138524 ,103230 ,115975 ,104959 ,121551 ,138133 ,136936 ,106353 ,133508 ,139264 ,137067 ,108119 ,112322 ,108133 ,139133 ,115513 ,135891 ,136799 ,106297 ,116263 ,104871 ,113477 ,123384 ,115756 ,104677 ,109243 ,122038 ,110910 ,114621 );
//venues in 85007 with radius of 150 mile
array(103450,118937,109285,134510,104269,108132,137016,133386,138409,139139,113351,138823,120494,105224,115338,114114,104727,104938,115776,103452,116395,117736,105239,103986,111493,139319,133491,138463,109052,135181,108083,108095,111627,106419,114871,111019,123153,111770,111793,134377,139334,133683,133623,114995,118419,133599,138336,121581,123162,121420,138780,133007,133907,133664,133804,104275,138599,104327,121093,137523,102896,106286,110938,122577,138524,103230,115975,104959,121551,138133,136936,106353,133508,139264,137067,108119,112322,108133,139133,115513,135891,136799,106297,116263,104871,113477,123384,115756,104677,109243,122038,110910);