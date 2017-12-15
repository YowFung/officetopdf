<?php
use YowFung\OfficeToPdf\OfficeToPdf;

class Controller
{
  	public function Example() 
    {
  		$outdir  = __DIR__.'/../resource/pdfs/';	 //输出文件夹
  		$filedir = __DIR__.'/../resource/docs/';
  		$filenames = scandir($filedir);				     //待转换文件
  	
  		$office = new OfficeToPdf($filenames, $outdir, true);
  		$success_row = $office->convertToPdf();		 //执行转换操作
  	
  		echo '成功转换'.$success_row.'个文件。';
    }
}