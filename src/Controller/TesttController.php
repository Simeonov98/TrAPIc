<?php

namespace App\Controller;

use App\Entity\Coords;
use App\Entity\Section;
use Coderjerk\BirdElephant\BirdElephant;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isNull;

class TesttController extends AbstractController
{
    #[Route('/api/coords', name: 'api_test', methods: 'GET')]
    public function coooords(ManagerRegistry $doctrine, Request $request)
    {
        $par_lat_start= floatval($request->query->get('lat'));
        $par_lon_start=floatval($request->query->get('lon'));
        $par_rad=floatval($request->query->get('rad'));
        if ($par_lat_start!=''&&$par_lon_start!=''&&$par_rad!=''){
            return $this->json('Bad Request: One or more of the parameters are not formatted correctly. The correct format is:lat=\'xx.xxxxxxx\'&lon=\'xx.xxxxxxx\'&rad=\'x\'',400);
        }
        $arr = array();
        $h1=$doctrine->getRepository(Section::class)->findAll();
        foreach ($h1 as $item) {

            if($this->haversineGreatCircleDistance($par_lat_start,$par_lon_start,$item->getLatStart(),$item->getLonStart())<=$par_rad){
                array_push($arr,$item);
            }
        }
        return $this->json($arr,200);
    }

    function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }


    #[Route('/api', name: 'api')]
    public function api(ManagerRegistry $doctrine): Response
    {
        $cor = $doctrine->getRepository(Coords::class)->findOneBy(['id' => 1]);

        $em=$doctrine->getManager();



        $currentD=new DateTime;
        $thirty=$currentD->modify('-30 minutes');
        //new DateTime('00:30:00');

        $interrr=$currentD->diff($thirty);
        $val1= ($currentD)->sub($interrr);
        $val2= ($currentD)->add($interrr);

        $date = new DateTime();
        $minus=new DateTime('-30 minutes');
        $pliuss=new DateTime('+30 minutes');


        return $this->json([
            'current' =>$currentD,
            'minus' => $val1,
            'plus' => $val2,
            'interr'=>$interrr,
            'date'=>$date,
            'min'=>$minus,
            'pliuss'=>$pliuss,
            'modify'=>$thirty
        ]);

//
//        return $this->json([
//            'lat' => $cor->getLat(),
//            'lon' => $cor->getLon(),
//            'time' => $cor->getAddedAt()
//        ]);
    }

    #[Route('/api/post', name: 'api_post', methods: 'POST')]
    public function apiPost(ManagerRegistry $doctrine, Request $request)
    {
        $param = json_decode($request->getContent(), true);
        $headers=array("Content-Type:application/json; charset=UTF-8");
        $section = new Section;
        $arr = array();
        if ($param['lat_start']!=''&&$param['lon_start']!=''&&$param['radius']!=''){
            $section->setLatStart($param['lat_start']) ;
            $section->setLonStart($param['lon_start']) ;
            $section->setRadius($param['radius']) ;
            $section->setCreatedAt(new \DateTime("NOW" ,new \DateTimeZone('Europe/Sofia')));


            $em = $doctrine->getManager();
            $em->persist($section);
            $em->flush();

            $h1=$doctrine->getRepository(Section::class)->findonehour();
            foreach($h1 as $item){
                $lat_s=$item->getLatStart();
                $lon_s=$item->getLonStart();
                $rad=$item->getRadius();
                if($this->haversineGreatCircleDistance($section->getLatStart(),$section->getLonStart(),$lat_s,$lon_s)<=$section->getRadius()){
                    array_push($arr,$item);
                }

                if (count($arr)>=10){
                    $credentials = array(
                        'bearer_token'=>'AAAAAAAAAAAAAAAAAAAAAMMUXQEAAAAANkqhF9QSZElTT9IPZuoqzmd4x9g%3DAnMdA9caVqEhrHj9uDJF7AHECQ7YcHJrv7W0TikmMAoZi8iRM3',
                        'consumer_key'=>'nLu56r9t7hfVIJOzWWUUjTEOb',
                        'consumer_secret' => 'tM35IbwMoQ11RTrKVoEVI5gtPNHAtaGYx8tHpqpP0WS3Aoiuse',
                        'token_identifier'=>'861436010-6Dfmp1gXS2ON8cYgDAhOYWnArQBiHOQHG4x6vKcj',
                        'token_secret'=>'4j0qhAwaqDrf9TGW3hhVaWIW9wfX563YMPGNKMnghoQaM'
                    );
                    $twitter = new BirdElephant($credentials);

                    $tweet = (new \Coderjerk\BirdElephant\Compose\Tweet)->text("At least 10 users have reported traffic at ".$section->getLatStart()." ".$section->getLonStart(). ".");

                    $twitter->tweets()->tweet($tweet);
                }
            }

            return $this->json($section,201,$headers);
        }else{
            return $this->json('Bad Request',400,$headers);
        }
    }

    #[Route('/api/timecheck', name: 'api_timecheck', methods: 'GET')]
    public function timecheckX(ManagerRegistry $doctrine, Request $request)
    {
        $par_time=$request->query->get('time');

        $pattern = "/^-(?!0)\d{2} minutes$/";
        if (preg_match($pattern,$par_time)){
            $h2=$doctrine->getRepository(Section::class)->findxtime($par_time);

            return $this->json($h2,200);
        }
        return $this->json('Bad Request: The parameter is not formatted correctly. The correct format is:time=-xx minutes',400);


    }

    #[Route('/api/onehour', name: 'api_tweettest', methods: 'GET')]
    public function onehour(ManagerRegistry $doctrine, Request $request)
    {
        $par_lat_start= floatval($request->query->get('lat'));
        $par_lon_start=floatval($request->query->get('lon'));
        $par_rad=floatval($request->query->get('rad'));
        $par_time=$request->query->get('time');
        $arr = array();

        $h1=$doctrine->getRepository(Section::class)->findonehour();
        $h2=$doctrine->getRepository(Section::class)->findxtime($par_time);
        //array_push($arr,$par_time);
        return $this->json($h1,200);



    }
}
