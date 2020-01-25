<?php

	class UserModel extends CI_Model
	{
        //User Registration
        function addUser($userData){
            $key = (md5(time()));
                $query = $this->db->insert('users',['fullname'=>$userData['fullName'], 'email'=>$userData['userEmail'],
                    'telephone'=>$userData['telephone'],'password'=>md5($userData['password']),'verificationkey'=>$key]);

                if($query){
                $url = base_url('user/UserController/verifyUser/'.$userData['userEmail'].'/'.$key);

                $this->load->library('email');
                $this->email->from('kbrostechno@gmail.com', 'Anshul');
                $this->email->to($userData['userEmail']);

                $this->email->subject('Verify your Email for Registration');
                $message = '<!DOCTYPE html>
                                <html>
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8/>
                                </head>';
                $message .= '<p>Hello User</p>';
                $message .= '<p>Please verify your email address for Law Calendar by clicking
                            <a href="'.$url.'">here</a></p>';
                $message .= '<p>Thanks</>';
                $this->email->message($message);
                $this->email->send();

                return $query;
                }
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
                    $this->email->from('kbrostechno@gmail.com', 'Anshul');
                    $this->email->to($userEmail);

                    $this->email->subject('Verify your Email for Registration');
                    $this->email->message("click here to verify your email address ".$url);
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

            function getSelectedCases($caseId){
            return $this->db->where(['ID'=>$caseId])->get('cases')->row('title');
            }

            function getSelectedRuleData($ruleId){
                $rules = $this->db->where(['ID'=>$ruleId])->get('rules')->result();
                    $rules[0]->sub = $this->ruleDeadlines($rules[0]->ID);
                  
                return $rules;
            }


            public function ruleDeadlines($id){
                return $this->db->where(['rule_Id'=>$id])->get('deadlines')->result();       
            }

            function saveCase($caseData){
                $userId = $this->session->userData('userId');
                $query = $this->db->insert('savedCases',['userID'=>$userId, 'caseID'=>$caseData['caseId'], 'motionDate'=>$caseData['motionDate']]);

                $caseId = $caseData['caseId'];
                $rules = $caseData['rules'];
                if($query):
                foreach ($rules as $rule) {

                    $this->saveRules($caseId,$rule);
                }
                endif;
                return $query;
            }

            function saveRules($caseId,$rule){
                $query = $this->db->insert('savedrulesforsavedcases',['caseID'=>$caseId, 'ruleId'=>$rule]);
                return $query;
            }

            function userCases(){
                $userId = $this->session->userData('userId');
                $cases = $this->db->where(['userId'=>$userId])->get('savedcases')->result();
                if($cases):
                    $i = 0;
                    foreach ($cases as $case) {
                       $cases[$i]->caseTitle = $this->userCaseDate($case->caseID);
                       $i++;
                    }
                endif;
                return $cases;
            }

            function userCaseDate($caseId){
                $cases = $this->db->where(['ID'=>$caseId])->get('cases')->row('title');
                return $cases;
            }


            function userRules($caseID){
                $userId = $this->session->userData('userId');
                $motionDate = $this->db->where(['userId'=>$userId,'caseID'=>$caseID])
                                                                    ->get('savedcases')->row('motionDate');
                $caseTitle = $this->db->where(['ID'=>$caseID])->get('cases')->row('title');

                $rulesId = $this->db->select('ruleId')->where(['caseID'=>$caseID])
                                                                    ->get('savedrulesforsavedcases')->result();
                $userData['userId'] = $userId;
                $userData['motionDate'] = $motionDate;
                $userData['caseTitle'] = $caseTitle;
              //  $userData['ruleId'] = $rulesId;

                if($rulesId){
                    foreach ($rulesId as $ruleId) {
                        $userData['ruleData'][] = $this->userRulesDate($ruleId->ruleId);
                    }
                }

                return $userData;
            }

            function userRulesDate($ruleId){
                $rules = $this->db->where(['ID'=>$ruleId])->get('rules')->result();                

                foreach ($rules as $rule) {
                    $rules['deadlines'] = $this->userRuleDeadlines($rule->ID);
                }
                return $rules;
            }

            function userRuleDeadlines($ruleId){
                $deadlines = $this->db->where(['rule_Id'=>$ruleId])->get('deadlines')->result();
                return $deadlines;
            }
	}
?>