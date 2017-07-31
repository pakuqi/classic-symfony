<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{

  public function latestListAction() {
    //Get EntityManager
    $em = $this->getDoctrine()->getManager();
    //Get Entity repository
    $blogArticleRepository = $em->getRepository('AppBundle:BlogArticle');
    //Get data from DB
    $blogList = $blogArticleRepository->findBy([], ['targetDate' => 'DESC']);

    // $blogList = [
    //   [
    //     'targetDate' => '2015年3月15日',
    //     'title' => '東京公演レポート',
    //   ],
    //   [
    //     'targetDate' => '2015年2月8日',
    //     'title' => '最近の練習風景',
    //   ],
    //   [
    //   'targetDate' => '2015年1月3日',
    //   'title' => '今年もよろしくお願いいたします',
    //   ],
    // ];

    return $this->render('Blog/latestList.html.twig', ['blogList' => $blogList]);
  }
}
