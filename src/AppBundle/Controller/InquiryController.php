<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Inquiry;

/**
* @Route("/inquiry")
*/
class InquiryController extends Controller
{
  /**
  * @Route("/")
  * @Method("get")
  */
  public function indexAction() {
      return $this->render('Inquiry/index.html.twig', ['form' => $this->createInquiryForm()->createView()]);
  }

  /**
   * @Route("/")
   * @Method("post")
   */
  public function indexPostAction(Request $request)
  {
      //Get difinition of Form
      $form = $this->createInquiryForm();
      //Import sending data to form
      $form->handleRequest($request);
      if ($form->isValid())
      {
          //Get Entity Data from form
          $inquiry = $form->getData();

          //Get EntityManager
          $em = $this->getDoctrine()->getManager();
          //Doctrine manage Entity
          $em->persist($inquiry);
          //Reflect on DB
          $em->flush();

          $message = \Swift_Message::newInstance()->setSubject('Webサイトからのお知らせ')
                                                  ->setFrom('webmaster@exmaple.com')
                                                  ->setTo('admin@example.com')
                                                  ->setBody($this->render('mail/inquiry.txt.twig', ['data' => $inquiry]));
          $this->get('mailer')->send($message);
          return $this->redirect($this->generateUrl('app_inquiry_complete'));
      }
      else
      {
        return $this->render('Inquiry/index.html.twig', ['form' => $form->createView()]);
      }
  }

  /**
   * @Route("/complete")
   */
  public function completeAction()
  {
    return($this->render('Inquiry/complete.html.twig'));
  }

  private function createInquiryForm()
  {
      return $this->createFormBuilder(new Inquiry())
      ->add('name', 'text')
      ->add('email', 'text')
      ->add('tel', 'text', [
          'required' => false,
      ])
      ->add('type', 'choice', [
          'choices' => [
              '公演について',
              'その他',
          ],
          'expanded' => true,
      ])
      ->add('content', 'textarea')
      ->add('submit', 'submit', [
          'label' => '送信',
      ])
      ->getForm();
  }
}
