<?php
	include("../includes/admin-config.php");

        $to = $_REQUEST['to'];
        $from = $_REQUEST['from'];

        $from_q = $db->query('select * from file where cid = '.$from );
        $from_qc = $db->query('select * from category where id = '.$from , database::GET_ROW );

        $to_qc = $db->query('select * from category where id = '.$to , database::GET_ROW );


        foreach($from_q as $k => $v)
        {
            if(copy('../../'.$from_qc['folder'].$v['dname'].'.'.$v['ext'], '../../'.$to_qc['folder'].$v['dname'].'.'.$v['ext']))
            {
                unlink('../../'.$from_qc['folder'].$v['dname'].'.'.$v['ext']);
                if(copy('../../'.$from_qc['folder'].'thumb-'.$v['dname'].'.'.$v['ext'], '../../'.$to_qc['folder'].'thumb-'.$v['dname'].'.'.$v['ext']))
                    unlink('../../'.$from_qc['folder'].'thumb-'.$v['dname'].'.'.$v['ext']);
            }
            else
                echo 'file not move';
        }
        
        //update all file category to new
        $db->query('update file set cid = '.$to . ' where cid = '.$from);
        $db->query('update category set totalitem = 0 where id = '.$from);
        $db->query('update category set totalitem = '.count($from_q).' where id = '.$to);

        header('location: index.php?errid=18&pid='.$to);
?>
