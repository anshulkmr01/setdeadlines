<?php

	class Google
	{
		
		function __construct()
		{

			$this->client_secret = 'DTxe6i4UMrUOWam9p5Kt1R1y';
			$this->redirect_uri = 'https://setdeadlines.com/user/UserProfile';
			$this->client_id = '51014718825-180gmq94m28nrn4ht274kfprft285ajk.apps.googleusercontent.com';

			// Set the super object to a local variable for use later
			$this->CI =& get_instance();

			// Load the Sessions class
			$this->CI->load->driver('session');

			$this->_access_token = $this->CI->session->userdata('access_token');
			$this->_refresh_token = $this->CI->session->userdata('refresh_token');
			$this->_access_token_expiry = $this->CI->session->userdata('access_token_expiry');

			if ($this->_access_token === NULL) $this->_access_token = '';
			if ($this->_refresh_token === NULL) $this->_refresh_token = '';
			if ($this->_access_token_expiry === NULL) $this->_access_token_expiry = '';

			if ($this->_refresh_token != '') {
				if(time() > $this->_access_token_expiry) {

				// Get a new access token using the refresh token
				$this->GetRefreshedAccessToken();
				}
			}

			if ($this->_access_token) {
				// Get a Time Zone
				$this->_timeZone =  $this->GetUserCalendarTimezone();
			}

		}

		public function login_url(){
			$url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode($this->redirect_uri) . '&response_type=code&client_id=' . $this->client_id . '&access_type=offline&prompt=consent';
			return $url;
		}

		public function access_token(){
			return $this->_access_token;
		}

		public function GetAccessToken($code) {	
			$url = 'https://accounts.google.com/o/oauth2/token';			
			
			$curlPost = 'client_id=' . $this->client_id . '&redirect_uri=' . $this->redirect_uri . '&client_secret=' . $this->client_secret . '&code='. $code . '&grant_type=authorization_code';
			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);		
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
			$data = json_decode(curl_exec($ch), true);
			$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
			if($http_code != 200) 
				throw new Exception('Error : Failed to receieve access token');
				
			// Refresh Token
			if(array_key_exists('refresh_token', $data))
			$this->_refresh_token = $data['refresh_token'];

			// Save the access token expiry timestamp
			$this->_access_token_expiry = time() + $data['expires_in'];

			// Save the access token as a session variable
			$this->_access_token = $data['access_token'];

			$this->save_access_token();

		}

		public function GetUserCalendarTimezone() {
			$url_settings = 'https://www.googleapis.com/calendar/v3/users/me/settings/timezone';
			
			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url_settings);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $this->_access_token));	
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
			$data = json_decode(curl_exec($ch), true); //echo '<pre>';print_r($data);echo '</pre>';
			$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
			if($http_code != 200) 
				throw new Exception('Error : Failed to get timezone');

			return $data['value'];
		}

		public function GetCalendarsList() {
			$url_parameters = array();

			$url_parameters['fields'] = 'items(id,summary,timeZone)';
			$url_parameters['minAccessRole'] = 'owner';

			$url_calendars = 'https://www.googleapis.com/calendar/v3/users/me/calendarList?'. http_build_query($url_parameters);
			
			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url_calendars);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $this->_access_token));	
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
			$data = json_decode(curl_exec($ch), true); //echo '<pre>';print_r($data);echo '</pre>';
			$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
			if($http_code != 200) 
				throw new Exception('Error : Failed to get calendars list');

			return $data['items'];
		}

		public function CreateCalendarEvent($calendar_id, $summary, $description, $all_day, $event_time) {
			$url_events = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events';

			$curlPost = array('summary' => $summary,'description' => $description);
			if($all_day == 1) {
				$curlPost['start'] = array('date' => $event_time);
				$curlPost['end'] = array('date' => $event_time);
			}
			else {
				$curlPost['start'] = array('dateTime' => $event_time['start_time'], 'timeZone' => $this->_timeZone);
				$curlPost['end'] = array('dateTime' => $event_time['end_time'], 'timeZone' => $this->_timeZone);
			}
			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url_events);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
			curl_setopt($ch, CURLOPT_POST, 1);		
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $this->_access_token, 'Content-Type: application/json'));	
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPost));	
			$data = json_decode(curl_exec($ch), true);
			$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
			if($http_code != 200) 
				throw new Exception('Error : Failed to create event');

			return $data['id'];
		}

		public function DeleteCalendarEvent($event_id, $calendar_id) {
			$url_events = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events/' . $event_id;

			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url_events);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');		
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $this->_access_token, 'Content-Type: application/json'));		
			$data = json_decode(curl_exec($ch), true);
			$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			//if($http_code != 204) 
			//	throw new Exception('Error : Failed to delete event');
		}

			public function GetRefreshedAccessToken() {	
			$url_token = 'https://www.googleapis.com/oauth2/v4/token';			
			
			$curlPost = 'client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&refresh_token='. $this->_refresh_token . '&grant_type=refresh_token';
			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url_token);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
			curl_setopt($ch, CURLOPT_POST, 1);		
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
			$data = json_decode(curl_exec($ch), true);	//print_r($data);
			$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
			if($http_code != 200) 
				throw new Exception('Error : Failed to refresh access token');
				
			
			// Again save the expiry time of the new token
			// Save the access token expiry timestamp
			$this->_access_token_expiry = time() + $data['expires_in'];

			// The new access token
			$this->_access_token = $data['access_token'];

			$this->save_access_token();
		}

		public function GetUserProfileInfo() {	
			$url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email';			
			
			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $this->_access_token));
			$data = json_decode(curl_exec($ch), true);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
			if($http_code != 200) 
				throw new Exception('Error : Failed to get user information');
				
			return $data;
		}

		public function UpdateCalendarEvent($event_id, $calendar_id, $summary, $event_description, $all_day, $event_time) {
			$url_events = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events/' . $event_id;

			$curlPost = array('summary' => $summary, 'description' => $event_description);
			if($all_day == 1) {
				$curlPost['start'] = array('date' => $event_time['event_date']);
				$curlPost['end'] = array('date' => $event_time['event_date']);
			}
			else {
				$curlPost['start'] = array('dateTime' => $event_time['start_time'], 'timeZone' => $this->_timeZone);
				$curlPost['end'] = array('dateTime' => $event_time['end_time'], 'timeZone' => $this->_timeZone);
			}
			$ch = curl_init();		
			curl_setopt($ch, CURLOPT_URL, $url_events);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');		
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $this->_access_token, 'Content-Type: application/json'));	
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPost));	
			$data = json_decode(curl_exec($ch), true);
			$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
			if($http_code != 200) 
				throw new Exception('Error : Failed to update event');
		}

		public function disconnect(){

			$this->CI->session->unset_userdata('access_token');
			$this->CI->session->unset_userdata('refresh_token');
			$this->CI->session->unset_userdata('access_token_expiry');
		}

		protected function save_access_token(){
			 $this->CI->session->set_userdata('access_token', $this->_access_token);
			 $this->CI->session->set_userdata('refresh_token', $this->_refresh_token);
			 $this->CI->session->set_userdata('access_token_expiry', $this->_access_token_expiry);
		}
	}
?>