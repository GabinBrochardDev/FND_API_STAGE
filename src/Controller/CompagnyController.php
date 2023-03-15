<?php

namespace App\Controller;

use App\Entity\Compagny;
use App\Repository\CompagnyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CompagnyController extends AbstractController
{
    /**
     * @Route(
     *  "/api/compagny",
     *  name="app_compagny",
     *  methods={"GET"}
     * )
     */
    public function index( CompagnyRepository $CompanyRepository, NormalizerInterface $normalizer ): JsonResponse
    {
        // Récupérer TOUS les entreprise
        $company = $CompanyRepository->findAll();

        // Sérialisation au format JSON
        $json = json_encode($company);
        // Ne va pas fonctionner car les attributs sont en private
        // Il faut normaliser!

        // https://stackoverflow.com/questions/44286530/symfony-3-2-a-circular-reference-has-been-detected-configured-limit-1
        // $CompanyNormalized = $normalizer->normalize($company);
        $CompanyNormalized = $normalizer->normalize($company,'json',['circular_reference_handler' => function ($object) { return $object->getId(); } ]);

        dd($company, $json, $CompanyNormalized);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CompagnyController.php',
        ]);
    }

    /**
     * @Route(
     * "/api/compagny",
     * name="app_api_comany_add",
     * methods={"POST"}
     * )
     */
    public function add( Request $request, EntityManagerInterface $entityManager ):JsonResponse
    {
        // On attend une requête au format json (Content-Type application/json)
        // TODO : verifier le Content-Type
        // Récupération du body 
        // dd($request->toArray());

        // On stocke le body de la requête $dataFromRequest
        $dataFromRequest = $request->toArray();

        // **************************************

        // Ici, les données ont été verifiées, on peut créer une nouvelle instance de Student
        $company = new Compagny();
        $company->setName( $dataFromRequest['name'] );
        $company->setStreet($dataFromRequest['street']);
        $company->setZipcode($dataFromRequest['zipcode']);
        $company->setCity( $dataFromRequest['city']);
        $company->setWebsite($dataFromRequest['website']);
        
        //  Insertion en vase de l'instance student
        $entityManager->persist( $company );
        $entityManager->flush();

        return $this->json([
            'status' => 'Ajout OK'
        ]);
    }

}
