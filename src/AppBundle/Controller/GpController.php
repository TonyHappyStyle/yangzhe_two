<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Zbgf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Implement\ControllerImplement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;

class GpController extends  ControllerImplement
{
    /**
     * 所有股票的快捷预测窗口
     *
     * @access public
     * @Route("/gp/all_stock", name="all_stock")
     */
    public function allStockAction(Request $request)
    {
        $session = $request->getSession();
        $openingRatio_range = $request->get('openingRatio_range');
        $year_range = $request->get('year_range');
        if($year_range != 'none'){
            $session->set('year_range',$year_range);
        }else{
            $session->set('year_range',1);
        }

        if($openingRatio_range != 'none'){
            $session->set('openingRatio_range',$openingRatio_range);
        }else{
            $session->set('openingRatio_range',0);
        }

        $zbgf_price = $request->get('zbgf_price',0);
        $gldq_price = $request->get('gldq_price',0);
        $hxxf_price = $request->get('hxxf_price',0);
        $mdjt_price = $request->get('mdjt_price',0);

        $field      = $request->get('field');
        $range      = $request->get('range');
        $data = array();
        if($zbgf_price){
            $zbgf = $this->getDoctrine()->getRepository('AppBundle:Zbgf');/* @var $zbgf \AppBundle\Implement\GpImplement */
            $data['zbgf'] =  $zbgf->getTodayPrice('zbgf',$zbgf_price,$field,$range,$openingRatio_range,$year_range);
        }
        if($gldq_price){
            $gldq = $this->getDoctrine()->getRepository('AppBundle:Gldq');/* @var $gldq \AppBundle\Implement\GpImplement */
            $data['gldq'] = $gldq->getTodayPrice('gldq',$gldq_price,$field,$range,$openingRatio_range,$year_range);
        }
        if($hxxf_price){
            $hxxf = $this->getDoctrine()->getRepository('AppBundle:Hxxf');/* @var $hxxf \AppBundle\Implement\GpImplement */
            $data['hxxf'] = $hxxf->getTodayPrice('hxxf',$hxxf_price,$field,$range,$openingRatio_range,$year_range);
        }
        if($mdjt_price){
            $mdjt = $this->getDoctrine()->getRepository('AppBundle:Hxxf');/* @var $mdjt \AppBundle\Implement\GpImplement */
            $data['mdjt'] = $mdjt->getTodayPrice('mdjt',$mdjt_price,$field,$range,$openingRatio_range,$year_range);
        }
        var_dump($data);
//        exit;
            if(!$data){
                $data = 0;
            }
            return $this->render('gp/allStock.html.twig',array('data'=>$data,'zbgf_price'=>$zbgf_price,'gldq_price'=>$gldq_price,'hxxf_price'=>$hxxf_price,'mdjt_price'=>$mdjt_price,'year_range'=>$year_range,'field'=>$field,'openingRatio_range'=>$openingRatio_range));
    }

    /**
     * 提供基本面的数据，如涨幅、振幅等
     * Matches /blog exactly /
     * @access public
     * @Route("/gp/{name}/{page}/{page_size}", name="gp",
     * requirements={
     *          "page":"\d+",
     *          "page_size":"\d+"
     * })
     */
    public function listAction($name,$page='none',$page_size = 'none',Request $request)
    {
        $search = $request->get('search');
        $url = $this->generateUrl('gp',array('name'=>$name));
        $name_uc = ucfirst($name);
        $gp = $this->getDoctrine()->getRepository('AppBundle:'.$name_uc);/* @var $gp \AppBundle\Implement\GpImplement */
        $data = $gp->getAllData($name,$page,$page_size,$url,$search);

        if(!$gp) {
            throw $this->createNotFoundException(
                'something is wrong!'
            );
        }
        $gp = $data['data'];
        foreach($gp as $g=>$p)
        {
            $gp[$g]['date'] = date('Y-m-d',$p['date']);
        }
        $page = $data['page'];
        return $this->render('gp/gp.html.twig',array(
            'gp'=>$gp,'page'=>$page,'name'=>$name
        ));

    }

    /**
     * 各类数值统计一览
     *
     * @access public
     * @Route("/gp/{name}/allData", name ="gp_data")
     */
    public function allDataAction($name,Request $request)
    {
        $name_uc = ucfirst($name);
        $opening = $this->getDoctrine()->getRepository('AppBundle:'.$name_uc);
        /* @var $opening \AppBundle\Implement\GpImplement */

        $openingRatio_range = $request->get('range');

        if(!$openingRatio_range && $openingRatio_range != 0){
            $session = $request->getSession();
            $openingRatio_range = $session->get('openingRatio_range');
        }
        $year_range = $request->get('year_range');
        if(!$year_range && $year_range != 0){
            $session = $request->getSession();
            $year_range = $session->get('year_range');
        }
        //开盘价格
        $data0 = $opening->getOpening($name,0,$openingRatio_range,$year_range);
        $data1 = $opening->getOpening($name,1,$openingRatio_range,$year_range);
        return $this->render('gp/all_data.html.twig',array(
            'data1'=>$data1,'data0'=>$data0,'name'=>$name,'openingRatio_range'=>$openingRatio_range,'year_range'=>$year_range
        ));
    }

    /**
     * 高卖，展示各种情况下的历史最高价比
     *
     * @access public
     * @param integer $state 涨跌状态，1为涨，0为跌
     * @param float $opening_ratio 开盘涨幅
     * @param float $range 去掉最大值最小值的范围
     * @Route("/gp/{name}/getRatio", name="get_ratio")
     */
    public function getRatioAction($name,Request $request)
    {
        $name_uc = ucfirst($name);
        $dq = $this->getDoctrine()->getRepository('AppBundle:'.$name_uc);/* @var $dq \AppBundle\Implement\GpImplement */
        //获取参数

        //新参数opening_price 开盘价格
        $opening_price = $request->get('opening_price');
        //新参数opening_ratio 开盘涨幅
        $opening_ratio  = $request->get('opening_ratio');
        //新参数pre_count 昨日走势
        $pre_count  = $request->get('pre_count');

        //新参数pre_two_count 两天前走势
        $pre_two_count = $request->get('pre_two_count');
        //新参数pre_three_count 三天前走势
        $pre_three_count = $request->get('pre_three_count');
            $name = $request->get('gp_name','zbgf');

        $session = $request->getSession();
        $openingRatio_range = $session->get('openingRatio_range');
        $field = $request->get('field');
        $year_range = $request->get('year_range');

        $data['jinrishangzhang'] = $dq->getAllKeyData($name,$field,1,$opening_price,$opening_ratio,$pre_count,$pre_two_count,$pre_three_count,$openingRatio_range,$year_range);
        $data['jinrixiadie'] =$dq->getAllKeyData($name,$field,0,$opening_price,$opening_ratio,$pre_count,$pre_two_count,$pre_three_count,$openingRatio_range,$year_range);
//        var_dump($data);
//        exit;
if(array_key_exists('three_day',$data['jinrishangzhang'])){
    return $this->render('gp/getThreeRatio.html.twig',array(
        'datas'=>$data,'name'=>$name,'openingRatio_range'=>$openingRatio_range,'year_range'=>$year_range
    ));
}else{
    return $this->render('gp/getTwoRatio.html.twig',array(
        'datas'=>$data,'name'=>$name,'openingRatio_range'=>$openingRatio_range,'year_range'=>$year_range
    ));
}

    }

    /**
     * 添加基本五大信息：日期、开盘价格、最高价格、最低价格、收盘价格
     *
     * @access pubic
     * @Route("/insert/{name}",name="insert_data")
     */
    public function insertAction($name)
    {
        $uc_name = ucfirst($name);
        $repo = $this->getDoctrine()
            ->getRepository('AppBundle:'.$uc_name);
        /* @var $repo \AppBundle\Implement\GpImplement */
        $repo->insertData($name);

        return $this->redirectToRoute('gp',
            array('name'=>$name,'page'=>1,'page_size'=>100));
    }
}