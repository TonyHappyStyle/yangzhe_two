<?php

namespace AppBundle\Implement;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * GpImplement
 *
 * 工具类，所有表继承本类
 */
class GpImplement extends EntityRepository{
    /**
     * 股票数据
     * @var array
     * @access public
     */
    var $data = array();
    /**
     * 日期 时间戳形式
     * @var string
     * @access public
     */
    var $date = '';
    /**
     * 日期 Y-m-d形式
     * @var string
     * @access public
     */
    var $time = '';
    /**
     * 开盘价格
     * @var float
     * @access public
     */
    var $opening_price = '';

    /**
     * 最高价格
     * @var float
     * @access public
     */
    var $ceiling_price = '';

    /**
     * 最低价格
     * @var float
     * @access public
     */
    var $lower_price = '';

    /**
     * 收盘价格
     * @var float
     * @access public
     */
    var $closing_price = '';
    /**
     * 成交量
     * @var integer
     * @access public
     */
    var $volume = '';
    /**
     * 单日涨幅
     * @var float
     * @access public
     */
    var $rose = '';

    /**
     * 单日振幅
     * @var float
     * @access public
     */
    var $amplitude = '';

    /**
     * 开盘涨幅
     * @var float
     * @access public
     */
    var $opening_ratio = '';

    /**
     * 开盘上涨
     * @var float
     * @access public
     */
    var $opening_ratio_1 = '';

    /**
     * 开盘下跌
     * @var float
     * @access public
     */
    var $opening_ratio_0 = '';

    /**
     * 最高价与当日开盘价的差值
     * @var float
     * @access public
     */
    var $ceiling_to_opening = '';

    /**
     * 最低价与当日开盘价的差值
     * @var float
     * @access public
     */
    var $lower_to_opening = '';

    /**
     * 最高价与当日开盘价的差值，比上开盘价
     * @var float
     * @access public
     */
    var $ceiling_ratio = '';

    /**
     * 最低价与当日开盘价的差值，比上开盘价
     * @var float
     * @access public
     */
    var $lower_ratio = '';

    /**
     * 连续涨跌的天数
     * @var integer
     * @access public
     */
    var $count = '';

    /**
     * 前一天连续涨跌的天数
     * @var integer
     * @access public
     */
    var $pre_count = '';
    /**
     * 前两天连续涨跌的天数
     * @var integer
     * @access public
     */
    var $pre_two_count = '';
    /**
     * 前三天连续涨跌的天数
     * @var integer
     * @access public
     */
    var $pre_three_count = '';
    /**
     * keyName组合
     * @var array
     * @access public
     */
    var $_keyName = array(
        '1_z1_f1',
        '1_z1_f2',
        '1_z1_f3',
        '1_z1_f4',
        '1_z1_f5',
        '1_f2_f1',
        '1_f3_f2',
        '1_f4_f3',
        '1_f5_f4',
        '1_f1_z1',
        '1_z2_z1',
        '1_z3_z2',
        '1_z4_z3',
        '1_z5_z4',
        '1_z6_z5',
        '0_z1_f1',
        '0_z1_f2',
        '0_z1_f3',
        '0_z1_f4',
        '0_z1_f5',
        '0_z2_z1',
        '0_z3_z2',
        '0_z4_z3',
        '0_z5_z4',
        '0_f2_f1',
        '0_f3_f2',
        '0_f4_f3',
        '0_f5_f4'
    );
    /**
     * 缩减范围数组
     *
     * @access public
     * @var array
     */
    var $_range = array(
        'range_0'=>0,
        'range_1'=>1,
        'range_2'=>2,
        'range_3'=>3,
    );

    /**
     * openingName 数组
     *
     * @access public
     * @var array
     */
    var $_openingName = array(
        'higher' => '99',
        'high'   => '0.01',
        'lower'  => '-99',
        'low'    => '-0.01'
    );
    /**
     * 涨幅状态数组
     * @access public
     * @var array
     */
    var $_states = array(
        'rise'=>1,
        'fall' => 0
    );

    /**
     * 微调值
     * @access public
     * @var integer
     */
    var $weitiao = '0.5';

    /**
     * 获取股票文件
     *
     * @access public
     * @param string $name 股票拼音名称
     * @return array 以数组的形式返回股票文件中的数据
     */
    public function getFile($name)
    {
        $file_path = 'gp\\' . $name . '.txt';

        if (file_exists($file_path)) {
            $data = file_get_contents($file_path);
            preg_match_all('/\s(.*),(.*),(.*),(.*),(.*),/', $data, $match);
        } else {
            echo 'Do not find the file';
        }

        foreach ($match[0] as $k => $v) {
            $one_data = explode(",", $v);
            if(!in_array($k,array(0,1,2,3,4))){
                $this->data[$k] = $this->key_name($one_data);}
        }
        $this->data = array_merge($this->data);

        return $this->data;
    }

    /**
     * 对股票数组data数据的键名进行规范
     *
     * @access public
     * @param array $one_data
     * @return array 返回替换键名的数组
     */
    public function key_name($one_data)
    {
        $new_key_data = [
            'date' => trim($one_data[0]),
            'opening_price' => $one_data[1],
            'ceiling_price' => $one_data[2],
            'lower_price' => $one_data[3],
            'closing_price' => $one_data[4],
            'volume' => $one_data[5]
        ];
        return $new_key_data;
    }

    /**
     * 将数据存入数据库
     * @access public
     * @param string $name 股票拼音名称
     */
    public function insertData($name)
    {
        //获取股票文件所形成的数组data
        $data = $this->getFile($name);

        //清空表
        $conn = $this->_em->getConnection();
        $sql = "truncate table $name";
        $state = $conn->prepare($sql);

        if ($ret = $state->execute()) {
            echo '成功清空';
        }

        foreach ($data as $k => $v) {
            $this->date = strtotime($v['date']);
            $this->time = $v['date'];
            $this->opening_price = $v['opening_price'];
            $this->ceiling_price = $v['ceiling_price'];
            $this->lower_price = $v['lower_price'];
            $this->closing_price = $v['closing_price'];
            $this->volume = $v['volume'];
            //计算涨幅
            $this->rose = $this->calculate_rose($k);
            //计算振幅
            $this->amplitude = $this->calculate_amplitude($k);
            //计算开盘涨幅
            $this->opening_ratio = $this->calculate_openingRatio($k);
            //计算最高价与当日开盘价的差值
            $this->ceiling_to_opening = $this->subtraction($this->ceiling_price, $this->opening_price);
            //计算最低价与当日开盘价的差值
            $this->lower_to_opening = $this->subtraction($this->opening_price, $this->lower_price);
            //计算最高价与当日开盘价的差值，比上开盘价
            $this->ceiling_ratio = $this->get_ratio($this->ceiling_price, $this->opening_price, $this->opening_price);
            //计算最低价与当日开盘价的差值，比上开盘价
            $this->lower_ratio = $this->get_ratio($this->lower_price, $this->opening_price, $this->opening_price);
            //获取连涨连跌的天数
            if ($k >= 2) {
                $this->count = $this->get_count($k);
            } else {
                $this->count = 0;
            }
            //获取昨日的连涨连跌的天数
            if ($k >= 2) {
                $this->pre_count = $this->get_count($k - 1);
            } else {
                $this->pre_count = 0;
            }
            //获取两天前的连涨连跌的天数
            if ($k >= 3) {
                $this->pre_two_count = $this->get_count($k - 2);
            } else {
                $this->pre_two_count = 0;
            }
            //获取三天前的连涨连跌的天数
            if ($k >= 4) {
                $this->pre_three_count = $this->get_count($k - 3);
            } else {
                $this->pre_three_count = 0;
            }
            $class_name = '\\AppBundle\\Entity\\'.ucfirst($name);
            $gp = new $class_name();
            $gp->setDate($this->date)
                ->setTime($this->time)
                ->setOpeningPrice($this->opening_price)
                ->setCeilingPrice($this->ceiling_price)
                ->setLowerPrice($this->lower_price)
                ->setClosingPrice($this->closing_price)
                ->setVolume($this->volume)
                ->setRose($this->rose)
                ->setAmplitude($this->amplitude)
                ->setOpeningRatio($this->opening_ratio)
                ->setCeilingToOpening($this->ceiling_to_opening)
                ->setLowerToOpening($this->lower_to_opening)
                ->setCeilingRatio($this->ceiling_ratio)
                ->setLowerRatio($this->lower_ratio)
                ->setCount($this->count)
                ->setPreCount($this->pre_count)
                ->setPreTwoCount($this->pre_two_count)
                ->setPreThreeCount($this->pre_three_count);
            $this->_em->persist($gp);
        }

        $this->_em->flush();

    }

    /**
     * 计算当日涨幅
     *
     * @access public
     * @param integer $k 股票数据data数组中的键位
     * @return string 返回当日涨幅
     */
    public function calculate_rose($k)
    {
        $data = $this->data;
        if ($k >= 1) {
            $rose = ($this->closing_price - $data[$k - 1]['closing_price']) / $data[$k - 1]['closing_price'];
        } else {
            $rose = 0;
        }
        $rose = (round($rose, 4) * 100);
        $rose = sprintf("%01.2f", $rose);
        return $rose;
    }

    /**
     * 计算当日振幅
     *
     * @access public
     * @return string 返回当日振幅
     */
    public function calculate_amplitude()
    {
        $amplitude = ($this->ceiling_price - $this->lower_price) / $this->closing_price;
        $amplitude = (round($amplitude, 4) * 100);
        $amplitude = sprintf("%01.2f", $amplitude);
        return $amplitude;
    }

    /**
     * 计算当日开盘涨幅
     *
     * @access public
     * @param integer $k 股票数据data数组中的键位
     * @return string 返回当日开盘涨幅
     */
    public function calculate_openingRatio($k)
    {
        if ($k >= 1) {
            $openingRatio = ($this->opening_price - $this->data[$k - 1]['closing_price']) / $this->data[$k - 1]['closing_price'];
            $openingRatio = (round($openingRatio, 4) * 100);
            $openingRatio = sprintf("%01.2f", $openingRatio);
            return $openingRatio;
        } else {
            return 0;
        }

    }

    /**
     * 计算差值
     *
     */
    public function subtraction($a, $b)
    {
        return round(($a - $b), 2);
    }

    /**
     * 计算比值
     *
     * @access public
     * @param integer $a 被减数
     * @param integer $b 减数
     * @param integer $c 被除数
     * @return string 返回百分比
     */
    public function get_ratio($a, $b, $c)
    {
        $data = ($a - $b) / $c;
        $data = (round($data, 4)) * 100;
        return sprintf("%01.2f", $data);
    }

    /**
     * 获取连续涨跌天数
     *
     * @access public
     * @param integer $k 股票数据data数组中的键位
     * return integer 返回连续涨跌天数
     */
    public function get_count($k)
    {
        $data = $this->data;
        if ($data[$k]['closing_price'] > $data[$k - 1]['closing_price']) {
            $rise_day = 0;
            for ($i = $k; $i > 0; $i--) {
                $D_value = $data[$i]['closing_price'] - $data[$i - 1]['closing_price'];
                if ($D_value >= 0) {
                    $rise_day++;
                } else {
                    break;
                }
            }
            return $rise_day;
        } elseif ($data[$k]['closing_price'] < $data[$k - 1]['closing_price']) {
            $decline_day = 0;
            for ($i = $k; $i > 0; $i--) {
                $D_value = $data[$i]['closing_price'] - $data[$i - 1]['closing_price'];
                if ($D_value <= 0) {
                    $decline_day++;
                } else {
                    break;
                }
            }
            return '-' . $decline_day;
        } else {
            return 0;
        }
    }

    /**
     *开盘价涨幅数据
     *
     * @access public
     * @param string $name 股票名称
     * @param integer $f 1为正0为负
     * @param integer $decrease 去掉最大和最小值的缩减范围
     * @param integer $year_range 年份
     */
    public function getOpening($name,$f = 1, $decrease,$year_range)
    {
        $integer = (-1)*(intval($year_range*365));
        $day_start = strtotime("$integer day");
        
        $conn = $this->_em->getConnection();
        if ($f) {
            $sql = "select opening_ratio from $name p where p.opening_ratio >0";
        } else {
            $sql = "select opening_ratio from $name p where p.opening_ratio <0";
        }
        if($integer != 0){
            $sql .=" and p.date > $day_start ";
        }
        $res = $conn->fetchAll($sql);
        $data = array();
        foreach ($res as $k => $v) {
            $data[] = $v['opening_ratio'];
        }
        sort($data);
        if ($decrease > 0) {
            $data = array_splice($data, $decrease, -$decrease);
        }
        $_data['average'] = sprintf("%01.2f", round((array_sum($data) / count($data)), 2));
        if ($f) {
            $_data['acme'] = round(end($data), 2);
        } else {
            $_data['acme'] = round(reset($data), 2);
        }
        $data['average'] = $_data['average'];
        $data['acme'] = $_data['acme'];
        return $data;
    }
    /**
     * 获得当日的价格
     *
     * @access public
     * @param string $name 预测的名称
     * @param integer $price 预测的开盘价格
     * @param string $field 低买还是高卖
     * @param integer $openingRatio_range 去除开盘涨幅最高最低范围
     * @param integer $year_range 数据统计的年份范围
     */
    public function getTodayPrice($name,$price,$field,$openingRatio_range,$year_range)
    {
        $conn = $this->_em->getConnection();
        //获得今日的日期
//        $date = strtotime("-1 day");
        $date = time();
        //获得其昨日的、两天前的、三天前的走势
        $sql = "select id,count,pre_count,pre_two_count from $name where date <$date ORDER BY id DESC limit 1";
        $trend = $conn->fetchAll($sql);
        //昨日收价

        $sql2 = "select closing_price from $name where date <$date ORDER BY id DESC limit 1 ";
        $yesterday = $conn->fetchAll($sql2);
        $yesterday_closingPrice = $yesterday[0]['closing_price'];
        $p = (($price-$yesterday_closingPrice)/$yesterday_closingPrice)*100;
        $opening_ratio = round($p,2);
        $pre_count = $trend[0]['count'];
        $pre_two_count = $trend[0]['pre_count'];
        $pre_three_count = $trend[0]['pre_two_count'];

        //上情况
        $state = 1;
        $situation['rise'] = $this->getAllKeyData($name,$field,$state,$price,$opening_ratio,$pre_count,$pre_two_count,$pre_three_count,$openingRatio_range,$year_range);
        //下情况
        $state = 0;
        $situation['fall'] = $this->getAllKeyData($name,$field,$state,$price,$opening_ratio,$pre_count,$pre_two_count,$pre_three_count,$openingRatio_range,$year_range);
//var_dump($situation);
        foreach($situation as $k =>$c){
            $count = count($c['three_day']['range_0']['history_data']['res']['date']);
            if($count<=4){
                $data[$k]['probability'] = $c['three_day']['range_0']['history_data']['probability'];
                $data[$k]['price'] = $c['three_day']['range_0']['forecast_data'][1];
                if($data[$k]['probability'] == 0){
                    $data[$k]['price'] = 0;
                }

            }elseif( $count>4 && $count<=6){
                    $data[$k]['price'] = $c['three_day']['range_1']['forecast_data'][1];
                    $data[$k]['probability'] = $c['three_day']['range_1']['history_data']['probability'];
                if($data[$k]['probability'] == 0){
                    $data[$k]['price'] = 0;
                }
            }elseif($count>6 && $count<=8){
                $data[$k]['price'] = $c['three_day']['range_2']['forecast_data'][1];
                $data[$k]['probability'] = $c['three_day']['range_2']['history_data']['probability'];
                if($data[$k]['probability'] == 0){
                    $data[$k]['price'] = 0;
                }
            }else{
                $data[$k]['price'] = $c['three_day']['range_3']['forecast_data'][1];
                $data[$k]['probability'] = $c['three_day']['range_3']['history_data']['probability'];
                if($data[$k]['probability'] == 0){
                    $data[$k]['price'] = 0;
                }
            }
        }
//        var_dump($situation);exit;
        return $data;

    }


    /**
     * 计算
     *
     * @access public
     * @param string $name 股票名称
     * @param string $field 需要查询的字段，需要字段类型为数字型
     * @param integer $state 当日涨跌状态，1为涨，0为跌，none为未知
     * @param integer $day 昨天连跌或连涨的天数
     * @param integer $day2 前天连涨或连跌的天数
     * @param integer $opening_ratio 开盘涨幅
     * @param integer $decrease 去掉最大值和最小值的范围
     * @param integer $year_range 年份范围
     * return array
     */
    public function analysis($name, $field, $state, $day, $day2,$day3, $opening_ratio, $decrease,$openingRatio_range,$year_range)
    {
        $integer = (-1)*(intval($year_range*365));
        $day_start = strtotime("$integer day");
        if($day3 == 'none'){
            $sql = "select $field ,date from $name p where p.pre_count = $day and p.pre_two_count=$day2";
        }else{
            $sql = "select $field ,date from $name p where p.pre_count = $day and p.pre_two_count=$day2 and p.pre_three_count=$day3";
        }
        if($integer != 0){
            $sql .=" and p.date > $day_start";
        }
        if ($state == 1 && $day > 0) {
            $count = $day + 1;
        } elseif ($state == 1 && $day < 0) {
            $count = 1;
        } elseif ($state == 0 && $day < 0) {
            $count = $day - 1;
        } elseif ($state == 0 && $day > 0) {
            $count = -1;
        }


        $sql .= " and p.count=$count";

        $conn = $this->_em->getConnection();
        $data1 = $this->opening_ratio_1 =  $this->getOpening($name,1, $openingRatio_range,$year_range);
        $data0 = $this->opening_ratio_0 =  $this->getOpening($name,0, $openingRatio_range,$year_range);

        //确定范围

        if ($opening_ratio != 'none') {
            if ($opening_ratio > 0 && $opening_ratio < $data1['average']) {
                $range = '0  AND ' . $data1['average'];
            } elseif ($opening_ratio > $data1['average']) {
                $range = $data1['average'] . ' AND ' . $data1['acme'];
            } elseif ($opening_ratio <= 0 && $opening_ratio >= $data0['average']) {
                $range = $data0['average'] . ' AND 0';
            } elseif ($opening_ratio <= $data0['average']) {
                $range = $data0['acme'] . ' AND ' . $data0['average'];
            }

            $sql .= " and p.opening_ratio BETWEEN $range";

        }

        //获取结果
        $res = $conn->fetchAll($sql);

        if ($res) {
            foreach ($res as $k => $v) {
                $data[$field][] = $v[$field];
                $data['date'][] = date('Y-m-d',$v['date']);
            }
            sort($data[$field]);
            sort($data['date']);
            if (count($data[$field]) > $decrease * 2 && $decrease != 0) {
                $data[$field] = array_splice($data[$field], $decrease, -$decrease);
                $data['date'] = array_splice($data['date'], $decrease, -$decrease);
            }

            $data['ratio'] = round((array_sum($data[$field]) / count($data[$field])), 2);
        } else {
            $data['date'] = 'no_data';
            $data['ratio'] = 'no_data';
        }

        return $data;
    }

    /**
     * 计算上涨下跌的概率
     *
     * @param string $name 股票名称
     * @param integer $state 当日涨跌状态，1为涨，0为跌，none为未知
     * @param integer $day 昨天连跌或连涨的天数
     * @param integer $day2 前天连涨或连跌的天数
     * @param integer $opening_ratio 开盘涨幅
     * @param integer $year_range 年份
     */
    public function probability($name, $state, $day, $day2,$day3, $opening_ratio,$year_range)
    {
        $integer = (-1)*(intval($year_range*365));
        $day_start = strtotime("$integer day");
        
        if($day3 == 'none'){
            $sql = "select * from $name p where p.pre_count = $day and p.pre_two_count=$day2";
        }else{
            $sql = "select * from $name p where p.pre_count = $day and p.pre_two_count=$day2 and p.pre_three_count=$day3";
        }
        if($integer != 0){
            $sql .=" and p.date > $day_start ";
        }
        $sql1 = $sql;

        if ($state == 1 && $day > 0) {
            $count = $day + 1;
        } elseif ($state == 1 && $day < 0) {
            $count = 1;
        } elseif ($state == 0 && $day < 0) {
            $count = $day - 1;
        } elseif ($state == 0 && $day > 0) {
            $count = -1;
        }
        $sql1 .= " and p.count=$count";

        $conn = $this->_em->getConnection();
        $data1 = $this->opening_ratio_1;
        $data0 = $this->opening_ratio_0;
        //确定开盘涨幅范围
        if ($opening_ratio != 'none') {
            if ($opening_ratio > 0 && $opening_ratio < $data1['average']) {
                $range = '0  AND ' . $data1['average'];
            } elseif ($opening_ratio > $data1['average']) {
                $range = $data1['average'] . ' AND ' . $data1['acme'];
            } elseif ($opening_ratio <= 0 && $opening_ratio >= $data0['average']) {
                $range = $data0['average'] . ' AND 0';
            } elseif ($opening_ratio <= $data0['average']) {
                $range = $data0['acme'] . ' AND ' . $data0['average'];
            }

            $sql .= " and p.opening_ratio BETWEEN $range";
            $sql1 .= " and p.opening_ratio BETWEEN $range";

        }

        //获取单独结果
        $res1 = $conn->fetchAll($sql1);
        //获取所有结果
        $res = $conn->fetchAll($sql);
        $count1 = count($res1);
        $count = count($res);
        if ($count && $count1 != 0) {
            $data = sprintf("%01.2f", round((($count1 / $count) * 100), 2)) . '%';
        } else {
            $data = '0';
        }
        return $data;
    }

    /**
     * 分多种情况来输出数据
     *
     * @access public
     * @param string $name 股票名称
     * @param string $field 最高价的比值ceiling_ratio还是最低价的比值
     * @param integer $state 当日涨跌趋势
     * @param integer $pre_count 昨日涨跌趋势
     * @param integer $pre_two_count 两天前涨跌趋势
     * @param integer $pre_three_count 三天前涨跌趋势
     * @param string $opening_ratio 开盘涨幅
     * @param integer $range 缩减范围，1为去掉1个最高值1个最低值，2为去掉2个最高值2个最低值，以此类推
     * @param integer $openingRatio_range 开盘指数缩减范围，1为去掉1个最高值1个最低值，2为去掉2个最高值2个最低值，以此类推
     * @param integer $year_range 几年内的数据
     * return array $data【res】或【probability】
     */
    public function getSituation($name, $field, $state, $pre_count, $pre_two_count, $pre_three_count, $opening_ratio, $range,$openingRatio_range,$year_range)
    {
        $data['res'] = $this->analysis($name,$field,$state,$pre_count,$pre_two_count,$pre_three_count,$opening_ratio,$range,$openingRatio_range,$year_range);
        $data['probability'] = $this->probability($name,$state,$pre_count,$pre_two_count,$pre_three_count,$opening_ratio,$year_range);
        return $data;
    }

    /**
     * 根据传来的开盘涨幅值来返回openingName，开盘涨幅名称
     *
     * @access public
     * @param integer $opening_ratio
     * @param integer $range 缩减范围
     * return string 开盘涨幅名称
     */
    public function getOpeningName($name,$opening_ratio,$range,$year_range)
    {
        $data1 = $this->getOpening($name,1, $range,$year_range);
        $data0 = $this->getOpening($name,0, $range,$year_range);
        //根据开盘涨幅范围确定名称
        if ($opening_ratio > 0 && $opening_ratio < $data1['average']) {
            $openingName = 'high';
        } elseif ($opening_ratio > $data1['average']) {
            $openingName = 'higher';
        } elseif ($opening_ratio < 0 && $opening_ratio > $data0['average']) {
            $openingName = 'low';
        } elseif ($opening_ratio < $data0['average']) {
            $openingName = 'lower';
        }
        return $openingName;
    }

    /**
     * 根据传来的当天开盘数值返回合理的切入点
     *
     * @access public
     * @param string $name 股票名称
     * @param integer $opening_price 开盘价格
     * @param integer $opening_ratio 开盘涨幅
     * @param integer $pre_count 昨日走势
     * @param integer $pre_two_count 两天前走势
     * @param integer $pre_three_count 三天前走势
     * return array 返回所有统计数据 $data[关键值名称$keyName]
     *                                       [历史数据history_data]
     *                                                          [字段名称]
     *                                                                [缩减幅度]
     *                                                                      [涨跌名称]
     *                                                                          [开盘涨幅名称]
     *                                                                                      【res】
     *                                                                                          [ratio] 和 [date]
     *                                                                                      【probability】
     *                                                                                 ['three_day'是否有第三天的数据]
     *                                                                                      【res】
     *                                                                                          [ratio] 和 [date]
     *                                                                                      【probability】
     *                                       [预测数据forecast_data]
     *                                                          [字段名称]
     *                                                               [缩减幅度]
     *                                                                  [涨跌名称]
     *                                                                      [开盘涨幅名称]
     *                                                                              【数值】
     *                                                                                 ['three_day'是否有第三天的数据]
     *                                                                               【数值】
     */
    public function getAllKeyData($name,$field,$state,$opening_price,$opening_ratio,$pre_count,$pre_two_count,$pre_three_count,$openingRatio_range,$year_range)
    {
        //关键值的名称
        $middleName = ($pre_count > 0 ? 'z' : 'f') . abs($pre_count);
        $lastName = ($pre_two_count > 0 ? 'z' : 'f') . abs($pre_two_count);
        $newKeyName =  $state.'_' . $middleName . '_' . $lastName;
        $_range = $this->_range;
        foreach($_range as $k=>$r){
            if($pre_three_count !='none'){
                if($field == 'ceiling_ratio'){
                    $data['name'] = $newKeyName;
                    $data['field'] = 'ceiling_ratio';
                    $data['three_day'][$k]['history_data'] = $this->getSituation($name, 'ceiling_ratio', $state, $pre_count, $pre_two_count, $pre_three_count, $opening_ratio,$r,$openingRatio_range,$year_range);
                    $data['three_day'][$k]['forecast_data'] = $this->getCeilingPrice($opening_price,$data['three_day'][$k]['history_data']['res']['ratio']);
                    $data['two_day'][$k]['history_data'] = $this->getSituation($name, 'ceiling_ratio', $state, $pre_count, $pre_two_count, $pre_three_count, $opening_ratio,$r,$openingRatio_range,$year_range);
                    $data['two_day'][$k]['forecast_data'] = $this->getCeilingPrice($opening_price,$data['two_day'][$k]['history_data']['res']['ratio']);

                }else{
                    $data['name'] = $newKeyName;
                    $data['field'] = 'lower_ratio';
                    $data['three_day'][$k]['history_data'] = $this->getSituation($name, 'lower_ratio', $state, $pre_count, $pre_two_count, $pre_three_count, $opening_ratio,$r,$openingRatio_range,$year_range);
                    $data['three_day'][$k]['forecast_data'] = $this->getLowerPrice($opening_price,$data['three_day'][$k]['history_data']['res']['ratio']);
                    $data['two_day'][$k]['history_data'] = $this->getSituation($name, 'lower_ratio', $state, $pre_count, $pre_two_count, $pre_three_count, $opening_ratio,$r,$openingRatio_range,$year_range);
                    $data['two_day'][$k]['forecast_data'] = $this->getLowerPrice($opening_price,$data['two_day'][$k]['history_data']['res']['ratio']);
                }
            }else{
                if($field == 'ceiling_ratio'){
                    $data['name'] = $newKeyName;
                    $data['field'] ='ceiling_ratio';
                    $data['two_day'][$k]['history_data'] = $this->getSituation($name, 'ceiling_ratio', $state, $pre_count, $pre_two_count, $pre_three_count, $opening_ratio,$r,$openingRatio_range,$year_range);
                    $data['two_day'][$k]['forecast_data'] = $this->getCeilingPrice($opening_price,$data['two_day'][$k]['history_data']['res']['ratio']);
                }else{
                    $data['name'] = $newKeyName;
                    $data['field'] = 'lower_ratio';
                    $data['two_day'][$k]['history_data'] = $this->getSituation($name, 'lower_ratio', $state, $pre_count, $pre_two_count, $pre_three_count, $opening_ratio,$r,$openingRatio_range,$year_range);
                    $data['two_day'][$k]['forecast_data'] = $this->getLowerPrice($opening_price,$data['two_day'][$k]['history_data']['res']['ratio']);
                }
            }
        }

        return $data;
    }

    /**
     * 获取全部数据
     *
     * @access public
     * @param string $name
     * @param integer $page
     * @param integer $page_size
     * return array 数据数组，如果传来的$page和page_size全部是none,那么就只传一个data数组，如果有页码和行数，则传data数组以及页码html
     */
    public function getAllData($name,$page = 'none',$page_size='none',$url = 'none',$search = '')
    {
        $conn = $this->_em->getConnection();
        $sql = "select count(id) from $name";
        $sql2 = "select * from $name";
        if($search){
            $range_1 = strtotime("$search -10 day");
//            var_dump($range_1);
//            var_dump(date('Y-m-d',$range_1));
            $range_2 = strtotime("$search +10 day");
//            var_dump($range_2);
//            var_dump(date('Y-m-d',$range_2));
            $sql2 .= " where date between $range_1 and $range_2";
            $sql .= " where date between $range_1 and $range_2";
        }

        $res = $conn->fetchAll($sql);
        $rows_count = $res[0]['count(id)'];
        if($page != 'none' && $page>0){
            $start = ($page-1)*$page_size;
            $sql2 .= " ORDER BY id DESC  LIMIT $start,$page_size";
            $page = $this->getPage($rows_count,$page,$page_size,$url);
        }else{
            echo 'You forget set page and page_size';exit;
        }

        $data['page'] = $page;
        $data['data'] = $conn->fetchAll($sql2);
        return $data;
    }

    /**
     * 生成分页html，所使用的url必须是 /页码/每页记录数 的格式
     *
     * @access public
     * @param integer $rows 数据总数量
     * @param integer $page_size 每页显示条数
     * @param string $url 翻页跳转页面时去往的地址
     * return string 页码HTML
     */
    public function getPage($rows_count,$page,$page_size,$url)
    {
        $page_count = ceil($rows_count/$page_size);
        if($page <= 1 || $page == '') $page = 1;
        if($page >= $page_count) $page = $page_count;
        $pre_page = ($page == 1)? 1 : $page - 1;
        $next_page= ($page == $page_count)? $page_count : $page + 1 ;
        $pagenav = '';
        $pagenav .= '<div class="dataTables_info" id="DataTables_Table_1_info">第 '.$page.'/'.$page_count.' 页 共 '.$rows_count.' 天记录 ';
        $pagenav.='跳到<select name="topage" size="1" onchange="window.location=\''.$url.'/\'+this.value+\'/'.$page_size.'\'">\n';
        for($i=1;$i<=$page_count;$i++){
            if($i==$page) $pagenav.="<option value='$i' selected>$i</option>\n";
            else $pagenav.="<option value='$i'>$i</option>\n";
        }
        $pagenav .='</select>';
        $pagenav .='</div>';
        $pagenav .='<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">';
        $pagenav .= '<a  tabindex="0" class="first paginate_button" id="DataTables_Table_1_first" href="'.$url.'/1/'.$page_size.'">第一页</a> ';
        $pagenav .= '<a  tabindex="0" class="previous paginate_button " id="DataTables_Table_1_previous" href="'.$url.'/'.$pre_page.'/'.$page_size.'">前一页</a> ';
        $pagenav .= '<a tabindex="0" class="next paginate_button" id="DataTables_Table_1_next" href="'.$url.'/'.$next_page.'/'.$page_size.'">后一页</a>';
        $pagenav .= '<a  tabindex="0" class="last paginate_button" id="DataTables_Table_1_last" href="'.$url.'/'.$page_count.'/'.$page_size.'">&nbsp;末页</a>';
        $pagenav .='</div>';

        return $pagenav;

    }

    /**
     * 获得预测数据
     *
     * @access public
     * @param integer $opening_price 开盘价格
     * @param integer $ceiling_ratio 高卖点比值
     * @param integer $lower_ratio 低卖点比值
     * return array $data 数组构成[ceiling_price]
     *                            [lower_price]
     */
    public function getForecastData($opening_price,$ceiling_ratio,$lower_ratio)
    {
        $data['ceiling_price'] = $this->getCeilingPrice($opening_price,$ceiling_ratio);
        $data['lower_price']   = $this->getLowerPrice($opening_price,$lower_ratio);
        return $data;
    }
    /**
     * 根据传来的数值，计算出高卖点
     *
     * @access public
     *
     * @param integer $opening_price
     * @param integer $ceiling_ratio
     * return integer 返回高卖点数值
     */
    public function getCeilingPrice($opening_price,$ceiling_ratio)
    {
        $res[0] = $opening_price+($opening_price*$ceiling_ratio)/100;
        $res[1] = $opening_price+($opening_price*($ceiling_ratio-$this->weitiao))/100;
        $res[0] = round($res[0],2);
        $res[1] = round($res[1],2);
        return $res;
    }

    /**
     * 根据传来的数值，计算出高卖点
     *
     * @access public
     *
     * @param integer $opening_price
     * @param integer $lower_ratio
     * return integer 返回高卖点数值
     */
    public function getLowerPrice($opening_price,$lower_ratio)
    {
        $res[0] = $opening_price+($opening_price*$lower_ratio)/100;
        $res[1] = $opening_price+($opening_price*($lower_ratio+$this->weitiao))/100;

        $res[0] = round($res[0],2);
        $res[1] = round($res[1],2);
        return $res;
    }
}