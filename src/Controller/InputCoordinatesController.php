<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Coords;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InputCoordinatesController extends AbstractController
{
    #[Route('/input/coordinates', name: 'input_coordinates')]
    public function index(): Response
    {
        return $this->render('input_coordinates/index.html.twig', [
            'controller_name' => 'InputCoordinatesController',
        ]);
    }

    #[Route('/input/coordinates/view', name: 'getCoordss')]
    public function getCoordinatesAttribute(ManagerRegistry $doctrine,Request $request)
    {
        $url = $request->get('link') ;
            $url_coordinates_position = strpos($url, '@') + 1;
            $coordinates = [];

            if ($url_coordinates_position != false) {
                $coordinates_string = substr($url, $url_coordinates_position);
                $coordinates_array = explode(',', $coordinates_string);

                if (count($coordinates_array) >= 2) {
                    $longitude = $coordinates_array[0];
                    $latitude = $coordinates_array[1];

                    $coordinates = [
                        "longitude" => $longitude,
                        "latitude" => $latitude
                    ];
                }
                $coords = new Coords();
                $coords->setLat($latitude);
                $coords->setLon($longitude);
                $coords->setAddedAt(new \DateTime());

                $em=$doctrine->getManager();
                $em->persist($coords);
                $em->flush();

                return $this->render('input_coordinates/view.html.twig', [
                    'lat' => $coordinates['latitude'],
                    'lot' => $coordinates['longitude']
                ]);

            }


    }
    #[Route('/input/coordinates/view/{link}', name: 'getCoords')]
    public function linkcoord(ManagerRegistry $doctrine,string $link){

        $url=$link;
        $lon=substr($url, 0,-11 );  // returns "abcde"
        $lat=substr($url, -10 );  // returns "abcde"

        $coords = new Coords();
        $coords->setLat($lat);
        $coords->setLon($lon);
        $coords->setAddedAt(new \DateTime());

        $em=$doctrine->getManager();
        $em->persist($coords);
        $em->flush();

//        $cor= $doctrine->getRepository(Coords::class)->findOneBy(['id'=>$coords->getId()]);
//
//        return json_encode($cor);
//
        return $this->render('input_coordinates/view.html.twig',[
        'lon'=> $lon,
        'lat'=> $lat
                ]);
    }
}
