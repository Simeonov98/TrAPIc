<?php

namespace App\Controller;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Tweet;
use Noweh\TwitterApi\Client;
use Noweh\TwitterApi\Enum\Operators;
use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use TwitterAPIExchange;

class TweetController extends AbstractController
{
    #[Route('/tweet', name: 'tweet')]
    public function index(): Response
    {

        $credentials = array(
          'bearer_token'=>'AAAAAAAAAAAAAAAAAAAAAMMUXQEAAAAANkqhF9QSZElTT9IPZuoqzmd4x9g%3DAnMdA9caVqEhrHj9uDJF7AHECQ7YcHJrv7W0TikmMAoZi8iRM3',
            'consumer_key'=>'nLu56r9t7hfVIJOzWWUUjTEOb',
            'consumer_secret' => 'tM35IbwMoQ11RTrKVoEVI5gtPNHAtaGYx8tHpqpP0WS3Aoiuse',
            'token_identifier'=>'861436010-6Dfmp1gXS2ON8cYgDAhOYWnArQBiHOQHG4x6vKcj',
            'token_secret'=>'4j0qhAwaqDrf9TGW3hhVaWIW9wfX563YMPGNKMnghoQaM'
        );
            $twitter = new BirdElephant($credentials);

        $tweet = (new \Coderjerk\BirdElephant\Compose\Tweet)->text("Coderjerk is so cool. I'd love to help his work out by sponsoring him.");

        $twitter->tweets()->tweet($tweet);

        return $this->render('tweet/index.html.twig',
           ['controller_name'=>"asdads"]
      ) ;
    }



}
