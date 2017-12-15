# yowfung/officetopdf 版本日志

## 1.0.0

- 特性：

  利用LibreOffice内置格式转换命令进行Office到PDF的文件转换。

- 基本功能：

  1. 检测服务器环境是否为Linux。
  2. 检测服务器是否有JAVA环境。
  3. 检测服务器是否安装有LibreOffice软件。
  4. 添加单个/多个待转换的Office源文件。
  5. 设置输出文件夹路径。
  6. 是否在输出文件名前面添加时间戳。
  7. 利用LibreOffice的内置命令进行格式转换。

- 支持的文件格式：

  常见的Office文件格式，包含dwg/doc/docx/xls/xlsx/ppt/pptx/wps/pdf等。

- 异常处理：

  当环境不适合时（非Linux服务器/未配置Java环境/未安装LibreOffice），当源文件不存在时，当源文件格式不支持时，当输出文件夹路径不存在时，当执行转换命令失败时，均抛出throw报错。

  ​