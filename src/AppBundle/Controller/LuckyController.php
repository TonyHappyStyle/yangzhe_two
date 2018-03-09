<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number/{count}",name="lucky_number")
     */
    public function numberAction($count)
    {
        for($i=0;$i<$count;$i++){
            $numbers[] =mt_rand(0,100);
        }
        $numbersList = implode(',',$numbers);
        /*$html = $this->container->get('templating')->render(
            'lucky/number.html.twig',
            array('luckyNumberList' => $numbersList)
        );
        return new Response($html);*/
//        return new Response(
//            '<html><body>Lucky numbers: ' . $numbersList . '</body></html>'
//        );
        return $this->render(
            'lucky/number.html.twig',
            array('luckyNumberList' => $numbersList,'title'=>'yangzhe')
        );
    }

    /**
     * @Route("/api/lucky/number")
     */
    public function apiNumberAction()
    {
        $data = array(
            "number" => mt_rand(0,100)
        );
        return new JsonResponse($data);
    }

}