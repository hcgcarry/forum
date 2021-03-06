<?php 
/////////////////////用來判斷是否符合長短條件之類 and 消毒用
class PostVeridator {

    public function isValidEmail( $email )
    {
        $data_array['email'] = $email;
        $gump = new GUMP();
        $data_array = $gump->sanitize($data_array); 
        $validation_rules_array = array(
            'email'    => 'required|valid_email'
        );
        $gump->validation_rules($validation_rules_array);
        $filter_rules_array = array(
            'email' => 'trim|sanitize_email'
        );
        $gump->filter_rules($filter_rules_array);
        $validated_data = $gump->run($data_array);
        if($validated_data === false) {
            $error = $gump->get_readable_errors(false);
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            foreach( $error as $e) {
                $msg->error($e);
            }
            return false;
        } else {
            return true;
        }
    }
    public function isValidUserName( $username)
    {
        $data_array['username'] = $username;
        $gump = new GUMP();
        $data_array = $gump->sanitize($data_array); 
        $validation_rules_array = array(
          'username'    => 'required|alpha_numeric|max_len,20|min_len,3'
        );
        $gump->validation_rules($validation_rules_array);
        $filter_rules_array = array(
            'username' => 'trim|sanitize_string'
        );
        $gump->filter_rules($filter_rules_array);
        $validated_data = $gump->run($data_array);
        if($validated_data === false) {
            $error = $gump->get_readable_errors(false);
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            foreach( $error as $e) {
                $msg->error($e);
            }
            return false;
        } else {
            return true;
        }
    }
    public function isValidString( $inputString,$validationCondiction='')
    {
        $data_array['inputString'] = $inputString;
        $gump = new GUMP();
        $data_array = $gump->sanitize($data_array); 
        if ($validationCondiction==''){
          $validation_rules_array = array(
          'inputString' => 'required'
          );
        }
        else{
          $validation_rules_array = array(
            'inputString' => 'required|'.$validationCondiction
          );
        
        }
        $gump->validation_rules($validation_rules_array);
        $filter_rules_array = array(
            'inputString' => 'trim|sanitize_string'
        );
        $gump->filter_rules($filter_rules_array);
        $validated_data = $gump->run($data_array);
        if($validated_data === false) {
            $error = $gump->get_readable_errors(false);
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            foreach( $error as $e) {
                $msg->error($e);
            }
            return false;
        } else {
            return true;
        }
    }
    
}
