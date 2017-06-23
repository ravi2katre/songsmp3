<?php

/**
 * Emails Model
 *
 * @package		Code Igniter - Emails Model
 * @author		Alistair Shaw (alistairshaw@gmail.com)
 * @link		https://github.com/alistairshaw/codeigniter-emails-model
 * @version		1.1
 */

class Emails_model extends MY_Model {

	var $protocol = 'sendmail'; //smtp, mail or sendmail

	var $smtp_host = '';
	var $smtp_user = '';
	var $smtp_pass = '';
	var $smtp_port = '';

	var $sendmail_path = '/usr/sbin/sendmail';

	var $mailfrom = 'rkatre@tiuconsulting.com';
	var $mailfromname = 'Ravi Admin';

	var $autocc = '';

	var $default_subject = 'default subject ';

	var $defaultmailto = 'rkatre@tiuconsulting.com';

	/*
	 * send_email
	 *
	 * Sends an email using optional templates or basic template with list of variables
	 *
	 * @param		string		$email_address		Email address to send the message to. If left black $this->defaultmailto will be used.
	 * @param		string		$message_content	Content of email
	 * @param		array		$message_vars		Array of variables to be listed in the email (particularly useful for contact forms)
	 * @param		string		$message_subject	Subject line for the email
	 * @param		string		$message_view		The Code Igniter view to be used for a template. If left blank a basic email will be sent.
	 * @param		string		$from				Email address the message should be from. If left blank the $this->mailfrom default will be used
	 * @param		string		$fromname			Name the message should be from. If left blank the $this->mailfromname default will be used
	 *
	 * @return		bool		TRUE if mail sent | FALSE if failed
	*/
    function send_email($email_address = '', $email_bcc = '', $message_content = '', $message_vars = array(), $message_subject = '', $message_view = '', $from = '', $fromname = '',$file='')
    {

	$log = "************Start********** \n ";
	$log .= "email_address=".$email_address." \n ";
	$log .= "email_bcc=".$email_bcc." \n ";
	//$log .= "message_content=".$message_content." \n ";
	//$log .= "message_vars=".print_r($message_vars,true)." \n ";
	$log .= "message_subject=".$message_subject." \n ";
	$log .= "message_view=".$message_view." \n ";
	$log .= "from=".$from." \n ";
	$log .= "fromname=".$fromname." \n ";
	$log .= "file=".$file." \n ";
	

        if ($email_address == '') $email_address = $this->defaultmailto;

        $this->load->library('email');

        //Set up protocol and login details if SMTP
        $config['protocol'] = $this->protocol;
        if ($this->protocol == 'smtp')
        {
            $config['smtp_host'] = $this->smtp_host;
            $config['smtp_user'] = $this->smtp_user;
            $config['smtp_pass'] = $this->smtp_pass;
        }

        if ($this->protocol == 'sendmail')
        {
            $config['mailpath'] = $this->sendmail_path;
        }
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";

        //Initialise CI mail
        $this->email->initialize($config);

        //Setup from details
        if ($from == '') $from = $this->mailfrom;
        if ($fromname == '') $fromname = $this->mailfromname;
        $this->email->from($from, $fromname);

        //Setup address details and CC
        $this->email->to($email_address);
        if ($this->autocc !== '') $this->email->bcc($this->autocc);

        if($email_bcc){$this->email->bcc($email_bcc); }

        //Subject line
        $subject = ($message_subject == '') ? $this->default_subject : $message_subject;
        $this->email->subject($subject);

        //If a view template is set then load it, otherwise just send message content and variables
        $message = $this->load->view('email/_header', '', true);

        if ($message_view == '')
        {

            $message .= $message_content;
            /*foreach ($message_vars as $key=>$field)
            {
               $message .= '<p><strong>' . $key . '</strong><br />' . $field . '</p>';
            }*/

        }
        else
        {

            //In the view template you can put the keys in as [[KEYNAME]] to replace them with items from the array
            $message .= $this->load->view($message_view, '', true);
            $message = str_replace('[[CONTENT]]', $message_content, $message);
            foreach ($message_vars as $key=>$field)
            {
                $message = str_replace('[[' . $key . ']]', $field, $message);
            }

        }

        $message .= $this->load->view('email/_footer', '', true);

        $this->email->message($message);
        if(!empty($file)){
            $attechment_result = $this->email->attach($file);
			$log .= "attechment_result=".$attechment_result." \n ";
        }
		
		$result = $this->email->send();
		
		$log .= "result=".$result." \n ";
		$log .= "************end********** \n ";
		logit($log, "send_email");
        //aaand send the email!
        return $result;

    }

    function send_email_from_db($id,$message_vars){
        $rows = $this->find($id);
        $data = $rows->result_array();

        $data  = $this->get_row_content_var_replace($data[0],$message_vars);
        $file = (isset($message_vars["attach"]))?$message_vars["attach"]:'';
        return $this->send_email(
            $data['mail_to'],
            $data['mail_bcc'],
            $data['content'],
            $message_vars,
            $data['subject'],
            null,
            $data['mail_from'],
            $data['mail_from_name'],
            $file);

         
    }

    public function find($id){
        $row = $this->db->where('id',$id)->limit(1)->get('emails');
        return $row;
    }

    function get_row_content_var_replace($data,$message_vars){

        foreach ($message_vars as $key=>$field){
            $data['subject'] =  str_replace('[[' . $key . ']]', $field, $data['subject']);
            $data['mail_to'] =  str_replace('[[' . $key . ']]', $field, $data['mail_to']);
            $data['mail_from'] =  str_replace('[[' . $key . ']]', $field, $data['mail_from']);
            $data['mail_from_name'] =  str_replace('[[' . $key . ']]', $field, $data['mail_from_name']);
            $data['content'] =  str_replace('[[' . $key . ']]', $field, $data['content']);
			$data['content'] =  str_replace('&nbsp;', " ", $data['content']);
        }

        return $data;
    }
	
/*public function listing($query_array, $limit, $offset, $sort_by = '', $sort_order = 'desc') {
//cidb($query_array);
        $condition = '';
        if(array_key_exists('emailnotificationtypeids',$query_array['filter'])){
            $ids = implode(',',$query_array['filter']['emailnotificationtypeids']);
            $condition.=" enot.enot_id IN($ids) AND";
        }

        $condition.= ((is_numeric($query_array['filter']['assigned_to'])) && !empty($condition))? " enot.assign_user_id =".$query_array['filter']['assigned_to']." AND":'';
        $condition.= (!empty($query_array['filter']['time_period']) && !empty($condition) && (!is_numeric ($query_array['filter']['time_period'])) )? " enot.en_date > DATE_SUB(NOW(), INTERVAL {$query_array['filter']['time_period']} )  AND":'';
       // $condition.= (($query_array['filter']['archived'] == 0 || $query_array['filter']['archived'] =='')  && !empty($condition))?' '.(int)$query_array['user_id']." NOT IN(enot.archived_user_ids) AND":'';
        
        $condition.= (($query_array['filter']['archived'] == 0 || $query_array['filter']['archived'] =='')  && !empty($condition))?" enot.archived_user_ids NOT LIKE '%".(int)$query_array['user_id']."%' ":'';
        
        
        $condition = rtrim($condition,' AND');
        $condition = (!empty($condition))?' WHERE '.$condition:' where 0 ';

        $sql = "SELECT 
		SQL_CALC_FOUND_ROWS
		enot.*,
        enotty.enot_type,
        ostatus.order_status_value,
        ordsubord.complete_sub_order_id,
        ordsubord.sub_order_id,
        ordsubord.order_id,
        ordsubord.order_name,
        c.customer_id,
        c.customer_country,
        c.customer_name,
        c.company_name
FROM emailnotifications enot 
        LEFT JOIN customers c on c.user_id = enot.user_id
        LEFT JOIN order_statuses ostatus on ostatus.order_status_id = enot.order_status_id
        LEFT JOIN emailnotification_types enotty on enotty.enot_id = enot.enot_id
        LEFT JOIN orders_suborder ordsubord on ordsubord.order_id = enot.order_id and ordsubord.sub_order_id = enot.sub_order_id 
        {$condition} order by enot.en_date desc
        ";
        $limit = " limit ".$offset.",".$limit;
        $sql = $sql.$limit;

        $ret['rows'] = $this->db->query($sql)->result();
//echo $sql;
        $result = $this->db->query("SELECT FOUND_ROWS() as totalItems")->row_array();

        $ret['num_rows'] = $result['totalItems'];


            return $ret;

    }*/

}
?>