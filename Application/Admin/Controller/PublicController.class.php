<?php
namespace Admin\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
/**
 * 本地公共类库文件
 */
class PublicController extends Controller {
	/*
	 *	curl(get请求)
	*/
	public function curl($url){
		//1.实例化（初始化curl）  curl:网站抓取函数
		$curl = curl_init();
		//2.设置curl参数
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
		//3. 数据采集
		$res= curl_exec($curl);
		//4. 关闭
		curl_close($curl);
		return $res;
	}
	/*
	 *	curl_post(post请求)
	*/
	public function curl_post($url,$post_data){
		//1.实例化（初始化curl）  curl:网站抓取函数
		$curl = curl_init();
		//2.设置curl参数
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
		 
		// 设置请求为post类型
		curl_setopt($curl, CURLOPT_POST, 1);
		// 添加post数据到请求中
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		//3. 数据采集
		$res= curl_exec($curl);
		//4. 关闭
		curl_close($curl);
		return $res;
	}
	/*
	 * 文件下载 
	 */
	public function files_download($file){
		$showname = 'XJ的文件-'.$file;		//下载时用户看到的文件名称
		$public = './Public/File/';//公共路径
		$file = $public.$file;		//文件实际路径
		//实例化下载类库
		$http = new \Org\Net\Http();
		$http->download($file,$showname);
	}
	/**
	 * 查询个人信息
	 */
	public function pro_info($username){
		$info = M('Staff_info')
		-> where(array('username'=>$username))
		-> find();
		return $info;
	}
	/*
	 * 生成Excel数据
	 */
	public function Excel($dir,$info,$bt){	//文件路径，数据数组，表头数组		
		
 		// 导入 Library/Org/Util/PHPExcel.class.php类库
 		import("Org.Util.PHPExcel");	//加载类库文件
		$objPHPExcel = new \PHPExcel();	//实例化类(等同于桌面新建Excel表格，默认生成一个sheet)
		$objSheet = $objPHPExcel -> getActiveSheet();	//获取当前活动sheet操作对象
		$objSheet -> setTitle('demo');	//为当前活动sheet设置名称
		$objSheet -> getDefaultStyle() -> getAlignment() -> setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER) -> setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	//设置单元格垂直水平居中
		$objSheet -> getStyle("A1:H1")->getFont()->setSize(12);
		$objSheet -> mergeCells("C1:D1");	//合并单元格
		$objSheet -> mergeCells("E1:F1");
		$objSheet -> mergeCells("G1:H1");
		$objSheet -> setCellValue("A1",$bt['0']) -> setCellValue("B1",$bt['1'])
		-> setCellValue("C1",$bt['2']) -> setCellValue("E1",$bt['3']) -> setCellValue("G1",$bt['4']);//给当前活动sheet填充数据
		$count = count($info);
		$j = '2';	//设定数据初始行
		foreach($info as $key=>$val){
			$objSheet -> setCellValue("A".$j,$val['name']) -> setCellValue("B".$j,$val['sex'])
			-> setCellValue("C".$j,$val['device_id']) -> setCellValue("E".$j,$val['parent_name']) -> setCellValue("G".$j,$val['parent_phone']);//给当前活动sheet填充数据
			$j++;
		}
		$filename="学生信息-".date('Y-m-d').'.xls';
		$filename = iconv("utf-8", "gb2312", $filename);
		ob_end_clean();//清除缓冲区,避免乱码
		//输出03版excel文件到浏览器
		header('Content-Type: application/vnd.ms-excel');//告诉浏览器输出03版文件
		header("Content-Disposition: attachment;filename={$filename}");//告诉浏览器输出文件名称
		header('Cache-Control: max-age=0');//禁止浏览器缓存
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//生成03版Excel文件，xls格式文件
		$objWriter->save($dir.$filename); //保存到服务器
		$objWriter->save('php://output'); //文件通过浏览器下载
		exit;
	}
	/**
	 * 文件上传类
	 */
	public function file_upload($data,$file,$table_name){
		$flag=1;//上传成功与否标志
		if(!$file['name']){        //禁止非空上传
			return "file none";
			die;
		}
		if(isset($file) && $file['name'] != ""){
			$array = array("image/jpg","image/png","image/jpeg");
			$file_type = $file['type'];        //查看图片类型
			if(!in_array($file_type,$array)){
				return "undefind type";
				die;
			}
			if($file['size'] > 1048576){
				return  "too large";
				die;
			}
			$type = strrchr($file['name'],".");    //寻找"."在字符串中最后一次出现的位置及以后的信息（获取类型）
			$time = date("YmdHis");
			$filename = session('username').$time.$type;//设置图片名称唯一
			if(is_uploaded_file($file['tmp_name'])){
				if(move_uploaded_file($file['tmp_name'], "./Public/upload/".$table_name."/".$filename)){
					$data['image'] = $filename;    //图片名称
					$path="./Public/upload/".$table_name."/".$filename;    //图片具体路径
				}else{
					$flag = 0;
				}
			}else{
				$flag = 0;
			}
		}
		if($flag == 0){
			return  "other error";
			die;
		}
		//上传成功
		M($table_name)->add($data);
		return 'success';
	}
}