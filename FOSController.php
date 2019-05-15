<?php

namespace App\Controller;

abc
abc develop 525
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
//sensio bundle

use Sensio\Bundle\FrameworkExtraBundle;
use FOS\RestBundle\Controller\Annotations\View as Viewanno;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use FOS\RestBundle\View\View as FOSView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

SD debugo

class FOSController extends FOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Get("/admin/testfos/{id}")
     * @View("admin/testFOS.html.twig")
     */
    public function getAction($id)
    {
        $user = new User();
        $user = $this->entityManager->getRepository(Product::class)->find($id);
        if (null === $user) {
            throw new NotFoundHttpException();
        }

        // $view->setTemplate("admin/testFOS.html.twig");

        // $view->setData($user);
        return $user;
    }
    /**
     *  @Post("/admin/testfospost")
     *@View(serializerGroups={"pass"})
     */
    public function postUserAction(Request $request)
    {
        $user = new User();
        $data = !empty($request->getContent()) ? json_decode($request->getContent(), true) : $request->query->all();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->submit($data);
        if ($form->isValid()) {

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return Common::response($user, Response::HTTP_CREATED);
        }


        return $form;
    }
}