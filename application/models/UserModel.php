<?php

    class UserModel extends CI_Model
    {
        //User Registration
        function addUser($userData){
            $key = (md5(time()));
                $query = $this->db->insert('users',['fullname'=>$userData['fullName'], 'email'=>$userData['userEmail'],
                    'telephone'=>$userData['telephone'],'password'=>md5($userData['password']),'verificationkey'=>$key]);

                if($query){
                $this->verifyEmail($key,$userData['userEmail']);
                return $query;
                }
            }

        //verify Email
        function verifyEmail($key,$user){
            $url = base_url('user/UserController/verifyUser/'.$user.'/'.$key);
            //Load email library
                $this->load->library('email');

                // $config['protocol']    = 'smtp';
                // $config['smtp_host']    = 'ssl://smtp.gmail.com';
                // $config['smtp_port']    = '465';
                // $config['smtp_timeout'] = '600';

                // $config['smtp_user']    = 'setdeadlines@gmail.com';    //Important
                // $config['smtp_pass']    = 'Setdeadlines@#jy312';  //Important


                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['mailtype'] = 'html'; // or html
                $config['validation'] = TRUE; // bool whether to validate email or not 

                $this->email->initialize($config);
                $this->email->set_mailtype("html"); 
                $this->email->set_newline("\r\n");


                $message .= 'Dear User, <br><br>';
                $message .= 'Thank you so much to register with Set Deadlines, please click on the button below to verify your email address and you can login to your account. <br><br>';
                $message .= '<a href='.$url.' style="background: #000;padding: 11px;color: #fff; text-decoration: none;">Verify</a> <br><br>' ;

                $this->email->from('setdeadlines@gmail.com', 'Set Deadlines');
                $this->email->to($user);

                $this->email->subject('Thank you so much to register with Set Deadlines, Please Verify your Email');
                $this->email->message($message);
                $this->email->send();
        }

        //User Verify using email link
        function verifyUser($userEmail,$recivedKey){
            $query = $this->db->where(['email'=>$userEmail])->get('users');
                if($query->num_rows()){

                    //Retriving Key of email
                    $DBkey = $query->row()->verificationkey;
                    $is_verified = $query->row()->is_verified;
                    if($is_verified){
                        $this->session->set_flashdata('warning','You are already a Verified User, Login to contionue');
                        return redirect('loginUser');
                    }

                    if($recivedKey == $DBkey){
                        return $this->db->where(['email'=>$userEmail, 'verificationkey'=>$recivedKey])->update('users',['is_verified'=>1]);
                        }
                        else{
                            //key does not matched
                            $this->session->set_flashdata('error','Link Expired');
                            return redirect('loginUser');
                        }
                    }
                    else{
                            //email does not matched
                            $this->session->set_flashdata('error','Link Expired');
                            return redirect('loginUser');
                    }
                }

        //User Login
        function validateUser($userData){
                $query = $this->db->where(['email'=>$userData['userEmail']])->get('users');
                if($query->num_rows()){

                    //Retriving password of email
                    $userPassword = $query->row()->password;

                    if(md5($userData['userPassword'])==$userPassword){
                        if($query->row()->is_verified){

                            //User is Verified 
                            return $query->row()->id;
                        }
                        else{
                            //User is not verified yet
                            $this->session->set_flashdata('warning','Check Email, Please Verify Your account.');
                            return redirect('loginUser');
                        }
                    }
                    else{
                        //wrong Password
                        return false;
                    }
                }
                else{
                        $this->session->set_flashdata('error','Email is not registered');
                        return redirect('loginUser');
                }
            }
            //Password Recovery email
            function sendRecoverEmail($userEmail){
                 $query = $this->db->where(['email'=>$userEmail])->get('users');
                 if($query->num_rows())
                 {
                    $recoveryKey = (md5(time()));
                    $result = $this->db->where(['email'=>$userEmail])->update('users',['verificationkey'=>$recoveryKey]);
                    if($result){
                    $url = base_url('user/UserController/resetPassword/'.$userEmail.'/'.$recoveryKey);

                    $this->load->library('email');
                    
                    // $config['protocol']    = 'smtp';
                    // $config['smtp_host']    = 'ssl://smtp.gmail.com';
                    // $config['smtp_port']    = '465';
                    // $config['smtp_timeout'] = '600';

                    // $config['smtp_user']    = 'setdeadlines@gmail.com';    //Important
                    // $config['smtp_pass']    = 'Setdeadlines@#jy312';  //Important


                    $config['charset']    = 'utf-8';
                    $config['newline']    = "\r\n";
                    $config['mailtype'] = 'html'; // or html
                    $config['validation'] = TRUE; // bool whether to validate email or not 

                    $this->email->initialize($config);
                    $this->email->set_mailtype("html"); 
                    $this->email->set_newline("\r\n");


                    $message .= 'Dear User, <br><br>';
                    $message .= 'Please Click on Below button and Create a new password. <br><br>';
                    $message .= '<a href='.$url.' style="background: #000;padding: 11px;color: #fff; text-decoration: none;">Click Here</a> <br><br>' ;

                    $this->email->from('setdeadlines@gmail.com', 'Set Deadlines');
                    $this->email->to($user);

                    $this->email->subject('Thank you so much to register with Set Deadlines, Please Verify your Email');
                    $this->email->message($message);
                    $this->email->send();
                    

                    return true;
                    }
                 }
                 else{
                    $this->session->set_flashdata('error',"You are not a registered user");
                    return redirect('recoverPassword');
                 }
            }

            function recoveryKey($userEmail,$recoveryKey){
                $query = $this->db->where(['email'=>$userEmail])->get('users');
                if($query->num_rows()){

                    //Retriving Key of email
                    $DBkey = $query->row()->verificationkey;
                    if($recoveryKey == $DBkey){
                            $this->session->set_userdata('userEmail',$userEmail);
                            $this->session->set_userdata('recoveryKey',$recoveryKey);
                            return true;
                        }
                        else{
                            //key does not matched
                            $this->session->set_flashdata('error','Link expired');
                            return redirect('loginUser');
                        }
                    }
                    else{
                            //key and email does not matched
                            $this->session->set_flashdata('error','Link expired');
                            return redirect('loginUser');
                    }
            }

            function setNewPassword($newPassword){
                $userEmail = $this->session->userdata('userEmail');
                $recoveryKey = $this->session->userdata('recoveryKey');

                $result = $this->db->where(['email'=>$userEmail, 'verificationkey'=>$recoveryKey])->update('users',['password'=>md5($newPassword),'verificationkey'=>0]);
                if($result){
                    $this->session->unset_userdata('userEmail');
                    $this->session->unset_userdata('recoveryKey');
                    return true;
                }
            }

            //User setting new Password
            function changePassword($changePasswordData){
                $userId = $this->session->userdata('userId');
                $existPassword = $this->db->where('id',$userId)->get('users')->row('password');
                if($existPassword == md5($changePasswordData['currentPassword'])){
                    return $this->db->where('id',$userId)->update('users',['password'=>md5($changePasswordData['newPassword'])]);
                }
            }

            function getSelectedCases($caseId){
                $userId = $this->session->userdata('userId');
            return $this->db->where(['ID'=>$caseId,'userID'=>$userId])->get('cases')->row('title');
            }

            function getSelectedRuleData($ruleId){
                $rules = $this->db->where(['ID'=>$ruleId])->get('userrules')->result();
                    $rules[0]->sub = $this->ruleDeadlines($rules[0]->ID);
                return $rules;
            }
            
            public function ruleDeadlines($id){
                return $this->db->where(['rule_Id'=>$id])->get('userdeadlines')->result();       
            }

            function checkIfUserExist($userdata){
                $query =  $this->db->where('email',$userdata['userEmail'])->get('users')->row('is_verified');
                
                if (isset($query)) {
                    if ($query == 0) {
                    $key = (md5(time()));
                    $query2 = $this->db->where('email',$userdata['userEmail'])->update('users',['verificationkey'=>$key]);
                    $this->verifyEmail($key,$userData['userEmail']);
                    //A veryfied user exist
                    $this->session->set_flashdata('warning','Congo! You are already a registered User, Please verify your email address');
                    return redirect('loginUser');
                    }
                    else{
                        //A veryfied user exist
                        $this->session->set_flashdata('success','Congo! You are already a registered User');
                        return redirect('loginUser');
                    }

                }
                else{
                    //No user found
                    return true;
                }
                exit();
            }

            function saveCase($caseData){

                $userId = $this->session->userData('userId');
                $query = $this->db->insert('savedcases',['userID'=>$userId,'caseID'=>$caseData['caseID'],
                    'caseTitle'=>$caseData['caseTitle'],
                    'motionDate'=>$caseData['motionDate'],
                    'ruleTitle'=>$caseData['ruleTitle'],'ruleDescription'=>$caseData['ruleDescription']]);
                $last_id = $this->db->insert_id();

                if($query):
                foreach ($caseData['deadlineData'] as $deadline) {
                    $data = explode ("/amg/", $deadline);
                   $this->saveDeadlines($data[0],$data[1],$data[2],$data[3],$last_id);
                }
                endif;
                return $query;
            }

            function saveDeadlines($deadlineTitle,$deadlineDesc,$deadlineDate,$deadlineGoogleID,$caseID){
                $query = $this->db->insert('saveddeadlinesforsavedcases',
                    ['caseID'=>$caseID,
                     'deadlineTitle'=>$deadlineTitle,
                     'deadlineDescription'=>$deadlineDesc,
                     'deadlineDate'=>$deadlineDate,
                     'deadlineGoogleID'=>$deadlineGoogleID]);
                return $query;
            }

            function deleteSavedCase($caseID){
                $deadlineGoogleID = $this->db->select('deadlineGoogleID')->where('caseID',$caseID)->get('saveddeadlinesforsavedcases')->result();
                if($this->db->delete('savedcases',['ID'=>$caseID]) && $this->db->delete('saveddeadlinesforsavedcases',['caseID'=>$caseID])){
                    return $deadlineGoogleID;   
                }

            }

            function userCases(){
                $userId = $this->session->userData('userId');
                $cases = $this->db->where(['userId'=>$userId])->get('savedcases')->result();
                 if($cases):
                    $i = 0;
                    foreach ($cases as $case) {
                       $cases[$i]->caseDeadlines = $this->userSavedRulesDeadlines($case->ID);
                       $i++;
                    }
                endif;
                return $cases;
            }

            
            function userSavedRules($caseID){
                $userId = $this->session->userData('userId');
                $cases = $this->db->where(['userId'=>$userId, 'ID'=>$caseID])->get('savedcases')->result();
                if($cases):
                    $i = 0;
                    foreach ($cases as $case) {
                       $cases[$i]->caseDeadlines = $this->userSavedRulesDeadlines($case->ID);
                       $i++;
                    }
                endif;
                return $cases;
            }

            function userSavedRulesDeadlines($caseID){
                $cases = $this->db->where(['caseID'=>$caseID])->get('saveddeadlinesforsavedcases')->result();
                return $cases;
            }


            function addCase($caseTitle){
                $userId = $this->session->userData('userId');
                return $this->db->insert('cases',['title'=>$caseTitle, 'userID'=>$userId]);
            }

            function getUserCases(){
                $userId = $this->session->userData('userId');

                return $this->db->where(['userID'=>$userId])->get('cases')->result();
            }

            function editCase($caseId,$caseTitle){
                return $this->db->where('ID',$caseId)->update('cases',['title'=>$caseTitle]);
            }

            function deleteCase($caseId){
                return $this->db->delete('cases',['ID'=>$caseId]);
            }

            function addUserRule($ruleData){
                $userID = $this->session->userdata('userId');
                return $this->db->insert('userrules',['userID'=>$userID,'title'=>$ruleData['ruleTitle'],'description'=>$ruleData['ruleDescription']]);
            }


            function editUserRule($ruleUpdatedData){
                return $this->db->where('ID',$ruleUpdatedData['ruleId'])
                ->update('userrules'
                    ,['title'=>$ruleUpdatedData['ruleUpdatedTitle']
                    ,'description'=>$ruleUpdatedData['ruleDesc']]);
            }


            function deleteUserRule($ruleId){
                if($this->db->delete('userdeadlines',['rule_Id'=>$ruleId]) && 
                $this->db->delete('userrules',['ID'=>$ruleId])){
                    return true;
                }
            }

            function deleteUser($userId){
                return $this->db->delete('users',['id'=>$userId]);
            }


            function dublicateUserRule($ruleId){

                $ruleData['rule'] = $this->db->where('ID',$ruleId)->get('userrules')->result();
                $ruleData['deadlines'] = $this->db->where('rule_Id',$ruleId)->get('userdeadlines')->result();
                $userID = $this->session->userdata('userId');
                foreach ($ruleData['rule'] as $rule) {
                    $this->db->insert('userrules',['title'=>$rule->title,'userID'=>$userID,'description'=>$rule->description]);
                    $last_id = $this->db->insert_id();
                }//endif

                foreach ($ruleData['deadlines'] as $deadline) {
                    $this->db->insert('userdeadlines',['title'=>$deadline->title,'description'=>$deadline->description,
                        'deadline_days'=>$deadline->deadline_days,'day_type'=>$deadline->day_type,
                        'rule_Id'=>$last_id]);
                }//endif
                return true;
            }


            function importRule($ruleId){
                $existingRuleId = $this->db->where('ID',$ruleId)->get('userrules')->row('ID');
               // if($existingRuleId != $ruleId){

                $ruleData['rule'] = $this->db->where('ID',$ruleId)->get('rules')->result();
                $ruleData['deadlines'] = $this->db->where('rule_Id',$ruleId)->get('deadlines')->result();

                $userID = $this->session->userdata('userId');
                foreach ($ruleData['rule'] as $rule) {
                    $this->db->insert('userrules',['userID'=>$userID,
                            'title'=>$rule->title,'description'=>$rule->description,'rule_id'=>$ruleId]);
                    $last_id = $this->db->insert_id();
                }//endif

                foreach ($ruleData['deadlines'] as $deadline) {
                    $this->db->insert('userdeadlines',['title'=>$deadline->title,'description'=>$deadline->description,
                        'deadline_days'=>$deadline->deadline_days,'day_type'=>$deadline->day_type,
                        'rule_Id'=>$last_id]);
                }//endif
                    return true;
               // }
                $this->session->set_flashdata("error", "Rule already Exist in Saved Rules");
                return false;
            }

            function getUserRules(){
                $userID = $this->session->userdata('userId');
                return $this->db->where('userID',$userID)->get('userrules')->result();
            }

            function getDeadlines($ruleId){
                return $this->db->where(['rule_id'=>$ruleId])->get('userdeadlines')->result();
            }

            function editUserDeadline($deadlineUpdatedData){
            return $this->db->where('ID',$deadlineUpdatedData['deadlineId'])
            ->update('userdeadlines'
                ,['title'=>$deadlineUpdatedData['deadlineUpdatedTitle']
                ,'description'=>$deadlineUpdatedData['deadlineDesc']
                ,'deadline_days'=>$deadlineUpdatedData['deadlineUpdatedDays']
                ,'day_type'=>$deadlineUpdatedData['dayUpdatedType']]);
            }
            
            function addUserDeadline($deadlineData){
                return $this->db->insert('userdeadlines',['title'=>$deadlineData['deadlineTitle'],'description'=>$deadlineData['deadlineDescription'], 'deadline_days'=>$deadlineData['deadLineDays'],'day_type'=>$deadlineData['dayType'],'rule_Id'=>$deadlineData['ruleId']]);
            }

            function deleteUserDeadline($deadlineId){
                return $this->db->delete('userdeadlines',['ID'=>$deadlineId]);
            }

            function addHolidays($holidayData, $userId){
                 return $this->db->insert('userholidays',['userId'=>$userId,'title'=>$holidayData['holidayTitle'], 'date'=>$holidayData['holidayDate']]);
            }

            function deleteHoliday($holidayData, $userId){
                  return $this->db->delete('userholidays',['ID'=>$holidayData, 'userId'=> $userId]);
            }

            function getUserHolidays($userId){

                $this->db->order_by("date", "asc");
                return $this->db->where('userId',$userId)->get('userholidays')->result();
            }

    }
?>