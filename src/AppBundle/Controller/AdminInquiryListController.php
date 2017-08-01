<?php 

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AdminInquiryListController extends Controller
{
    /**
     * @Route("/admin/inquiry")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $inquiryRepository = $em->getRepository('AppBundle:Inquiry');
        $inquiryList = $inquiryRepository->findAll([], ['id' => 'DESC']);
        
        return $this->render('Admin/Inquiry/index.html.twig', ['inquiryList' => $inquiryList]); 
    } 
}
