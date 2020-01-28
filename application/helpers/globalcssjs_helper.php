<?php

	function globalCss()
	{
		?>
		<?= link_tag("https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css")?>
		<?= link_tag("assets/css/lux-css/lux-bootstrap.css")?>
		<?= link_tag("assets/css/custom-css.css")?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
	}

	function calendarCss(){
		echo link_tag("assets/css/calendar.css");
	}

	function globalJs()
	{
		?>
		<script
		  src="https://code.jquery.com/jquery-3.4.1.min.js"
		  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		  crossorigin="anonymous"></script>
		  
		<script
			type="text/javascript"
			src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script 
			type="text/javascript"
			src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

		<script
			type="text/javascript"
			src="<?= base_url("assets/js/table-sorter.js")?>"></script>
		<script
			type="text/javascript"
			src="<?= base_url("assets/js/script.js")?>"></script>

		<script 
			type="text/javascript"
			src="<?= base_url("assets/js/custom-js.js")?>"></script>
		
		<?php
	}
?>