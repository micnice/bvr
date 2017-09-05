<?php
$checkbvr = substr($nationalid, 0, 3);
                if((strcmp($checkbvr,'BVR')==0 && strlen($nationalid)==10)||strlen($nationalid)==11||strlen($nationalid)==12){
                }
                else{
                    $strSQL="select coalesce(max(trim(substr(nationalid,4))::int),0) from beneficiarymaster where nationalid like 'BVR%' and nationalid not like '%NZ%' and length(trim(substr(nationalid,4)))<8";
                    $result = pg_exec($conn, $strSQL);
                    $row = pg_fetch_row($result);
                    
                    $bvrnumber = $row[0];
                    if($bvrnumber < 1000){
                        $bvrnumber = 1000;
                    }
                    if($bvrnumber >= 1000){
                        $bvrnumber = $bvrnumber+1;
                        $nationalid = 'BVR'.str_pad($bvrnumber, 7, "0", STR_PAD_LEFT);
                    }
                }
?>