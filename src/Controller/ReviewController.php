<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{

    /**
     * @Route("api/reviews/overtime/{hotel}", name="reviews_hotel_overtime")
     */
    public function index(Request $request)
    {

    }
}
