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
                            $entry = $bed_inventory->fetch_by_bed_inventory_id((int)$_POST['bed_inventory_id']);
                            if("" != $entry->bed_inventory_id)
                            {
                                echo "The specified Record was found.";
                                var_dump($entry);
                                $bed_inventory_arr                   = $_POST;
                                $profile_id                          = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                                $bed_inventory_arr['int_profile_id'] = $profile_id;
                                $bed_inventory_arr['date_created']   = get_current_date();
                                $bed_inventory_arr['date_modified']  = get_current_date();
                                $bed_inventory->set_bed_inventory_vars($bed_inventory_arr);
                                if($bed_inventory->update_bed_inventory())
                                {
                                    echo "The specified Record has been updated successfully.";
                                }else{
                                    echo "The specified Record has not been updated.";
                                }
                            }else{
                                echo "The specified Record was not found.";
                            }
                            var_dump($bed_inventory_arr);
                            var_dump($bed_inventory);
                            
                        }
?>