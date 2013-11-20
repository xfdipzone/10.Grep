<?php
/** grep class
*   Date:   2013-06-15
*   Author: fdipzone
*   Ver:    1.0
*
*   Func:
*   public  set:        设置内容
*   public  get:        返回指定的内容
*   public  replace:    返回替换后的内容
*   private get_pattern 根据type返回pattern
*/

class Grep{ // class start

    private $_pattern = array(
                            'url' => '/<a.*?href="((http(s)?:\/\/).*?)".*?/si',
                            'email' => '/([\w\-\.]+@[\w\-\.]+(\.\w+))/',
                            'image' => '/<img.*?src=\"(http:\/\/.+\.(jpg|jpeg|gif|bmp|png))\">/i'
                        );

    private $_content = ''; // 源内容


    /* 設置搜尋的內容
    *  @param String $content
    */
    public function set($content=''){
        $this->_content = $content;
    }


    /* 获取指定内容
    *  @param String $type
    *  @param int    $unique 0:all 1:unique
    *  @return Array
    */
    public function get($type='', $unique=0){

        $type = strtolower($type);

        if($this->_content=='' || !in_array($type, array_keys($this->_pattern))){
            return array();
        }

        $pattern = $this->get_pattern($type); // 获取pattern

        preg_match_all($pattern, $this->_content, $matches);

        return isset($matches[1])? ( $unique==0? $matches[1] : array_unique($matches[1]) ) : array();

    }


    /* 获取替换后的内容
    *  @param String $type
    *  @param String $callback
    *  @return String
    */
    public function replace($type='', $callback=''){

        $type = strtolower($type);

        if($this->_content=='' || !in_array($type, array_keys($this->_pattern)) || $callback==''){
            return $this->_content;
        }

        $pattern = $this->get_pattern($type);

        return preg_replace_callback($pattern, $callback, $this->_content);

    }


    /* 根据type获取pattern
    *  @param String $type
    *  @return String
    */
    private function get_pattern($type){
        return $this->_pattern[$type];
    }


} // class end

?>