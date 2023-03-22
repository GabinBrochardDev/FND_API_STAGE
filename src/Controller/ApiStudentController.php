<?php

namespace App\Controller;

use App\Service\ApiKeyService;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ApiStudentController extends AbstractController
{
    /**
     * @Route(
     * "/api/student", 
     * name="app_api_student",
     * methods={"GET"}
     * )
     */
    public function index( StudentRepository $studentRepository, NormalizerInterface $normalizer, ApiKeyService $apiKeyService, Request $request): JsonResponse
    {
        $authorized = $apiKeyService->checkApiKey($request);
        //dd($authorized);
        if ($authorized)
        {
        // Récupérer TOUS les étudiants
        $students = $studentRepository->findAll();

        // Sérialisation au format JSON
        $json = json_encode($students);
        // Ne va pas fonctionner car les attributs sont en private
        // Il faut normaliser!

        // https://stackoverflow.com/questions/44286530/symfony-3-2-a-circular-reference-has-been-detected-configured-limit-1
        // $studentsNormalised = $normalizer->normalize($students);
        $studentsNormalised = $normalizer->normalize($students,'json',['circular_reference_handler' => function ($object) { return $object->getId(); } ]);

        // dd($students);
        dd($students, $json, $studentsNormalised);


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiStudentController.php',
        ]);
    }
        else
        {
            dd("API-KEY invalid");
        }

    }

    /**
     * @Route(
     * "/api/student",
     * name="app_api_student_add",
     * methods={"POST"}
     * )
     */
    public function add( Request $request, EntityManagerInterface $entityManager ): JsonResponse
    {
        // On attend une requête au format json (Content-Type application/json)
        // TODO : verifier le Content-Type
        // Récupération du body 
        // dd($request->toArray());

        // On stocke le body de la requête $dataFromRequest
        $dataFromRequest = $request->toArray();

        // **************************************

        // Ici, les données ont été verifiées, on peut créer une nouvelle instance de Student
        $student = new Student();
        $student->setName( $dataFromRequest['name'] );
        $student->setFirstName( $dataFromRequest['firstName'] );
        $student->setPicture( $dataFromRequest['picture'] );
        $student->setDateOfBirth( new DateTime($dataFromRequest['date_of_birth']) );
        $student->setGrade( $dataFromRequest['grade'] );

        // dd($student);

        // insertion en base de l'instance student
        $entityManager->persist( $student );
        $entityManager->flush();

        return $this->json([
            'status' => 'Ajout OK'
        ]);
    }
}
