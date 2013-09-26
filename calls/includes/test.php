<?php
    include_once('init.php');
    include_once('functions.php');
    
    // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                // Profile instance
                $profile = new Int_Profile();
                // Bed_inventory instance
                $bed_inventory = new Bed_inventory();
                
                if($bed_inventory instanceof Bed_inventory)
                { 
                    $bed_inventory_arr                   = $_POST;
                    $profile_id                          = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                    $bed_inventory_arr['int_profile_id'] = $profile_id;
                    $bed_inventory_arr['date_created']   = get_current_date();
                    $bed_inventory_arr['date_modified']  = get_current_date();
                    $bed_inventory->set_bed_inventory_vars($bed_inventory_arr);
                    if($bed_inventory->insert_bed_inventory())
                    {
                        $json['status'] = 'true'; 
                        echo "The specified Bed(s) has been created successfully.";
                    }else{
                        echo  'false';
                    }
                    var_dump($bed_inventory_arr);
                    var_dump($bed_inventory);
                }
?>