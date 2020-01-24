
						<td style="text-align: center"><?= $rule->deadline_days;?><br>
			     			<small id="newCategory" class="form-text text-muted">
			     			 	<?php 	if($rule->day_type == "weekDay"){
			     			 			if($rule->deadline_days == "1") echo "Week Day";
			     			 			else echo "Week Days";
			     			 			}
			     			 			if($rule->day_type == "calendarDay"){
			     			 			if($rule->deadline_days == "1") echo "Calendar Day";
			     			 			else echo "Calendar Days";
			     			 			}?>
		     			 	</small>
						</td>