<?php

// South County Football League Copyright 2009, 2010, 2011
// Original content authored/modified by Mitch Provost -->


class Calendar {
    /*
      Constructor for the Calendar class
     */

    function Calendar() {
        
    }

    /*
      Get the array of strings used to label the days of the week. This array contains seven
      elements, one for each day of the week. The first entry in this array represents Sunday.
     */

    function getDayNames() {
        return $this->dayNames;
    }

    /*
      Set the array of strings used to label the days of the week. This array must contain seven
      elements, one for each day of the week. The first entry in this array represents Sunday.
     */

    function setDayNames($names) {
        $this->dayNames = $names;
    }

    /*
      Get the array of strings used to label the months of the year. This array contains twelve
      elements, one for each month of the year. The first entry in this array represents January.
     */

    function getMonthNames() {
        return $this->monthNames;
    }

    /*
      Set the array of strings used to label the months of the year. This array must contain twelve
      elements, one for each month of the year. The first entry in this array represents January.
     */

    function setMonthNames($names) {
        $this->monthNames = $names;
    }

    /*
      Gets the start day of the week. This is the day that appears in the first column
      of the calendar. Sunday = 0.
     */

    function getStartDay() {
        return $this->startDay;
    }

    /*
      Sets the start day of the week. This is the day that appears in the first column
      of the calendar. Sunday = 0.
     */

    function setStartDay($day) {
        $this->startDay = $day;
    }

    /*
      Gets the start month of the year. This is the month that appears first in the year
      view. January = 1.
     */

    function getStartMonth() {
        return $this->startMonth;
    }

    /*
      Sets the start month of the year. This is the month that appears first in the year
      view. January = 1.
     */

    function setStartMonth($month) {
        $this->startMonth = $month;
    }

    /*
      Return the URL to link to in order to display a calendar for a given month/year.
      You must override this method if you want to activate the "forward" and "back"
      feature of the calendar.

      Note: If you return an empty string from this function, no navigation link will
      be displayed. This is the default behaviour.

      If the calendar is being displayed in "year" view, $month will be set to zero.
     */

    function getCalendarLink($month, $year) {
        return "cv=1&m=$month&y=$year";
    }

    /*
      Return the URL to link to  for a given date.
      You must override this method if you want to activate the date linking
      feature of the calendar.

      Note: If you return an empty string from this function, no navigation link will
      be displayed. This is the default behaviour.
     */

    function getDateLink($day, $month, $year) {
        return '';
    }

    /*
      Return the HTML for the current month
     */

    function getCurrentMonthView() {
        $d = getdate(time());
        return $this->getMonthView($d["mon"], $d["year"]);
    }

    /*
      Return the HTML for the current year
     */

    function getCurrentYearView() {
        $d = getdate(time());
        return $this->getYearView($d["year"]);
    }

    /*
      Return the HTML for a specified month
     */

    function getMonthView($month, $year) {
        return $this->getMonthHTML($month, $year);
    }

    /*
      Return the HTML for a specified year
     */

    function getYearView($year) {
        return $this->getYearHTML($year);
    }

    /*     * ******************************************************************************

      The rest are private methods. No user-servicable parts inside.

      You shouldn't need to call any of these functions directly.

     * ******************************************************************************* */


    /*
      Calculate the number of days in a month, taking into account leap years.
     */

    function getDaysInMonth($month, $year) {
        if ($month < 1 || $month > 12) {
            return 0;
        }

        $d = $this->daysInMonth[$month - 1];

        if ($month == 2) {
            // Check for leap year
            // Forget the 4000 rule, I doubt I'll be around then...

            if ($year % 4 == 0) {
                if ($year % 100 == 0) {
                    if ($year % 400 == 0) {
                        $d = 29;
                    }
                } else {
                    $d = 29;
                }
            }
        }

        return $d;
    }

    function getSchMonth($m, $y, $res, $r) {
        $s = "";

        $a = $this->adjustDate($m, $y);
        $month = $a[0];
        $year = $a[1];
        if ($month == 0)
            $month = date("n");
        if ($year == 0)
            $year = date("Y");

        $daysInMonth = date('t', strtotime($year . '-' . $month));
        $date = getdate(mktime(12, 0, 0, $month, 1, $year));

        $first = $date["wday"];
        $monthName = $this->monthNames[$month - 1];

        $header = $monthName . " " . $year;

        $s .= "<center><table style=\"border-collapse: collapse;\" cellpadding=\"3px\" class=\"cal\">\n";
        $s .= "<tr>\n";
//    	$s .= "<td align=\"center\" valign=\"top\">" . (($prevMonth == "") ? "&nbsp;" : "<a href=\"$prevMonth\">&lt;&lt;</a>")  . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" style=\"color:blue;font-size:14px;\" colspan=\"7\"><b>$header</b></td>\n";
//    	$s .= "<td align=\"center\" valign=\"top\">" . (($nextMonth == "") ? "&nbsp;" : "<a href=\"$nextMonth\">&gt;&gt;</a>")  . "</td>\n";
        $s .= "</tr>\n";

        $s .= "<tr>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 1) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 2) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 3) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 4) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 5) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 6) % 7] . "</td>\n";
        $s .= "</tr>\n";

        // We need to work out what date to start at so that the first appears in the correct column
        $d = $this->startDay + 1 - $first;
        while ($d > 1)
            $d -= 7;

        // Make sure we know when today is, so that we can use a different CSS style
//        $today = getdate(time());

        while ($d <= $daysInMonth) {
            $s .= "<tr>\n";

            for ($i = 0; $i < 7; $i++) {
                $link = '';
                $dd = '';
                $past = false;
                if (strtotime($y.'-'.$m.'-'.$d) <= strtotime(date('y-m-d'))){
                    $dd = (($d > 0) ? 'color: silver;' : '');
                    $past = true;
                }
                else $clss = 'cal';
                if ($res && $d > 0) {
                    foreach ($res as $k => $v) {
                        if (date("Y-m-d", strtotime($y.'-'.$m.'-'.$d)) >= $v['startdate'] 
                                                                  && date("Y-m-d", strtotime($y.'-'.$m.'-'.$d)) <= $v['enddate']) {
                            $rid = $v['ID'];
                            $nme = $v['firstName'].' '.$v['lastName'];
                            $st = date("n/j/Y", strtotime($v['startdate']));
                            $sp = date("n/j/Y", strtotime($v['enddate']));
                            $un = $v['unit'];
                                switch ($v['unit']) {
                                    case 'A' : $dd = ($r ? '' : 'color: silver; background-color: green'); break;
                                    case 'B' : $dd = 'color: silver; background-color: red'; break;
                                    case 'C' : $dd = ($r ? 'color: silver; background-color: red' : 'color: silver; background-color: purple');
                                        break;
                                    default : $dd = '';
                                }
                            $link = '#res';
                            $clss = 'calres';
                            break;
                        }
                    }
                }
                $s .= '<td class="calday" style="'.$dd.'">';
                if ($d > 0 && $d <= $daysInMonth) {
                    if ($link == '') $link = '#startstop';
                    $s .= ($past || $r ? $d : '<a id="'.($link == '#startstop' ? $m.'/'.$d.'/'.$y : $rid.':'.$nme.':'.$st.':'.$sp.':'.$un).'" 
                                class="'.$clss.'" href="'.$link.'">'.$d.'</a>');
                }
                else
                    $s .= '&nbsp;';
                $s .= "</td>\n";
                $d++;
            }
            $s .= "</tr>\n";
        }

        $s .= "</table></center>\n";

        return $s;
    }

    function getCalMonth($m, $y, $showYear = 1) {
        $s = "";

        $a = $this->adjustDate($m, $y);
        $month = $a[0];
        $year = $a[1];
        if ($month == 0)
            $month = date("n");
        if ($year == 0)
            $year = date("Y");

        $daysInMonth = date('t', strtotime($year . '-' . $month));
        $date = getdate(mktime(12, 0, 0, $month, 1, $year));

        $first = $date["wday"];
        $monthName = $this->monthNames[$month - 1];

        $prev = $this->adjustDate($month - 1, $year);
        $next = $this->adjustDate($month + 1, $year);
        if ($showYear == 1) {
            $prevMonth = $this->getCalendarLink($prev[0], $prev[1]);
            $nextMonth = $this->getCalendarLink($next[0], $next[1]);
        } else {
            $prevMonth = "";
            $nextMonth = "";
        }

        $header = $monthName . (($showYear > 0) ? " " . $year : "");

        $s .= "<table cellpadding=\"3px\" class=\"calmo\">\n";
        $s .= "<tr>\n";
        $s .= "<td align=\"center\" valign=\"top\">" . (($prevMonth == "") ? "&nbsp;" : "<a class=\"inside\" href=\"$prevMonth\"><b>&lt;&lt;</b></a>") . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" style=\"color:yellow;font-size:14px;\" colspan=\"5\"><b>$header</b></td>\n";
        $s .= "<td align=\"center\" valign=\"top\">" . (($nextMonth == "") ? "&nbsp;" : "<a class=\"inside\" href=\"$nextMonth\"><b>&gt;&gt;</b></a>") . "</td>\n";
        $s .= "</tr>\n";

        $s .= "<tr>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 1) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 2) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 3) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 4) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 5) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 6) % 7] . "</td>\n";
        $s .= "</tr>\n";

        // We need to work out what date to start at so that the first appears in the correct column
        $d = $this->startDay + 1 - $first;
        while ($d > 1)
            $d -= 7;

        // Make sure we know when today is, so that we can use a different CSS style
        $today = getdate(time());

        while ($d <= $daysInMonth) {
            $s .= "<tr>\n";

            for ($i = 0; $i < 7; $i++) {
                $s .= "<td align=\"right\" valign=\"top\" class=\"calendarCell\">";
                $bdr = '';
                if ($d > 0 && $d <= $daysInMonth) {
                    $dt = date("Y-m-d", strtotime($month . '/' . $d . '/' . $year));
                    if (in_array($dt, $dats)) {
                        $link = '5&gd=' . strtotime($month . '/' . $d . '/' . $year);
                        if ($dt == $dte)
                            $bdr = 'border:1px solid white;';
                        if ($postgs[$dt] > 0 && $postgs[$dt] < 9)
                            $postc = 'color:dodgerblue;';
                        if ($postgs[$dt] == 9)
                            $postc = 'color:red;';
                    }
                    else
                        $link = '';
                    $s .= (($link == "") ? $d : "<a class=\"inside\" style=\"$postc$bdr\" href=\"$link\">$d</a>");
                }
                else
                    $s .= "&nbsp;";
                $s .= "</td>\n";
                $d++;
            }
            $s .= "</tr>\n";
        }

        $s .= "</table>\n";

        return $s;
    }

    /*
      Generate the HTML for a given month
     */

    function getMonthHTML($m, $y, $showYear = 1) {
        $s = "";

        $a = $this->adjustDate($m, $y);
        $month = $a[0];
        $year = $a[1];
        if ($month == 0)
            $month = date("n");
        if ($year == 0)
            $year = date("Y");

        $daysInMonth = date('t', $month . '-' . $year);
//        $daysInMonth = $this->getDaysInMonth($month, $year);
        $date = getdate(mktime(12, 0, 0, $month, 1, $year));

        $first = $date["wday"];
        $monthName = $this->monthNames[$month - 1];

        $prev = $this->adjustDate($month - 1, $year);
        $next = $this->adjustDate($month + 1, $year);

        if ($showYear == 1) {
            $prevMonth = $this->getCalendarLink($prev[0], $prev[1]);
            $nextMonth = $this->getCalendarLink($next[0], $next[1]);
        } else {
            $prevMonth = "";
            $nextMonth = "";
        }

        $header = $monthName . (($showYear > 0) ? " " . $year : "");

        $s .= "<table class=\"calendar\">\n";
        $s .= "<tr>\n";
        $s .= "<td align=\"center\" valign=\"top\">" . (($prevMonth == "") ? "&nbsp;" : "<a href=\"$prevMonth\">&lt;&lt;</a>") . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\" colspan=\"5\">$header</td>\n";
        $s .= "<td align=\"center\" valign=\"top\">" . (($nextMonth == "") ? "&nbsp;" : "<a href=\"$nextMonth\">&gt;&gt;</a>") . "</td>\n";
        $s .= "</tr>\n";

        $s .= "<tr>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 1) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 2) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 3) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 4) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 5) % 7] . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . $this->dayNames[($this->startDay + 6) % 7] . "</td>\n";
        $s .= "</tr>\n";

        // We need to work out what date to start at so that the first appears in the correct column
        $d = $this->startDay + 1 - $first;
        while ($d > 1) {
            $d -= 7;
        }

        // Make sure we know when today is, so that we can use a different CSS style
        $today = getdate(time());


        while ($d <= $daysInMonth) {
            $s .= "<tr>\n";

            for ($i = 0; $i < 7; $i++) {
                $class = ($year == $today["year"] && $month == $today["mon"] && $d == $today["mday"]) ? "calendarToday" : "calendar";
                $s .= "<td class=\"$class\" align=\"right\" valign=\"top\">";
                if ($d > 0 && $d <= $daysInMonth) {
                    $link = $this->getDateLink($d, $month, $year);
                    $s .= (($link == "") ? $d : "<a href=\"$link\">$d</a>");
                } else {
                    $s .= "&nbsp;";
                }
                $s .= "</td>\n";
                $d++;
            }
            $s .= "</tr>\n";
        }

        $s .= "</table>\n";

        return $s;
    }

    /*
      Generate the HTML for a given year
     */

    function getYearHTML($year) {
        $s = "";
        $prev = $this->getCalendarLink(0, $year - 1);
        $next = $this->getCalendarLink(0, $year + 1);

        $s .= "<table class=\"calendar\" border=\"0\">\n";
        $s .= "<tr>";
        $s .= "<td align=\"center\" valign=\"top\" align=\"left\">" . (($prev == "") ? "&nbsp;" : "<a href=\"$prev\">&lt;&lt;</a>") . "</td>\n";
        $s .= "<td class=\"calendarHeader\" valign=\"top\" align=\"center\">" . (($this->startMonth > 1) ? $year . " - " . ($year + 1) : $year) . "</td>\n";
        $s .= "<td align=\"center\" valign=\"top\" align=\"right\">" . (($next == "") ? "&nbsp;" : "<a href=\"$next\">&gt;&gt;</a>") . "</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(0 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(1 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(2 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(3 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(4 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(5 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(6 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(7 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(8 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "</tr>\n";
        $s .= "<tr>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(9 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(10 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(11 + $this->startMonth, $year, 0) . "</td>\n";
        $s .= "</tr>\n";
        $s .= "</table>\n";

        return $s;
    }

    /*
      Adjust dates to allow months > 12 and < 0. Just adjust the years appropriately.
      e.g. Month 14 of the year 2001 is actually month 2 of year 2002.
     */

    function adjustDate($month, $year) {
        $a = array();
        $a[0] = $month;
        $a[1] = $year;

        while ($a[0] > 12) {
            $a[0] -= 12;
            $a[1]++;
        }

        while ($a[0] <= 0) {
            $a[0] += 12;
            $a[1]--;
        }

        return $a;
    }

    /*
      The start day of the week. This is the day that appears in the first column
      of the calendar. Sunday = 0.
     */

    var $startDay = 0;

    /*
      The start month of the year. This is the month that appears in the first slot
      of the calendar in the year view. January = 1.
     */
    var $startMonth = 1;

    /*
      The labels to display for the days of the week. The first entry in this array
      represents Sunday.
     */
    var $dayNames = array("S", "M", "T", "W", "T", "F", "S");

    /*
      The labels to display for the months of the year. The first entry in this array
      represents January.
     */
    var $monthNames = array("January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December");


    /*
      The number of days in each month. You're unlikely to want to change this...
      The first entry in this array represents January.
     */
    var $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

}

?>
