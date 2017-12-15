# yowfung/officetopdf

​	This is a PHP Laravel library, which uses LibreOffice built-in command to convert Office documents (such as doc, docx, xls, xlsx, ppt, pptx, wps, dwg and so on) to PDF files.

​	这是一个PHP Laravel库，它使用LibreOffice内置命令将Office文档(如doc、docx、xls、xlsx、ppt、pptx、wps、dwg等)转换为PDF文件。


## Installation

​	使用Composer安装，在终端上运行命令：`composer require yowfung/officetopdf`。或在`composer.json`中添加以下代码：

```json
{
    "require": {
        "yowfung/officetopdf": "^1.0"
    }
}
```

## Configure

​	本库利用LibreOffice内置的命令实现格式转换，因此在使用本库前必须保证服务器环境为Linux系统，且已配置Java环境，并安装LibreOffice软件。

- 配置Java环境：可直接运行本库自带的Java环境安装配置脚本：

```shell
./src/build-java-environment.sh
```

- 安装LibreOffice：可直接运行本库自带的LibreOffice安装脚本：

```shell
./src/install-libreoffice.sh
```


## Examples

以下提供简单的使用案例：

```php
<?php
use YowFung\OfficeToPdf\OfficeToPdf;

class Controller
{
  	public function Example() 
    {
  		$outdir  = __DIR__.'/../resource/pdfs/';	 //输出文件夹
  		$filedir = __DIR__.'/../resource/docs/';
  		$filenames = scandir($filedir);			 //待转换文件
  	
  		$office = new OfficeToPdf($filenames, $outdir, true);
  		$success_row = $office->convertToPdf();		 //执行转换操作
  	
  		echo '成功转换'.$success_row.'个文件。';
    }
}
```

你也可以单独设置输出文件夹路径：

```php
$office = new OfficeToPdf();
$office->setOutputDir('directory path...');
```

还可以单独添加文件（单个，多个，或重置）：

```php
$office = new OfficeToPdf();

//重置源文件路径列表
$office->setFileArray(
	'filename1',
  	'filename2',
  	'...'
);

//向原有文件路径列表中添加单个文件
$office->addFile('filename');

//向原有文件路径列表中添加多个文件
$offcie->addToFileArray(
	'filename1',
  	'filename2',
  	'...'
);
```

在实例化对象或添加文件时会首先判断文件格式是否被支持，但如果你想单独判断文件格式，可使用`checkFormat()`方法：

```php
$office = new OfficeToPdf();
$filename = 'xxxx.doc';
if(!$office->checkFormat($filename))
  	echo 'File format is not be supported';
```

## Copyright

​	本库由YowFung开发并提供更新，程序开源。

​	联系邮箱：yowfung@outlook.com
