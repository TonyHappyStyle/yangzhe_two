<?php
namespace AppBundle\Controller;
/**
 * Created by PhpStorm.
 * User: Yangzhe
 * Date: 2018/2/7
 * Time: 21:11
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WelcomeController extends Controller{
    /**
     * @Route("/",name="_welcome")
     */
    public function indexAction()
    {
        $articles = array(0=>array('title'=>'幸运数字哦！','authorName'=>'zhe','body'=>'my article'));
        return $this->render('article/list.html.twig',array('articles'=>$articles));
    }
}