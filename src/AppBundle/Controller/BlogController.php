<?php
/**
 * Created by PhpStorm.
 * User: Yangzhe
 * Date: 2018/2/7
 * Time: 9:06
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends  Controller
{
    /**
     * Matches /blog exactly /
     *
     * @Route("/blog/{slug}", name="blog_list",requirements={"page":"\d+"})
     */
    public function listAction($page =1)
    {
        return new Response(
            '<html><body>List'.$page.'</body></html>'
        );
    }

    /**
     * @Route(
     *         "/articles/{_locale}/{year}/{slug}.{_format}",
     *         defaults={"_format": "html"},
     *         name="blog_show",
     *         requirements={
     *              "_locale": "en|fr",
     *              "_format": "html|rss",
     *              "year": "\d+"
     *          }
     * )
     */
    public function showAction($_locale, $year, $slug,Request $request)
    {
        // /blog/my-blog-post
//        $url = $this->generateUrl(
//            'blog_show',
//            array('_locale'=>'fr','year'=>1992,'slug' => 'my-blog-post')
//        );
        $page = $request->query->get('page');
        if (!$page){
//            $message = $this->getParameter('app.config.config.imports');

            throw new \Exception('Something went wrong!');
//            throw new \Exception($message);
//            throw $this->createNotFoundException('The product does not exist');
        }
        $url = $this->get('router')->generate(
            'blog_list',
            array(
             'slug' => $page,
             'category' => 'Symfony'
            ),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        // or, in Twig / 或者在Twig中
// {{ path('blog_show', {'slug': 'slug-value'}) }}


        if($page>5){
            return $this->redirectToRoute(
                'lucky_number',
                array('count' => $page));
        }
        $session = $request->getSession();

//        $session->set('foo','bar');
//        $url = $this->generateUrl(
//            'blog_list',
//            array('slug'=>2,'category'=>'Symfony')
//        );

        $foobar = $session->get('foo','default');
        $this->addFlash(
            'notice',
            $foobar
        );
        $this->addFlash(
            'error',
            'I`m wrong'
        );
        if($page == 3){
            return new Response(
    //            '<html><body>Show'.$_locale.$year.$slug.'</body></html>'
                '<html><body>'.$url.'--'.$foobar.'</body></html>'
            );
        }
        return $this->render('blog/show.html.twig',array(
            'myMessages'=>array(1,2,3,4,5,6,7)
        ));
    }
}