<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think;

/**
 * ThinkPHP 控制器基类 抽象类
 */
abstract class Controller {
	
	/**
	 * 视图实例对象
	 *
	 * @var view
	 * @access protected
	 */
	protected $view = null;
	
	/**
	 * 控制器参数
	 *
	 * @var config
	 * @access protected
	 */
	protected $config = array ();
	
	/**
	 * 架构函数 取得模板对象实例
	 *
	 * @access public
	 */
	public function __construct() {
		// 实例化视图类
		$this->view = Think::instance ( 'Think\View' );
		// 控制器初始化
		if (method_exists ( $this, '_initialize' ))
			$this->_initialize ();
	}
	
	/**
	 * 模板显示 调用内置的模板引擎显示方法，
	 *
	 * @access protected
	 * @param string $templateFile
	 *        	指定要调用的模板文件
	 *        	默认为空 由系统自动定位模板文件
	 * @param string $charset
	 *        	输出编码
	 * @param string $contentType
	 *        	输出类型
	 * @param string $content
	 *        	输出内容
	 * @param string $prefix
	 *        	模板缓存前缀
	 * @return void
	 */
	protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
		$this->view->display ( $templateFile, $charset, $contentType, $content, $prefix );
	}
	
	/**
	 * 输出内容文本可以包括Html 并支持内容解析
	 *
	 * @access protected
	 * @param string $content
	 *        	输出内容
	 * @param string $charset
	 *        	模板输出字符集
	 * @param string $contentType
	 *        	输出类型
	 * @param string $prefix
	 *        	模板缓存前缀
	 * @return mixed
	 */
	protected function show($content, $charset = '', $contentType = '', $prefix = '') {
		$this->view->display ( '', $charset, $contentType, $content, $prefix );
	}
	
	/**
	 * 获取输出页面内容
	 * 调用内置的模板引擎fetch方法，
	 *
	 * @access protected
	 * @param string $templateFile
	 *        	指定要调用的模板文件
	 *        	默认为空 由系统自动定位模板文件
	 * @param string $content
	 *        	模板输出内容
	 * @param string $prefix
	 *        	模板缓存前缀*
	 * @return string
	 */
	protected function fetch($templateFile = '', $content = '', $prefix = '') {
		return $this->view->fetch ( $templateFile, $content, $prefix );
	}
	
	/**
	 * 模板主题设置
	 *
	 * @access protected
	 * @param string $theme
	 *        	模版主题
	 * @return Action
	 */
	protected function theme($theme) {
		$this->view->theme ( $theme );
		return $this;
	}
	
	/**
	 * 模板变量赋值
	 *
	 * @access protected
	 * @param mixed $name
	 *        	要显示的模板变量
	 * @param mixed $value
	 *        	变量的值
	 * @return Action
	 */
	protected function assign($name, $value = '') {
		$this->view->assign ( $name, $value );
		return $this;
	}
	public function __set($name, $value) {
		$this->assign ( $name, $value );
	}
	
	/**
	 * 取得模板显示变量的值
	 *
	 * @access protected
	 * @param string $name
	 *        	模板显示变量
	 * @return mixed
	 */
	public function get($name = '') {
		return $this->view->get ( $name );
	}
	public function __get($name) {
		return $this->get ( $name );
	}
	
	/**
	 * 检测模板变量的值
	 *
	 * @access public
	 * @param string $name
	 *        	名称
	 * @return boolean
	 */
	public function __isset($name) {
		return $this->get ( $name );
	}
	
	/**
	 * 魔术方法 有不存在的操作的时候执行
	 *
	 * @access public
	 * @param string $method
	 *        	方法名
	 * @param array $args
	 *        	参数
	 * @return mixed
	 */
	public function __call($method, $args) {
		if (0 === strcasecmp ( $method, ACTION_NAME . C ( 'ACTION_SUFFIX' ) )) {
			if (method_exists ( $this, '_empty' )) {
				// 如果定义了_empty操作 则调用
				$this->_empty ( $method, $args );
			} elseif (file_exists_case ( $this->view->parseTemplate () )) {
				// 检查是否存在默认模版 如果有直接输出模版
				$this->display ();
			} else {
				E ( L ( '_ERROR_ACTION_' ) . ':' . ACTION_NAME );
			}
		} else {
			E ( __CLASS__ . ':' . $method . L ( '_METHOD_NOT_EXIST_' ) );
			return;
		}
	}
	
	/**
	 * 操作成功跳转的快捷方法
	 *
	 * @access protected
	 * @param string $message
	 *        	提示信息
	 * @param string $jumpUrl
	 *        	页面跳转地址
	 * @param mixed $ajax
	 *        	是否为Ajax方式 当数字时指定跳转时间
	 * @return void
	 */
	protected function success($message = '', $jumpUrl = '', $ajax = false) {
		$this->dispatchJump ( $message, 0, $jumpUrl, $ajax );
	}
	
	/**
	 * Ajax方式返回数据到客户端
	 *
	 * @access protected
	 * @param mixed $data
	 *        	要返回的数据
	 * @param String $type
	 *        	AJAX返回数据格式
	 * @param int $json_option
	 *        	传递给json_encode的option参数
	 * @return void
	 */
	protected function ajaxReturn($data, $type = '', $json_option = 0) {
		if (empty ( $type ))
			$type = C ( 'DEFAULT_AJAX_RETURN' );
		switch (strtoupper ( $type )) {
			case 'JSON' :
				
				// 返回JSON数据格式到客户端 包含状态信息
				header ( 'Content-Type:application/json; charset=utf-8' );
				$data = json_encode ( $data, $json_option );
				break;
			case 'JSONP' :
				
				// 返回JSON数据格式到客户端 包含状态信息
				header ( 'Content-Type:application/json; charset=utf-8' );
				$handler = isset ( $_GET [C ( 'VAR_JSONP_HANDLER' )] ) ? $_GET [C ( 'VAR_JSONP_HANDLER' )] : C ( 'DEFAULT_JSONP_HANDLER' );
				$data = $handler . '(' . json_encode ( $data, $json_option ) . ');';
				break;
			case 'EVAL' :
				
				// 返回可执行的js脚本
				header ( 'Content-Type:text/html; charset=utf-8' );
				break;
		}
		exit ( $data );
	}
	
	/**
	 * Action跳转(URL重定向） 支持指定模块和延时跳转
	 *
	 * @access protected
	 * @param string $url
	 *        	跳转的URL表达式
	 * @param array $params
	 *        	其它URL参数
	 * @param integer $delay
	 *        	延时跳转的时间 单位为秒
	 * @param string $msg
	 *        	跳转提示信息
	 * @return void
	 */
	protected function redirect($url, $params = array(), $delay = 0, $msg = '') {
		$url = U ( $url, $params );
		redirect ( $url, $delay, $msg );
	}	
}
