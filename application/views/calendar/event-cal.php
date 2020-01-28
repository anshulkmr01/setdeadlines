<div class="calendar-wrap">
    <div class="cal-nav">
        <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($calendar['date'].' - 1 Month')); ?>','<?php echo date("m",strtotime($calendar['date'].' - 1 Month')); ?>');">&laquo;</a>
        <select class="month_dropdown"><?php echo $monthOptions; ?></select>
        <select class="year_dropdown"><?php echo $yearOptions; ?></select>
        <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($calendar['date'].' + 1 Month')); ?>','<?php echo date("m",strtotime($calendar['date'].' + 1 Month')); ?>');">&raquo;</a>
    </div>
    <div id="event_list" class="none"></div>
    <div class="calendar-days">
        <ul>
            <li>SUN</li>
            <li>MON</li>
            <li>TUE</li>
            <li>WED</li>
            <li>THU</li>
            <li>FRI</li>
            <li>SAT</li>
        </ul>
    </div>
    <div class="calendar-dates">
        <ul>
        <?php  
            $dayCount = 1; 
            $eventNum = 0; 
            for($cb=1;$cb<=$calendar['boxDisplay'];$cb++){ 
                if(($cb >= $calendar['currentMonthFirstDay']+1 || $calendar['currentMonthFirstDay'] == 7) && $cb <= ($calendar['totalDaysOfMonthDisplay'])){ 
                    // Current date 
                    $dayCount = ($dayCount < 10 && strpos($dayCount, '0') == false)?'0'.$dayCount:$dayCount; 
                    $currentDate = $calendar['dateYear'].'-'.$calendar['dateMonth'].'-'.$dayCount; 
                     
                    // Get number of events based on the current date 
                    $eventNum = 0; 
                    if(!empty($events)){ 
                        $eventData = array_filter($events, function ($var) use ($currentDate) { 
                            return ($var['date'] == $currentDate); 
                        }); 
                        $eventData = array_values($eventData); 
                        $eventData = !empty($eventData[0])?$eventData[0]:''; 
                        $eventNum = !empty($eventData['event_num'])?$eventData['event_num']:0; 
                    } 
                     
                    // Define date cell color 
                    if(strtotime($currentDate) == strtotime(date("Y-m-d"))){ 
                        echo '<li date="'.$currentDate.'" class="grey date_cell">'; 
                    }elseif($eventNum > 0){ 
                        echo '<li date="'.$currentDate.'" class="light_sky date_cell">'; 
                    }else{ 
                        echo '<li date="'.$currentDate.'" class="date_cell">'; 
                    } 
                     
                    // Date cell 
                    echo '<span>'; 
                    echo $dayCount; 
                    echo '</span>'; 
                     
                    // Hover event popup 
                    echo '<div id="date_popup_'.$currentDate.'" class="date_popup_wrap none">'; 
                    echo '<div class="date_window">'; 
                    echo '<div class="popup_event">Events ('.$eventNum.')</div>'; 
                    echo ($eventNum > 0)?'<a href="javascript:;" onclick="getEvents(\''.$currentDate.'\');">view events</a>':''; 
                    echo '</div></div>'; 
                     
                    echo '</li>'; 
                    $dayCount++; 
        ?>
        <?php }else{ ?>
            <li><span>&nbsp;</span></li>
        <?php } } ?>
        </ul>
    </div>
</div>
