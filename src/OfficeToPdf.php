<?php
/**
 * @summary     Office文档转PDF文档
 * @copyright   yowfung
 * @license     http://www.yowfung.cn
 * @version     2017.12.15 v1.1.0
 * @createdby   PhpStorm.
 */

namespace YowFung\OfficeToPdf;


class OfficeToPdf
{
    /**
     * @Var array   待转换的Office源文件列表
     */
    private $_source_files = array();

    /**
     * @var string  输出的文件路径
     */
    private $_output_dir;

    /**
     * @var bool    是否在输出文件名前面添加时间戳
     */
    private $_output_add_time;

    /**
     * @var string  支持的文件格式
     */
    private $_file_formats = "dwg|doc|docx|wps|pdf|xlsx|xls|ppt|pptx";


    /**
     * OfficeToPdf constructor.
     * @param array $filesname      待转换的Office源文件列表
     * @param string $out_dir       输出文件夹路径
     * @param bool $add_time        是否在输出文件名前添加时间戳
     */
    public function __construct($filesname = array(), $out_dir = null, $add_time = true)
    {
        $this->checkEnvironment();
        if($this->_check_status == 0) {
            $this->setFileArray($filesname);
            $this->setOutputDir($out_dir, $add_time);
        }
    }
    

    /**
     * 检查是否为Linux服务器，是否有java环境，且是否安装LibreOffice
     * @return bool                 环境是否正常
     */
    public function checkEnvironment()
    {
        //检查是否为Linux服务器
        if(PHP_OS != 'Linux')
            throw new Exception('The program can only run on Linux server.');


        //检查是否有Java环境
        $output = passthru('java -version && echo java');
        if($output != 'java')
            throw new Exception('There is no Java environment.');

        //检查是否安装有LibreOffice
        $output = passthru('libreoffice --version && echo libreoffice');
        if($output != 'libreoffice')
            throw new Exception('LibreOffice is not be installed.');

        return true;
    }


    /**
     * 检查文件格式是否被支持
     * @param $filename             被检查的文件名
     * @return bool                 检查结果
     */
    public function checkFileFormat($filename)
    {
        $format_right   = false;
        $file_info      = pathinfo($filename);
        $file_format    = $file_info['extension'];
        $format_support = mb_split($this->_file_formats, '|');
        foreach ($format_support as $val) {
            if($val == $file_format)
                $format_right = true;
        }

        return $format_right;
    }


    /**
     * 添加单个Office源文件
     * @param $file_path            文件路径
     * @return bool                 是否添加成功
     */
    public function addFile($file_path)
    {
        if(!file_exists($file_path))
            throw new Exception('File "'.$file_path.'" is not existent.');
        else if(!$this->checkFileFormat($file_path)) {
            $format = pathinfo($file_path)['extension'];
            throw new Exception('File Format "'.$format.'" is not be supported.');
        }
        else
            $this->_source_files[] = $file_path;

        return true;
    }


    /**
     * 添加多个Office源文件
     * @param array $file_paths     包含多个文件路径的数组
     * @return bool                 是否添加成功
     */
    public function addToFileArray($file_paths = array())
    {
        if(count($file_paths) == 0)
            return false;

        $success_count = 0;
        foreach ($file_paths as $val) {
            if(!file_exists($val))
                throw new Exception('File "'.$val.'" is not existent.');
            else if(!$this->checkFileFormat($val)) {
                $format = pathinfo($val)['extension'];
                throw new Exception('File Format "'.$format.'" is not be supported.');
            }
            else {
                $this->_source_files[] = $val;
                $success_count++;
            }
        }

        if($success_count != 0)
            return true;
        else
            return false;
    }


    /**
     * 设置Office源文件列表
     * @param array $file_paths     包含多个文件路径的数组
     * @return bool                 是否设置成功
     */
    public function setFileArray($file_paths = array())
    {
        $this->_source_files = array();
        if(count($file_paths) == 0)
            return false;

        foreach ($file_paths as $val) {
            if(!file_exists($val))
                throw new Exception('File "' . $val . '" is not existent.');
            else if(!$this->checkFileFormat($val)) {
                $format = pathinfo($val)['extension'];
                throw new Exception('File Format "'.$format.'" is not be supported.');
            }
            else
                $this->_source_files[] = $val;
        }

        if(count($this->_source_files) != 0)
            return true;
        else
            return false;
    }


    /**
     * 设置输出文件名
     * @param string $dir           输出文件夹路径
     * @param bool                  是否在输出文件名前面添加时间戳
     * @return bool                 是否设置成功
     */
    public function setOutputDir($dir = null, $add_time = true)
    {
        if(empty($dir) || $dir == 'default') {
            $this->_output_dir = 'default';
            return true;
        }

        if(!is_dir($dir))
            throw new Exception('Directory "'.$dir.'" is not existent or created.');

        $this->_output_dir = $dir;
        $this->_output_add_time = $add_time;
        return true;
    }


    /**
     * 执行Office转换PDF操作
     * @return int                  成功转换的文件数
     */
    public function convertToPdf()
    {
        $success_count = 0;

        foreach($this->_source_files as $val) {
            if(!file_exists($val))
                throw new Exception('File "'.$val.'" is not existent.');

            if($this->_output_dir == 'default') {
                $file_path = pathinfo($val)['filename'];
                $out_filename = $file_path.'/';
            }
            else
                $out_filename = $this->_output_dir;

            if(!is_dir($out_filename))
                throw new Exception('Directory "'.$out_filename.'" is not existent or created.');

            //文件名添加时间戳
            if($this->_output_add_time)
                $out_filename .= time();

            $out_filename .= $val.'.pdf';

            //执行文件格式转换
            try {
                $command = 'libreoffice --invisible --convert-to pdf '.$val.' '.$out_filename;
                $cmd_msg = passthru($command);
                //
                $success_count++;
            } catch (Exception $e) {
                return 0;
            }
        }

        return $success_count;
    }
}