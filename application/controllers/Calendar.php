<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Calendar extends CI_Controller { 
     
    function __construct() { 
        parent::__construct(); 
         
        $this->load->model('CalendarModel'); 
    } 
     
    public function index(){ 
        $data = array(); 
        $data['eventCalendar'] = $this->eventCalendar(); 
        $this->load->view('calendar/index', $data); 
    } 
     
    /* 
     * Generate calendar with events 
     */ 
    public function eventCalendar($year = '', $month = ''){ 
        $data = array(); 
         
        $dateYear = ($year != '')?$year:date("Y"); 
        $dateMonth = ($month != '')?$month:date("m"); 
        $date = $dateYear.'-'.$dateMonth.'-01'; 
        $currentMonthFirstDay = date("N", strtotime($date)); 
        $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN, $dateMonth, $dateYear); 
        $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay); 
        $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42; 
         
        $con = array( 
            'where' => array( 
                'status' => 1 
            ), 
            'where_year' => $dateYear, 
            'where_month' => $dateMonth 
        ); 
        $data['events'] = $this->CalendarModel->getGroupCount($con); 
         
        $data['calendar'] = array( 
            'dateYear' => $dateYear, 
            'dateMonth' => $dateMonth, 
            'date' => $date, 
            'currentMonthFirstDay' => $currentMonthFirstDay, 
            'totalDaysOfMonthDisplay' => $totalDaysOfMonthDisplay, 
            'boxDisplay' => $boxDisplay 
        ); 
         
        $data['monthOptions'] = $this->getMonths($dateMonth); 
        $data['yearOptions'] = $this->getYears($dateYear); 
 
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])){ 
            $this->load->view('calendar/event-cal', $data); 
        }else{ 
            return $this->load->view('calendar/event-cal', $data, true); 
        } 
    } 
     
    /* 
     * Generate months options list for select box 
     */ 
    function getMonths($selected = ''){ 
        $options = ''; 
        for($i=1;$i<=12;$i++) 
        { 
            $value = ($i < 10)?'0'.$i:$i; 
            $selectedOpt = ($value == $selected)?'selected':''; 
            $options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>'; 
        } 
        return $options; 
    } 
    
    /* 
     * Generate years options list for select box 
     */ 
    function getYears($selected = ''){ 
        $options = ''; 
        for($i=2019;$i<=2025;$i++) 
        { 
            $selectedOpt = ($i == $selected)?'selected':''; 
            $options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>'; 
        } 
        return $options; 
    } 
    
    /* 
     * Generate events list in HTML format 
     */ 
    function getEvents($date = ''){ 
        $eventListHTML = ''; 
        $date = $date?$date:date("Y-m-d"); 
         
        // Fetch events based on the specific date 
        $con = array( 
            'where' => array( 
                'date' => $date, 
                'status' => 1 
            ) 
        ); 
        $events = $this->CalendarModel->getRows($con); 
 
        if(!empty($events)){ 
            $eventListHTML = '<h2>Events on '.date("l, d M Y",strtotime($date)).'</h2>'; 
            $eventListHTML .= '<ul>'; 
            foreach($events as $row){  
                $eventListHTML .= '<li>'.$row['title'].'</li>'; 
            } 
            $eventListHTML .= '</ul>'; 
        } 
        echo $eventListHTML; 
    } 
}