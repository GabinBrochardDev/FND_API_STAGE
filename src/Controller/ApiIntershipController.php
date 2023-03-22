<?php

namespace App\Controller;

use App\Entity\Compagny;
use App\Entity\Intership;
use App\Entity\Student;
use App\Repository\IntershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use DateTime;

class ApiIntershipController extends AbstractController
{
    /**
     * @Route(
     * "/api/intership", 
     * name="app_api_intership",
     * methods={"GET"}
     * )
     */
    public function index( IntershipRepository $intershipRepository, NormalizerInterface $normalizer ): JsonResponse
    {

        // Récupérer tous les stages
        $intership = $intershipRepository->findAll();

        // Sérialisation au format JSON
        $json = json_encode( $intership );

        // $intershipNormalised = $normalizer->normalize( $intership );
        $intershipNormalised = $normalizer->normalize($intership,'json',['circular_reference_handler' => function ($object) { return $object->getId(); } ]);

        dd( $intership, $json, $intershipNormalised );

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiIntershipController.php',
        ]);
    }

    /**
     * @Route(
     * "/api/intership", 
     * name="app_api_intership_add",
     * methods={"POST"}
     * )
     */
    public function add( Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // On attend une requête au format json (Content-Type application/json)
        // TODO : verifier le Content-Type
        // Récupération du body 
        // dd($request->toArray());

        // On stocke le body de la requête $dataFromRequest
        $dataFromRequest = $request->toArray();

        // **************************************

        // Ici, les données ont été verifiées, on peut créer une nouvelle instance de Intership
        $intership = new Intership();
        // https://symfony.com/doc/current/doctrine.html#fetching-objects-from-the-database
        $intership->setIdStudent( $entityManager->getRepository(Student::class)->find($dataFromRequest['student_id']) );
        $intership->setIdCompany( $entityManager->getRepository(Compagny::class)->find($dataFromRequest['company_id']) );
        $intership->setStartDate( new DateTime($dataFromRequest['start_date']) );
        $intership->setEndDate( new DateTime($dataFromRequest['end_date']) );

        // insertion en base de l'instance student
        $entityManager->persist( $intership );
        $entityManager->flush();

        return $this->json([
            'status' => 'Ajout OK'
        ]);
    }
}
