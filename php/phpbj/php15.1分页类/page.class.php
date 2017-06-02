<?php
class Page{
    private $total;
    private $listRows;
    private $limit = 'LIMIT 0,10';
    private $uri;
    private $page;
    private $pageNum;
    private $start;
    private $end;
    private $parameter;
    private $config = array(
        'header'=>'条记录',
        'prev'=>'上一页',
        'next'=>'下一页',
        'first'=>'首&nbsp;页',
        'last'=>'尾&nbsp;页',
        'pageListSize'=> '8'
    );

    public function __construct($total, $listRows, $parameter= ''){
        $this->total = $total;
        $this->listRows = $listRows;
        $this->parameter = $parameter;
        $this->uri = $this->getUri();
        $this->pageNum = ceil($this->total/$this->listRows);
        $this->page = empty($_GET['page']) || ($_GET['page']<= 1 ) ? 1 : ( $_GET['page'] > $this->pageNum ? $this->pageNum : $_GET['page']);
        $this->start = $this->total ==0 ? 0 : ($this->page-1)*$this->listRows;
        $this->end = ($this->start + $this->listRows)<=$this->total ? ($this->start + $this->listRows) : $this->total;
        $this->limit = "LIMIT ".($this->start).",{$this->listRows}";
        /*
            echo "<pre>";
            var_dump($this);
            echo "</pre>";
        */
    }
    
    public function __get($args){
        if($args == "limit"){
            return $this->limit;
        }else{
            return null;
        }
    }
    
    private function getUri(){
        /*
            echo '<pre>';
            print_r($_SERVER);
            echo '</pre>';
        */

        $url = $_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"],'?') ? '':'?').'&'.$this->parameter;
        
        $parse = parse_url($url);

        if(isset($parse['query'])){
            //去除url中的page参数
            parse_str($parse['query'],$params);
            unset($params['page']);
            $url = $parse['path'].'?'.http_build_query($params);
        }
        return $url;
    }

    private function first(){
        $html = ($this->page == 1? '' : "&nbsp;&nbsp;<br><a href='".$this->uri."&page=1'>{$this->config['first']}</a> ");
        return $html;
    }

    private function prev(){
        $html = ($this->page <= 1? '' : "&nbsp;&nbsp;<a href='".$this->uri."&page=".($this->page-1)."'>{$this->config['prev']}</a> ");
        return $html;
    }

    private function pageList(){
        $html = '';
        $half = ceil($this->config['pageListSize']/2);
        $pageListSize = $this->config['pageListSize'] < $this->pageNum? $this->config['pageListSize'] : $this->pageNum;
        if($this->page <= $half ){
            $pageListStart = 1;
        }else if($this->page >= $this->pageNum - $half){
            $pageListStart = $this->pageNum - $pageListSize+1;
        }else{
            $pageListStart = $this->page - $half + 1;
        }
        for($i=0; $i<$pageListSize; $i++){
            $html.= "&nbsp;<a ".($pageListStart==$this->page? 'class= "active" style = "background-color:red; color:white"' : '')."' href='".$this->uri."&page=".$pageListStart."' >{$pageListStart}</a>";
            $pageListStart++;
        }
        return $html;
    }

    private function next(){
        $html = ($this->page >= $this->pageNum? '' : "&nbsp;&nbsp;<a href='".$this->uri."&page=".($this->page+1)."'>{$this->config['next']}</a> ");
        return $html;
    }

    private function last(){
        $html = ($this->page == $this->pageNum? '' : "&nbsp;&nbsp;<a href='".$this->uri."&page={$this->pageNum}'>{$this->config['last']}</a> ");
        return $html;
    }

    private function goPage(){
        $html = '&nbsp;&nbsp;<input id="goPageText" type="text" size=1 value="'.$this->page.'" onkeyup="javascript: event.keyCode == 13 && goPages(this.value);"/>';
        $html .= '<input type="button" value="Go" onclick="goPages(this.previousSibling.value)"/>';
        
        $html .= '<script> 
            function goPages(goPageVal){
                var goPageVal = goPageVal || 1; 
                if(isNaN(goPageVal) || !/^\d+$/.test(goPageVal)){
                    alert(\'请输入合法数字\')
                } else { 
                    goPageVal<1 && (goPageVal =1); 
                    goPageVal >'.$this->pageNum.'&& (goPageVal ='.$this->pageNum.');
                    window.location.href= \''.$this->uri.'&page=\'+goPageVal;
                };
            }
        </script>';
        return $html;
    }


    function fpage($display = array(0,1,2,3,4,5,6,7,8,9)){
        $html[0] = "&nbsp;&nbsp;共有<b>{$this->total}</b>{$this->config['header']} ";
        $html[1] = "&nbsp;&nbsp;每页显示:{$this->listRows}条 ";
        $html[2] = "&nbsp;&nbsp;本页为第".($this->start+1)."-{$this->end}条 ";
        $html[3] = "&nbsp;{$this->page}/{$this->pageNum}页 ";
        $html[4] = $this->first();
        $html[5] = $this->prev();
        $html[6] = $this->pageList();
        $html[7] = $this->next();
        $html[8] = $this->last();
        $html[9] = $this->goPage();

        $fpage = '';
        foreach($display as $index){
            $fpage.=$html[$index];
        }
        return $fpage;
    }
}