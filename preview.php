<?php
///usr/bin/php /data/www/preview/preview.php  https://www.example.com/pic.jpg

ini_set('memory_limit','32M');

$options =array 
(  'width'=> 640,
  'height'=> 480,
  'quality'=> 90
);

$dir = 'upload/';
$url = $argv[1];
$path_parts = pathinfo($url);
$ext = strtolower($path_parts['extension']);
$filename = strtolower($path_parts['filename']);



$thumbext = in_array($ext, array('jpg', 'png', 'gif'))? $ext : 'png';
$out = $dir."thumb".substr(md5(rand()),0,10).'.'.$thumbext;

echo "file: $url, ext: $ext, out:$out ";


$filetype = 'other';
$filecontent = file_get_contents('/data/www/preview/db.json');
$db = json_decode($filecontent);
foreach($db as $k=>$t)
{
	if(property_exists($t, 'extensions'))
	{
		foreach($t->extensions as $e)
		{
			if($e == $ext)
			{
				$l = explode('/',  $k);
				if($l[0] == 'image')
				{
					$filetype = 'image';
				}
				else if($l[0] == 'video')
				{
					$filetype = 'video';
				}
				else
				{
					$filetype = 'other';
				}
		
			}
		}
	}
}

if($ext == 'pdf')
{
	$filetype = 'image';
}

echo "filetype: $filetype ";


$tmp = '';
$tmpurl = '';


if(substr($url, 0, 4) == 'http')
{
	$tmpurl = $dir."url".substr(md5(rand()),0,10).'.'.$ext;
	$ch = curl_init($url);
	$fp = fopen($tmpurl, "w");
	 
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	 
	curl_exec($ch);
	curl_close($ch);
	 
	fclose($fp);

	$url = $tmpurl;
}


if(!file_exists($url))
{
        echo "file does not exist $url \n";
        exit;
}

if($filetype == 'video')
{
	echo "process video \n";
	$cmd = "ffmpeg -y -i $url -vf thumbnail,scale=".$options['width'].':'.$options['height']. " -frames:v 1 ". $out;
	echo "$cmd \n";
	shell_exec($cmd);
}


if($filetype == 'other')
{
        echo "process other \n";
	putenv('HOME=/tmp');
	putenv('PATH=/usr/local/bin:/bin:/usr/bin:/usr/local/sbin:/usr/sbin:/sbin');
	$tmp = $dir."tmp".substr(md5(rand()),0,10).'.pdf';
	$cmd = "unoconv -e PagRange=1 -o $tmp $url";
	echo "$cmd \n";
	shell_exec($cmd);
	$url = $tmp;
	$filetype = 'image';	
}

if($filetype == 'image' && file_exists($url))
{
	echo "process image \n";
	$cmd = "convert -quality ".$options['quality']." -resize ".$options['width'].'x'.$options['height']. ' '. $url.'[0]'. ' '.$out;
	echo "$cmd \n";
	shell_exec($cmd);
}


if(file_exists($tmp))
{
	unlink($tmp);
}

if(file_exists($tmpurl))
{
        unlink($tmpurl);
}
