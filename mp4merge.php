#!/usr/bin/php -q
<?php
/*
 * Unite mp4 files into one
 * php mp4merge.php movie_1.mp4 movie_2.mp4 ... movie_n.mp4 movie_final
 * rm -rf *.ts
 *
 * https://github.com/bulutyazilim/mp4merge
 * 
 */

array_shift($argv);

if (count($argv) == 0) {
        $argv[0] = "php://stdin";
}
$size = count($argv);
echo "$size \n";
$i = 1;
$files = [];
foreach ($argv as $file) {
    echo $file."\n";
       
    if($size == $i){

		$files = implode('|', $files);

		$final_command = 'ffmpeg -i "concat:'.$files.'"  -c copy -bsf:a aac_adtstoasc '.$file.'.mp4';

		echo $final_command."\n";

		exec($final_command);

    }else{

		$command = 'ffmpeg -i '.$file.'  -c copy -bsf:v h264_mp4toannexb -f mpegts '.$file.'_'.$i.'.ts';

		array_push($files, $file.'_'.$i.'.ts');

		echo $command."\n";
        exec($command);
    }
    $i++;
}

