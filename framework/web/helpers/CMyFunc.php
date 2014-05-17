<?php
/**
 * 函数库
 */
class CMyFunc
{
	/**
	 * 截取字符串
	 * @param string $string  字符串
	 * @param string $length  截取长度
	 * @param string $etc     省略号
	 * @param string $code    编码
	 */
	public static function truncate_string($string, $length = 20, $etc = '...', $code = 'UTF-8')
	{
		if ($length == 0) return '';
		if ($code == 'UTF-8') 
		{
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
		}
		else {
			$pa = "/[\x01-\x7f]|[\xa1-\xff][\xa1-\xff]/";
		}

		preg_match_all($pa, $string, $t_string);
		if (count($t_string[0]) > $length)
		{
			return join('', array_slice ( $t_string [0], 0, $length ) ) . $etc;
		} else {
			return $string;
		}
	}
	
	// 自动转换编码
	public static function auto_charset($fContents, $from = 'gbk', $to = 'utf-8') 
	{
		$from = strtoupper ($from) == 'UTF8' ? 'utf-8' : $from;
		$to = strtoupper ($to) == 'UTF8' ? 'utf-8' : $to;
		
    	if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) 
		{
			// 如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		
		if (is_string($fContents)) 
		{
			if (function_exists('mb_convert_encoding')) {
				return mb_convert_encoding($fContents, $to, $from);
			} elseif (function_exists('iconv')) {
				return iconv($from, $to, $fContents);
			} else {
				return $fContents;
			}
		} elseif (is_array($fContents))
		{
        	foreach ($fContents as $key => $val) 
			{
				$_key = CMyFunc::auto_charset($key, $from, $to);
				$fContents [$_key] = CMyFunc::auto_charset($val, $from, $to);
				if ($key != $_key) unset ($fContents[$key]);					
        	}
        	return $fContents;
    	}
    	else
        	return $fContents;

	}
	
	/**
	 * 加密解密函数
	 * @param string $string           原文
	 * @param string $operation        ENCODE 加密, DECODE 解密
	 * @param string $key
	 * @param int    $expiry
	 * @return string 加密后的字串
	 */
	public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		$ckey_length = 4;
		$key = md5($key ? $key : 'XXTM4afUeldZfE351c6u67d9c21s1f3u1J6CfT4t2i423hek4Rbw9YfG2V9V4kfE3ef');
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}

	}
	
	// 设置COOKIE
	public function set_cookie($name = '', $value = '', $expire = '', $domain = '', $path = '/', $prefix = '')
	{
		if (is_array($name))
		{
			foreach (array('value', 'expire', 'domain', 'path', 'prefix', 'name') as $item)
			{
				if (isset($name[$item]))
				{
					$$item = $name[$item];
				}
			}
		}

		if ( ! is_numeric($expire))
		{
			$expire = time() - 86500;
		}
		else
		{
			if ($expire > 0)
			{
				$expire = time() + $expire;
			}
			else
			{
				$expire = 0;
			}
		}

		setcookie($prefix.$name, $value, $expire, $path, $domain, 0);
	}
	
	// 获取COOKIE
	public function get_cookie($var, $prefix = 1) {
		$var = (COOKIE_PREFIX ? COOKIE_PREFIX : '').$var;
		return isset($_COOKIE[$var]) ? $_COOKIE[$var] : false;
	}

	// 清除COOKIE
	public function del_cookie($var, $prefix = 1) {
		if(is_array($var)){
			foreach($var as $val) CMyFunc::set_cookie($val, '', -360000, SITE_DOMAIN, '/', $prefix);
		} else {
			CMyFunc::set_cookie($var, '', -360000, SITE_DOMAIN, '/', $prefix);
		}
	}
	

	/**
	 * 分页函数
	 * @param int    $count      数据总数
	 * @param int    $curpage  当前页码
     * @param int    $limit    每页页码
	 */
	public function pagination($count, $curPage, $limit)
	{
        $totalPages = ceil($count / $limit);
        if($curPage==1){
            $prePage = 1;
            $nextPage = 1;
        }if($curPage>=$totalPages){
            $prePage = $totalPages;
            $nextPage = $totalPages;
        }else{
            $prePage = $curPage-1;
            $nextPage = $curPage+1;
        }
        $pageArr = array(
            'totalCount'=>$count,
            'totalPage'=>$totalPages,
            'curPage'=>$curPage,
            'prePage'=>$prePage,
            'nextPage'=>$nextPage);
        return $pageArr;
	}
	

	/**
	 * 显示图片各尺寸
	 * @param string $sourceImg   图片路径
	 * @param array  $size        图片尺寸
	 * @param string $type        类型
	 */
	public static function showImage($sourceImg, $size = array())
	{
		if (!$sourceImg) return false;
		
		$width  = (int) $size[0];
		$height = (int) $size[1];
		if (!$width || !$height) return false;
		
		$ext = strrchr($sourceImg, '.');                                // 图片后缀
		$fileName = str_replace($ext, '', $sourceImg);                  // 去掉后缀后的图片名称
        $sizeImg  = $fileName . '_thumb_' . $width . '_' . $height;     // 图片名称
        
        $source_img_file = DATA_ROOT . $sourceImg;
        $dest_img_file = DATA_ROOT . $sizeImg . $ext;
        
        if(file_exists($dest_img_file))               // 图片已经存在
        {     
			return str_replace('\\', '/', DATA_URL . $sizeImg . $ext);
        }
        else
        {   // 如不存在，则创建缩略图
        	if (!file_exists($source_img_file))
        	    return str_replace('\\', '/', DATA_URL . $sourceImg);
            else 
            {
            	$pic = CMyFunc::create_thumb($source_img_file, $dest_img_file, $width, $height, 95);
            	if ($pic)
            	    return str_replace('\\', '/', DATA_URL . $sizeImg . $ext);
            	else
            	    return str_replace('\\', '/', DATA_URL . $sourceImg);
            }
        }
	}
	
	/**
	 * 按比例裁剪
	 * @param string $type        类型
	 * @param string $sourceImg   原图地址
	 */
    public function create_thumb($source_img_file, $dest_img_file, $new_width, $new_height, $level = 95) {
        $path_parts = pathinfo($source_img_file);
        $ext_name = strtolower($path_parts['extension']);
        $img = null;
        $img = CMyFunc::imagecreatefromimg($source_img_file);
        $src_x = $src_y = 0;
        if ($img) {
            $imgcreate_fun = function_exists('ImageCreateTrueColor') ? 'ImageCreateTrueColor' : 'ImageCreate';
            $source_img_width = imagesx ($img);
            $source_img_height = imagesy ($img);
            if($source_img_width < $new_width || $source_img_height < $new_height) {
                $new_img_width = min($new_width,$source_img_width);
                $new_img_height = min($new_height,$source_img_height);
                $src_x = $source_img_width > $new_width ? (int) (($source_img_width - $new_width) / 2) : 0;
                $src_y = $source_img_height > $new_height ? (int) (($source_img_height - $new_height) / 2) : 0;
                $new_img = $imgcreate_fun ($new_img_width , $new_img_height);
                imagecopyresized($new_img ,$img, 0 ,0 ,$src_x ,$src_y ,$new_img_width, $new_img_height, $new_img_width , $new_img_height);
            } else {
                $w = $source_img_width / $new_width;
                if($source_img_height/$w >= $new_height) {
                    $new_img_width = $new_width;
                    $new_img_height = (int)($source_img_height / $source_img_width * $new_width);
                } else {
                    $new_img_height = $new_height;
                    $new_img_width = (int)($source_img_width / $source_img_height * $new_height);
                }
                $new_img = $imgcreate_fun ($new_width , $new_height);
                $new_img2 = $imgcreate_fun ($new_img_width , $new_img_height);
                ImageCopyResampled($new_img2, $img, 0, 0, 0, 0, $new_img_width, $new_img_height, $source_img_width, $source_img_height);
                $src_x = $src_y = 0;
                $src_x = $new_img_width > $new_width ? (int) (($new_img_width - $new_width) / 2) : 0;
                $src_y = $new_img_height > $new_height ? (int) (($new_img_height - $new_height) / 2) : 0;
                imagecopyresized($new_img ,$new_img2, 0 ,0 ,$src_x ,$src_y , $new_width, $new_height , $new_width , $new_height);
                imagedestroy($new_img2);
            }
            $fun = CMyFunc::imagecreatefun($ext_name);
            if($fun=='imagejpeg') {
                $fun( $new_img, $dest_img_file, $level);
            } else {
                if($fun=='imagegif') {
                    $bgcolor = ImageColorAllocate($new_img ,0, 0, 0);
                    $bgcolor = ImageColorTransparent($new_img, $bgcolor);
                }
                $fun( $new_img, $dest_img_file);
            }
            imagedestroy($img);
            imagedestroy($new_img); 
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 返回有效的img资源句柄
     * @param string $img   图片地址
     */
    public function imagecreatefromimg($img) {
        $ext_name = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        switch($ext_name) {
            case 'gif':
                return function_exists('imagecreatefromgif') ? imagecreatefromgif($img) : false;
                break;
            case 'jpg':
            case 'jpe':
            case 'jpeg':
                return function_exists('imagecreatefromjpeg') ? imagecreatefromjpeg($img) : false;
                break;
            case 'png':
                return function_exists('imagecreatefrompng') ? imagecreatefrompng($img) : false;
                break;
            default:
                return FALSE;
        }
    }

    /**
     * 返回创建图片的函数
     * @param string $ext  文件扩展名
     */
    public function imagecreatefun($ext) {
        switch($ext) {
        case 'gif':
            return 'imagegif';
        case 'png':
            return 'imagepng';
        default:
            return 'imagejpeg';
        }
    } 

    
    
     public function getOS(){
			  $agent = $_SERVER['HTTP_USER_AGENT'];
			  $os = false;
			  if (eregi('win', $agent) && strpos($agent, '95'))
			   $os = 'Windows 95';
			  else if (eregi('win 9x', $agent) && strpos($agent, '4.90'))
			   $os = 'Windows ME';
			  else if (eregi('win', $agent) && ereg('98', $agent))
			   $os = 'Windows 98';
			  else if (eregi('win', $agent) && eregi('nt 5.1', $agent))
			   $os = 'Windows XP';
			  else if (eregi('win', $agent) && eregi('nt 5', $agent))
			   $os = 'Windows 2000';
			  else if (eregi('win', $agent) && eregi('nt 6.1', $agent))
			   $os = 'Windows 7';
			  else if (eregi('win', $agent) && eregi('nt 6', $agent))
			   $os = 'Windows Visita';
			  else if (eregi('win', $agent) && eregi('nt', $agent))
			   $os = 'Windows NT';
			  else if (eregi('win', $agent) && ereg('32', $agent))
			   $os = 'Windows 32';
			  else if (eregi('linux', $agent))
			   $os = 'Linux';
			  else if (eregi('unix', $agent))
			   $os = 'Unix';
			  else if (eregi('sun', $agent) && eregi('os', $agent))
			   $os = 'SunOS';
			  else if (eregi('ibm', $agent) && eregi('os', $agent))
			   $os = 'IBM OS/2';
			  else if (eregi('Mac', $agent) && eregi('PC', $agent))
			   $os = 'Macintosh';
			  else if (eregi('PowerPC', $agent))
			   $os = 'PowerPC';
			  else if (eregi('AIX', $agent))
			   $os = 'AIX';
			  else if (eregi('HPUX', $agent))
			   $os = 'HPUX';
			  else if (eregi('NetBSD', $agent))
			   $os = 'NetBSD';
			  else if (eregi('BSD', $agent))
			   $os = 'BSD';
			  else if (ereg('OSF1', $agent))
			   $os = 'OSF1';
			  else if (ereg('IRIX', $agent))
			   $os = 'IRIX';
			  else if (eregi('FreeBSD', $agent))
			   $os = 'FreeBSD';
			  else if (eregi('teleport', $agent))
			   $os = 'teleport';
			  else if (eregi('flashget', $agent))
			   $os = 'flashget';
			  else if (eregi('webzip', $agent))
			   $os = 'webzip';
			  else if (eregi('offline', $agent))
			   $os = 'offline';
			  else 
			   $os = 'Unknown';
			
			  return $os;
		 } 
    
    	public function getBrowse()
	     {
		     global $_SERVER;
		     $Agent = $_SERVER['HTTP_USER_AGENT']; 
		     $browser = '';
		     $browserver = '';
		     $Browser = array('Lynx', 'MOSAIC', 'AOL', 'Opera', 'JAVA', 'MacWeb', 'WebExplorer', 'OmniWeb'); 
		     for($i = 0; $i <= 7; $i ++){
		         if(strpos($Agent, $Browsers[$i])){
		             $browser = $Browsers[$i]; 
		             $browserver = '';
		         }
		     }
		     if(ereg('Mozilla', $Agent) && !ereg('MSIE', $Agent)){
		         $temp = explode('(', $Agent); 
		         $Part = $temp[0];
		         $temp = explode('/', $Part);
		         $browserver = $temp[1];
		         $temp = explode(' ', $browserver); 
		         $browserver = $temp[0];
		         $browserver = preg_replace('/([d.]+)/', '1', $browserver);
		         $browserver = $browserver;
		         $browser = 'Netscape Navigator'; 
		     }
		     if(ereg('Mozilla', $Agent) && ereg('Opera', $Agent)) {
		         $temp = explode('(', $Agent);
		         $Part = $temp[1]; 
		         $temp = explode(')', $Part);
		         $browserver = $temp[1];
		         $temp = explode(' ', $browserver); 
		         $browserver = $temp[2];
		         $browserver = preg_replace('/([d.]+)/', '1', $browserver);
		         $browserver = $browserver;
		         $browser = 'Opera'; 
		     }
		     if(ereg('Mozilla', $Agent) && ereg('MSIE', $Agent)){
		         $temp = explode('(', $Agent);
		         $Part = $temp[1]; 
		         $temp = explode(';', $Part);
		         $Part = $temp[1];
		         $temp = explode(' ', $Part);
		         $browserver = $temp[2]; 
		         $browserver = preg_replace('/([d.]+)/','1',$browserver);
		         $browserver = $browserver;
		         $browser = 'Internet Explorer';
		     }
		     if($browser != ''){ 
		         $browseinfo = $browser.' '.$browserver;
		     } else {
		         $browseinfo = false;
		     }
		     return $browseinfo;
     }
		 
     
     
		 public function getIP () {
		     global $_SERVER;
		     if (getenv('HTTP_CLIENT_IP')) {
		         $ip = getenv('HTTP_CLIENT_IP');
		     } else if (getenv('HTTP_X_FORWARDED_FOR')) {
		         $ip = getenv('HTTP_X_FORWARDED_FOR'); 
		     } else if (getenv('REMOTE_ADDR')) {
		         $ip = getenv('REMOTE_ADDR');
		     } else {
		         $ip = $_SERVER['REMOTE_ADDR'];
		     }
		     return $ip; 
     	}
	
	public function str_len($str)
		{
			$length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
		
			if ($length)
			{
				return strlen($str) - $length + intval($length / 3) * 2;
			}
			else
			{
				return strlen($str);
			}
		} 
		
	/**
	*过滤所有的html字符串
	*$content 需要过滤的文本
	*/
	public function filterHtmlCode($content){
		if(isset($content) && $content!=""){
		
			 
	/*		$content = preg_replace("/<a[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/a>/i", "", $content);    
			$content = preg_replace("/<div[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/div>/i", "", $content); 

			$content = preg_replace("/<!--[^>]*-->/i", "", $content);//注释内容   
			$content = preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式   
			$content = preg_replace("/class=.+?['|\"]/i",'',$content);//去除样式   
			$content = preg_replace("/id=.+?['|\"]/i",'',$content);//去除样式      
			$content = preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式       
			$content = preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式    
			$content = preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式    
			$content = preg_replace("/border=.+?['|\"]/i",'',$content);//去除样式    
			$content = preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式    
			$content = preg_replace("/face=.+?['|\"]/",'',$content);//去除样式 只允许小写 正则匹配没有带 i 参数  */

			$content = preg_replace("/<img[^>]*>/i", "", $content); 

			$content = preg_replace("/<TextFlow[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/TextFlow>/i", "", $content); 
		 
			$content = preg_replace("/<p[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/p>/i", "", $content);

			$content = preg_replace("/<P[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/P>/i", "", $content);

			$content = preg_replace("/<U[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/U>/i", "", $content);

			$content = preg_replace("/<FONT[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/FONT>/i", "", $content);

			$content = preg_replace("/<span[^>]*>/i", "", $content);   
			$content = preg_replace("/<\/span>/i", "", $content);

			return $content;
		}
		return "";
	} 
	
	/**
	 * 过滤XML的字符
	 * @param string  $content  字符串
	 */
	public function filterXmlCode($content)
	{
		if (!$content && trim($content) == '') return '';
		
		$content = preg_replace("/&/i", "&amp;", $content);
		$content = preg_replace("/>/i", "&gt;", $content);
		$content = preg_replace("/</i", "&lt;", $content);
		$content = preg_replace("/\"/i", "&quot;", $content);
		$content = preg_replace("/'/i", "&apos;", $content);		
		
		return $content;
	}

	
	/**
	 * 字符串处理 去掉标点符号,HTML,并过滤重复字符串 不可逆
	 * @param string $str  需要过滤的字符串
	 */
	public function getClearStr($str = '')
	{
		//  去掉中,英文标点符号和HTML代码
		$str = preg_replace('/\s/','',preg_replace("/[[:punct:]]/",'',strip_tags(html_entity_decode(str_replace(array('？','！','￥','（','）','：','‘','’','“','”','《','》','，','…','。','、','&nbsp'),'',$str),ENT_QUOTES,'UTF-8'))));
		
		//  过滤掉重复字符
		$str = implode("",array_unique(preg_split('/(?<!^)(?!$)/u',$str)));
		
		return $str;
	}
	
	//过滤SQL
	public static function strip_sql($string) {
		//$string = CMyFunc::auto_charset($string, 'utf-8', 'gbk');  // 编码转换
		
		$pattern_arr = array("/ union /i", "/ select /i", "/ update /i", "/ outfile /i", "/ or /i", "/'/");
		
		$replace_arr = array('&nbsp;union&nbsp;', '&nbsp;select&nbsp;', '&nbsp;update&nbsp;',
		'&nbsp;outfile&nbsp;', '&nbsp;or&nbsp;', "''");

		return preg_replace($pattern_arr, $replace_arr, $string);
	}
	
	/**
	 * 验证日期格式
	 * @param string  $str     日期字符串
	 * @param string  $format  日期格式
	 */
	function checkDate($str, $format = "Y-m-d") 
	{
		$strArr = explode ("-", $str);
		if (!$strArr) return false;
		
		foreach ($strArr as $val) 
		{
			if (strlen ($val) < 2) $val = "0" . $val;
			
			$newArr [] = $val;
		}
		
		$str = implode ("-", $newArr);
		$unixTime = strtotime ($str);
		$checkDate = date ($format, $unixTime);
		
		if ($checkDate == $str) {
			return true;
		} else {
			return false;
		}
	}
	
	// 读取EXCEL时间
	function excelTime($date, $time = false) 
	{
		if (!$date) return '';
		
		if (function_exists ('GregorianToJD')) 
		{
			if (is_numeric ($date)) 
			{
				$jd = GregorianToJD (1, 1, 1970);
				$gregorian = JDToGregorian ($jd + intval ( $date ) - 25569);
				$date = explode ('/', $gregorian);
				$date_str = str_pad($date [2], 4, '0', STR_PAD_LEFT ) . "-" . str_pad ( $date [0], 2, '0', STR_PAD_LEFT ) . "-" . str_pad ( $date [1], 2, '0', STR_PAD_LEFT ) . ($time ? " 00:00:00" : '');
				
				return $date_str;
			}
		} else 
		{
			$date = $date > 25568 ? $date : 25569;

			$ofs = (70 * 365 + 17 + 2) * 86400;
			$date = date ("Y-m-d", ($date * 86400) - $ofs) . ($time ? " 00:00:00" : '');
		}
		
		return $date;
	} 

	
	/**
	 * 获取日历数据
	 * @param string  $startDate  开始日期
	 * @param string  $endDate    结束日期
	 */
	function getCalendarData($startDate, $endDate)
	{
		if (!$startDate || !$endDate) return array();
		
		$startTime = strtotime($startDate);
		$endTime = strtotime($endDate);

		$arr = array();
		$ii = 1;
		$weekOrder = 0;
		while ($startTime <= $endTime) 
		{
			$year = date('Y', $startTime);
			$month = date('n', $startTime);
			$day = date('j', $startTime);
			$week = date('w', $startTime);
			
			if (!$week) $week = 7;			
			
			$arr[$weekOrder][] = array(
			    'yearNum'    => $year,
			    'monthNum'   => $month,
			    'weekNum'    => $week,
			    'dateNum'    => $day,
			);			
			
			$startTime = strtotime("+1 day", $startTime);
			if ($ii % 7 == 0) $weekOrder++;
			$ii++;
		}
		
		return $arr;
	}
	
	/**
	 * 获取默认的作业生效时间、最晚提效时间
	 * @param int  $currentTime  当前时间
	 */
	function getDefaultTime($currentTime = 0)
	{
		global $_config;		
		
		$returnData = array();
		
		$StartTime = $currentTime ? date('Y-m-d H:i', $currentTime) : date('Y-m-d H:i');
		$StartTimeStamp = strtotime($StartTime);
		$TmpcurrentTime = date('H:i', $StartTimeStamp);
		
		if ($TmpcurrentTime < $_config['HomeworkValidTime']['StartTime'] || $TmpcurrentTime > $_config['HomeworkValidTime']['EndTime'])
		{
			$StartTime = date('Y-m-d ' . $_config['HomeworkValidTime']['StartTime'], strtotime('+1 day', $StartTimeStamp));
		}
		
		$EndTime = date('Y-m-d H:i', strtotime('+72 Hour', strtotime($StartTime)));
		
		$EndTime_Warn = date('Y-m-d H:i', strtotime('-24 Hour', strtotime($EndTime)));
		
		$returnData = array(
		    'StartTime'       => $StartTime,
		    'EndTime'         => $EndTime,
		    'EndTime_Warn'    => $EndTime_Warn,
		);
		
		return $returnData;
	}
	
	/**
	 * 获取剩余时间
	 * @param int $EndTime  最后的时间
	 */
	function getRemainTime($EndTime = 0)
	{
		if (!$EndTime) return '';
		
		$remainTime = $EndTime - time();
		if ($remainTime < 0) return '';
		
		$timeStr = '';
		$TimeD = $TimeH = $TimeM = 0;
		
		$TimeD = (int) ($remainTime / 86400);
		if ($TimeD) $timeStr .= $TimeD . '天';
		$remainTime = $remainTime - $TimeD * 86400;
		
		if ($remainTime)
		{
			$TimeH = (int) ($remainTime / 3600);
			$remainTime = $remainTime - $TimeH * 3600;
			$timeStr .= $TimeH . '小时';
		}
		
		if ($remainTime)
		{
			$TimeM = (int) ($remainTime / 60);
			$timeStr .= $TimeM . '分';
		}
		
		
		return $timeStr;
	}
	
	

	/**
	 * 内容替换
	 * @param string $text   内容模版
	 * @param array  $vars   变量值
	 */
	public static function contentReplace($text, $vars = array()) {
		
		if (!$text) return '';
		
		if(isset($vars) && is_array($vars)) 
		{
			foreach ($vars as $k => $v) 
			{
				$rk = $k + 1;
				$text = str_replace('\\'.$rk, $v, $text);
			}
		}
		
		return $text;
	}
	
	/**
	 * 验证手机号码
	 *
	 * @param string $mobile 手机号码
	 */
	public static function checkMobile($mobile)
	{
		if (!$mobile) return false;
		//add lhz 20131011
		if(strlen($mobile)>11) return false;

		$pattern = "/^13[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/";
		
		if (preg_match($pattern, $mobile))
			return true;
		else
			return false;
	}
	
	/**
	 * 验证固话
	 *
	 * @param string $tel
	 */
	public function checkTelephone($tel)
	{
		if (!$tel) return false;
		
		$pattern = "/^((\+\d{2}|0{2}\d{2})?-?((0[1-9]\d)?-?[1-9]\d{7})|((0[1-9]\d{2})?-?[1-9]\d{6,7}))$/";
		
		if (preg_match($pattern, $tel))
			return true;
		else
			return false;
	}
	
	/**
	 * 获取文件类型
	 *
	 * @param string $filename
	 */
	public function getFileType($filename)
	{
		if (!$filename)
			return null;
		$fp = fopen($filename, "rb");
		$bin = fread($fp, 2);
		fclose($fp);
		$strInfo = @unpack("C2chars", $bin);
		$typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
		$fileType  = '';
		switch ($typeCode)
		{
			 case 34229:
	             $fileType = 'csv';
	             break;
	         case 208207:
	             $fileType = 'xls';
	             break;
	         case 8075:
	             $fileType = 'xlsx';
	             break;
		}
		return $fileType;
	
	}
	
	/**
	 * 写入文件
	 * @param string $filename   文件名(包括路径)
	 * @param string $content    文件内容
	 */
	public function writeFile($filename, $content)
	{
		if (!$filename) return false;
		
		$fileinfo = pathinfo($filename);
		$path = $fileinfo['dirname'];
		CMyFunc::createFolder($path, 1);
		
		$writeFile = $filename;
		
		$extra = strtolower(pathinfo($writeFile, PATHINFO_EXTENSION));
		
		@chmod($writeFile, 0777);
		$fp = @fopen($writeFile, 'wb');
		if($fp) {			
			if($extra == 'php') {
				@fwrite($fp, "<?php\r\n//cache file\r\n//Created on ".date('Y-m-d H:i:s', time())."\r\n\r\n".$content);
			} elseif($extra == 'js') {
				@fwrite($fp, "// cache file\r\n//Created on ".date('Y-m-d H:i:s', time())."\r\n\r\n".$content."\r\n");
			} else {
				@fwrite($fp, $content);
			}
			@fclose($fp);
			@chmod($writeFile, 0777);
		} else {
			echo 'Can not write to '.$writeFile.' cache files, please check directory.';
			exit;
		}
		
		return true;
	}
	
	/**
	 * 数组转换成字串
	 * @param array $array
	 * @param int $level
	 */
	public function arrayeval($array, $level = 0)
	{
		$space = '';
		for ($i = 0; $i <= $level; $i++)
		{
			$space .= "\t";
		}
		$evaluate = "";
		$comma = $space;
		foreach ($array as $key => $val)
		{
			$key = is_string($key) ? '\'' . addcslashes($key, '\'\\') . '\'' : $key;
			$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12 || substr($val, 0, 1) == '0') ? '\'' . addcslashes($val, '\'\\') . '\'' : $val;
			if (is_array($val))
			{
				$evaluate .= "define(" . $key . "," . $this->arrayeval($val, $level + 1);
			}
			else
			{
				$evaluate .= "define(" . $key . "," . $val . ");\r\n";
			}
			$comma = "\n$space";
		}
		$evaluate .= "\n$space";
		return $evaluate;
	}
	
	/**
	 * 将字符串中的表情标签进行转换
	 * @param string $string   转换字符串
	 * @param string $flag     类型： 1 转换成图标, 0 转换成空字符串
	 */
	public static function feelConvert($string, $flag = 1)
	{
	    global $_config;
	    
	    if (!$string || !$_config['feel_code']) return '';
	    
	    foreach ($_config['feel_code'] as $v)
	    {
	    	if ($flag == 1)
	    		$img = '<img src="' . DATA_URL . $v['img'] . '" alt="'. $v['code'] .'">';
	    	else 
	    		$img = '';
	    		
	    	$string = str_replace($v['code'], $img, $string);
	    }
	    
	    return $string;
	}
	
	/**
	 * 将心情字符串转换为HTML标签
	 * @param string $string
	 */
	public function heartConvert($string)
	{
		global $_config;
		
	    if (!$string || !$_config['heart_code']) return '';
	    
	    $data = '';
	    
	    foreach ($_config['heart_code'] as $v)
	    {
	    	if ($v['code'] == $string)
	    	{
	    		$data = '<span class="feel-wrap '. $v['class'] .'">'. $v['code'] .'</span>';
	    		break;
	    	}
	    }
	    
	    return $data;
	}
	
	/**
	 * 创建目录
	 * @param string  $subdir 目录名
	 * @param int     $isAll  是否是全路径
	 */
	public function createFolder($subdir, $isAll = 0)
	{
		$path = $isAll == 1 ? '' : DATA_ROOT;
    	$dir = $path . $subdir;
    	
		if(!file_exists($dir))
		{
            if(!@mkdir($dir, 0777, true)) 
            {
				return false;
            }
        }
        
    	CMyFunc::chmodr($dir, 0777);
    	
    	return true;
	}
	
	/**
	 * 修改目录权限
	 * @param string  $dir       目录
	 * @param string  $filemode  权限
	 */
	public function chmodr($dir, $filemode)
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') return false;
		
		$arrDir	= explode(DS, $dir);

        $m = strtoupper(substr($dir, 0, 1)) === DS ? DS : '';

		$subDir	= '';

		foreach( $arrDir as $t )
		{
			if (trim($t))
			{
				$subDir	.= $m . $t;

				if(!file_exists($subDir))
				{
					if(!@mkdir($subDir, 0777, true) )
					{
						die('目录创建失败！');
					}
				}
				@chmod($subDir, $filemode);

				$m = DS;
			}			
		}
	}
	
	/**
	 * 删除文件
	 * @param string or array  $files
	 */
	public function removeFiles($files)
	{
		if (!$files) return false;
		
		if (is_array($files))
		{
			foreach ($files as $file)
			{
				$file = DATA_ROOT . $file;
				
				if (is_file($file) && file_exists($file))
				{
					@unlink($file);
				}
			}
			
		} else {
			$files = DATA_ROOT . $files;
			
			if (is_file($files) && file_exists($files))
			{
				@unlink($files);
			}
		}
		
		return true;
	}
	

	/**
	 * 上传缩略图
	 * @param int     $type            类型：1 兑换商品, 2 用户头像
	 * @param string  $name            表单名称
	 * @param string  $folder          上传目录
	 * @param string  $subdir          上传子目录类型
	 * @param array   $mment           生成的原图大小
	 * @param boolen  $delete_source   是否删除原文件
	 * @param string  $filename        自定义上传文件名
	 */
	public static function uploadImage($type = 1, $name, $folder, $subdir='DAY', $mment = array(), $delete_source=false, $filename = '')
	{		
		global $_config;
		
		if (isset($_FILES[$name]) && $_FILES[$name] && $_FILES[$name]['error'] == 0)
		{
			require_once ('protected/extensions/upload_image.class.php');
			$img = new ms_upload_image($name);
			
			// 最大上传 KB
			$img->set_max_size(2 * 1024);
			
			// 图片质量 0-100
			$img->set_thumb_level(95);
			
			// 需要生成的缩略图
			$typeStr = $type == 1 ? 'ProductSize' :  ($type == 2?'AvatarSize':( $type==3 ? 'FeedBackSize':'' ));		
			
			if($typeStr){
				foreach ($_config[$typeStr] as $key => $val)
				{
					$img->add_thumb('thumb_'.$key, '', $val, $val);
				}
			}

			$img->upload($folder, $subdir, $mment, $delete_source, $filename);
			if (!$img->filename) return null;
				
			if ($type == 1)   // 兑换商品
			{				
				$fileinfo = pathinfo($img->filename);
	        	$img_small  = $img->path . DS . $fileinfo['filename'] . '_thumb_90_90.' . $fileinfo['extension'];        	
				$img_small = str_replace(DS, '/', $img_small);
				$img_big  = $img->path . DS . $fileinfo['filename'] . '_thumb_270_270.' . $fileinfo['extension'];        	
				$img_big = str_replace(DS, '/', $img_big);

				$imgArr = array(
					'small'  => $img_small,
					'big'	 => $img_big,
				);
				
				return $imgArr;
				
			} else if ($type == 2)   // 用户头像
			{				
				$fileinfo = pathinfo($img->filename);
	        	$img_original  = $img->path . DS . $fileinfo['filename'] . '_thumb_50_50.' . $fileinfo['extension'];        	
				$img_original = str_replace(DS, '/', $img_original);
				
				return $img_original != '' ? $img_original : null;
			}
			else if($type==3){
				$fileinfo = pathinfo($img->filename);
	        	$img_small  = $img->path . DS . $fileinfo['filename'] . '_thumb_100_100.' . $fileinfo['extension']; $img_small = str_replace(DS, '/', $img_small);  
			
				$imgback = str_replace(DS, '/', $img->path . DS . $fileinfo['filename'] . '.' . $fileinfo['extension']);
				$imgArr = array(
					'back'	 => $imgback,
					'small'  => $img_small,
				);
				return $imgArr;
			}
			else if($type==4){
				//图片上传
				$fileinfo = pathinfo($img->filename);
				$img = str_replace(DS, '/', $img->path . DS . $fileinfo['filename'] . '.' . $fileinfo['extension']);
				return $img;
			}
		}
		else
		{
			return null;
		}
	}


    /**
     * @param $file 文件的名称
     * @return string
     * @desc 返回文件的内容
     */
    public function getContent($file){
        if (!$file) return false;
        $cont = '';
        $file = DATA_ROOT . $file;
        if (is_file($file) && file_exists($file))
        {
            $fp = fopen($file, "r");
            if (flock($fp, LOCK_EX)) { // 进行排它型锁定
                $cont = fread($fp,1024);
                flock($fp, LOCK_UN); // 释放锁定
            }
            fclose($fp); //关闭文件指针
        }
        return $cont;
    }


	//生成指定长度的随机字符串（字母+数字）
	public static function  getRandChars($length){
		$chars = array("0","1","2","3","4","5","6","7","8","9",
			           "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r",
			           "s","t","u","v","w","x","y","z");
		$randCode=array();
		for($i=0;$i<$length;$i++){
			$randCode[]=$chars[rand(0,35)];
		}
		$randCode=implode("",$randCode);
		return $randCode;
	}



}