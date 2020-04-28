<?php

	class AdminModel extends CI_Model
	{

		function isValidate($adminemail,$password)
		{
				$query = $this->db->where(['adminemail'=>$adminemail])->get('admin');
				if($query->num_rows())
				{
					$dbadminPassword = $query->row()->adminpassword;
					if(md5($password) == $dbadminPassword){

						return $query->row()->ID;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
		}

		function addCategory($categoryName){
			return $this->db->insert('documentcategories',['Categoryname'=>$categoryName]);
		}

		function deleteCategory($categoryId){
			$documentsName = $this->db->select('DocumentName')->where(['CategoryId'=>$categoryId])->get('documentnames')->result();
			$filePath = "uploads/";
			if($this->db->delete('documentnames',['CategoryId'=>$categoryId]) && $this->db->delete('documentcategories',['CategoryId'=>$categoryId])){

				foreach ($documentsName as $name) {
					unlink($filePath.$name->DocumentName.".docx");
				}
				return true;
			}
		}


		function updateCategoryName($CategoryId,$editCategory){
			return $this->db->where('CategoryId',$CategoryId)
						->update('documentcategories',['Categoryname'=>$editCategory]);
		}

		function addDocuments($categoryId,$image_path,$image_name){
			return $this->db->insert('documentnames',['	CategoryId'=>$categoryId,'DocumentPath'=>$image_path,'DocumentName'=>$image_name]);

		}

		function getDocumentsList($CategoryId){
		return $this->db->where(['CategoryId'=>$CategoryId])->get('documentnames')->result();
		}

		function deleteDocuments($documentId){
			return $this->db->delete('documentnames',['ID'=>$documentId]);
		}


		function updateDocumentName($documentId,$updateDocumentName, $newPath, $docRevisedDate){
			return $this->db->where('ID',$documentId)
						->update('documentnames',['DocumentName'=>$updateDocumentName, 'DocumentPath'=>$newPath, 'customDate'=>$docRevisedDate]);
		}

		function addField($labelName,$labelText){
			return $this->db->insert('dynamicfields',['FieldLabel'=>$labelName, 'FieldName'=>$labelText]);
		}


		function updateField($labelName,$labelText,$fieldId){
			return $this->db->where('ID',$fieldId)
							 ->update('dynamicfields',['FieldLabel'=>$labelName, 'FieldName'=>$labelText]);
		}

		function checkAdmin($adminemail){
			$query =  $this->db->where('adminemail',$adminemail)->get('admins');
			if($query->num_rows())
				{
					return $query->row()->adminpassword;
				}
				else
				{
					return false;
				}
		}

		function fieldList(){
			return $this->db->get('dynamicfields')->result();
		}

		function deleteField($fieldId){
			return $this->db->delete('dynamicfields',['ID'=>$fieldId]);
		}

		////////////////////////////////////////////////////////////// Law Calendar
		function getUsers(){
			return $this->db->get('users')->result();
		}

		function deleteUser($userId){
			return $this->db->delete('users',['id'=>$userId]);
		}

		function ifUserExist($userId){
			return $this->db->where(['id'=>$userId])->get('users')->row();
		}

		function addRule($ruleData){
			return $this->db->insert('rules',['title'=>$ruleData['ruleTitle'],'description'=>$ruleData['ruleDescription']]);
		}

		function addDeadline($deadlineData){
			return $this->db->insert('deadlines',['title'=>$deadlineData['deadlineTitle'],'description'=>$deadlineData['deadlineDescription'], 'deadline_days'=>$deadlineData['deadLineDays'],'day_type'=>$deadlineData['dayType'],'rule_Id'=>$deadlineData['ruleId']]);
		}

		function getRules(){
			return $this->db->get('rules')->result();
		}


        public function getRulesData(){
	        $parent = $this->db->get('rules');
	        $categories = $parent->result();
	        $i=0;
	        foreach($categories as $p_cat){
	            $categories[$i]->sub = $this->ruleDeadlines($p_cat->ID);
	            $i++;
	        }
	        return $categories;
   		 }

	    public function ruleDeadlines($id){
	        $child = $this->db->where('rule_id', $id)->get('deadlines');
	        $categories = $child->result();

	        //This section Comment by Anshul after seeing SQL Memory Size error 
	        // $i=0;
	        // foreach($categories as $p_cat){
	        //     $categories[$i]->sub = $this->ruleDeadlines($p_cat->ID);
	        //     $i++;
	        // }

	        return $categories;       
	    }

		function getDeadlines($ruleId){
			return $this->db->where(['rule_id'=>$ruleId])->get('deadlines')->result();
		}

		function deleteRule($ruleId){

			if($this->db->delete('deadlines',['rule_Id'=>$ruleId]) && $this->db->delete('rules',['ID'=>$ruleId])){
				return true;
			}
		}

		function dublicateRule($ruleId){

                $ruleData['rule'] = $this->db->where('ID',$ruleId)->get('rules')->result();
                $ruleData['deadlines'] = $this->db->where('rule_Id',$ruleId)->get('deadlines')->result();

                foreach ($ruleData['rule'] as $rule) {
                    $this->db->insert('rules',['title'=>$rule->title,'description'=>$rule->description]);
                    $last_id = $this->db->insert_id();
                }//endif

                foreach ($ruleData['deadlines'] as $deadline) {
                    $this->db->insert('deadlines',['title'=>$deadline->title,'description'=>$deadline->description,
                        'deadline_days'=>$deadline->deadline_days,'day_type'=>$deadline->day_type,
                        'rule_Id'=>$last_id]);
                }//endif
                return true;
		}

		function deleteDeadline($deadlineId){
			return $this->db->delete('deadlines',['ID'=>$deadlineId]);
		}

		function editRule($ruleUpdatedData){
			return $this->db->where('ID',$ruleUpdatedData['ruleId'])
			->update('rules'
				,['title'=>$ruleUpdatedData['ruleUpdatedTitle']
				,'description'=>$ruleUpdatedData['ruleDesc']]);
		}

		function editDeadline($deadlineUpdatedData){
			return $this->db->where('ID',$deadlineUpdatedData['deadlineId'])
			->update('deadlines'
				,['title'=>$deadlineUpdatedData['deadlineUpdatedTitle']
				,'description'=>$deadlineUpdatedData['deadlineDesc']
				,'deadline_days'=>$deadlineUpdatedData['deadlineUpdatedDays']
				,'day_type'=>$deadlineUpdatedData['dayUpdatedType']]);
		}

		function changeAdminCredentials($adminId,$adminName,$adminPassword){
			return $this->db->where('ID',$adminId)
							 ->update('admin',['adminemail'=>$adminName, 'adminpassword'=>md5($adminPassword)]);
		}


            //Password Recovery email
            function sendRecoverEmail($userEmail){
                 $query = $this->db->where(['adminemail'=>$userEmail])->get('admin');
                 if($query->num_rows())
                 {
                    $recoveryKey = (md5(time()));
                    $result = $this->db->where(['adminemail'=>$userEmail])->update('admin',['verification_key'=>$recoveryKey]);
                    if($result){

                    $url = base_url('admin/adminLogin/resetPassword/'.$userEmail.'/'.$recoveryKey);

                    $this->load->library('email');
					
					$config['protocol']    = 'smtpout.secureserver.net';
					$config['smtp_host']    = 'localhost';
					$config['smtp_port']    = '25';
					$config['smtp_timeout'] = '600';

					$config['smtp_user']    = 'info@kennerlawgroup.com';    //Important
					$config['smtp_pass']    = 'Maria!$%';  //Important


					$config['charset']    = 'utf-8';
					$config['newline']    = "\r\n";
					$config['mailtype'] = 'html'; // or html
					$config['validation'] = TRUE; // bool whether to validate email or not 

					$this->email->initialize($config);
					$this->email->set_mailtype("html"); 
					$this->email->set_newline("\r\n");

                    $this->email->from('info@kennerlawgroup.com', 'Set Deadlines');
                    $this->email->to($userEmail);

                    $this->email->subject('Password Recovery for Law Calendar');
                    $this->email->message("click here for new password ".$url);
                    $this->email->send();

                    return true;
                    }
                 }
                 else{
                    $this->session->set_flashdata('error',"You are not a registered user");
                    return redirect('recoverAdminPassword');
                 }
            }


            function recoveryKey($userEmail,$recoveryKey){
                $query = $this->db->where(['adminemail'=>$userEmail])->get('admin');
                if($query->num_rows()){

                    //Retriving Key of email
                    $DBkey = $query->row()->verification_key;
                    if($recoveryKey == $DBkey){
                            $this->session->set_userdata('adminEmail',$userEmail);
                            $this->session->set_userdata('recoveryKey',$recoveryKey);
                            return true;
                        }
                        else{
                            //key does not matched
                            $this->session->set_flashdata('error','Link expired');
                            return redirect('adminLogin');
                        }
                    }
                    else{
                            //key and email does not matched
                            $this->session->set_flashdata('error','Link expired');
                            return redirect('adminLogin');
                    }
            }

             function setNewPassword($newPassword){
                $userEmail = $this->session->userdata('adminEmail');
                $recoveryKey = $this->session->userdata('recoveryKey');

                $result = $this->db->where(['adminemail'=>$userEmail, 'verification_key'=>$recoveryKey])->update('admin',['adminpassword'=>md5($newPassword),'verification_key'=>0]);
                if($result){
                    $this->session->unset_userdata('adminEmail');
                    $this->session->unset_userdata('recoveryKey');
                    return true;
                }
            }


	}
?>