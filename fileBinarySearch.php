<?php
   
    function binary_search($afile, $key){

        $file = new SplFileObject($afile);//exception

        $data = $file->fread(4096);
        preg_match('/(.+)\t(.+)/',$data,$cur_line);
        if(strnatcmp($cur_line[1],$key) == 0) return $cur_line[2];



        $file->fseek(0,SEEK_END);

        $low = 0;
        $high = $file->ftell();

        while($low <= $high){
            
            $mid = floor(($low+$high)/2);
            
            $file->fseek($mid);
            $data = $file->fread(4096);
            preg_match('/\n(.+)\t(.+)/',$data,$cur_line);
            $cur_line_key = $cur_line[1];
            $cur_line_value=$cur_line[2];
            $str_comp = strnatcmp($cur_line_key,$key);

            if($str_comp < 0){
                $low=$mid+1;
            } elseif($str_comp > 0){
                $high=$mid-1;
            }else{
                return $cur_line_value;
            }
        }
        return "undef";
    }
