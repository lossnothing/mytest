<?php 
  class DownloadFile
{
    public $fileName;
    public $filePath;
    public $fileSize;//文件大小

    //获取文件名
    public function getfilename()
    {
        return $this->fileName;
    }

    //获取文件路径（包含文件名）
    public function getfilepath()
    {
        return $this->filePath;
    }

    //获取文件大小
    public function getfilesize()
    {
        return $this->fileSize = number_format(filesize($this->filePath) / (1024 * 1024), 2);//去小数点后两位
    }

    //下载文件的功能
    public function getfiles()
    {
        //检查文件是否存在
        if (file_exists($this->filePath)) {
            //打开文件
            $file = fopen($this->filePath, "r");
            //返回的文件类型
            Header("Content-type: application/octet-stream");
            //按照字节大小返回
            Header("Accept-Ranges: bytes");
            //返回文件的大小
            Header("Accept-Length: " . filesize($this->filePath));
            //这里对客户端的弹出对话框，对应的文件名
            Header("Content-Disposition: attachment; filename=" . $this->fileName);
            //修改之前，一次性将数据传输给客户端
            echo fread($file, filesize($this->filePath));
            //修改之后，一次只传输1024个字节的数据给客户端
            //向客户端回送数据
            $buffer = 1024;//
            //判断文件是否读完
            while (!feof($file)) {
                //将文件读入内存
                $file_data = fread($file, $buffer);
                //每次向客户端回送1024个字节的数据
                echo $file_data;
            }

            fclose($file);
        } else {
            exit("<script>alert('对不起,您要下载的文件不存在');</script>");
        }
    }
}
