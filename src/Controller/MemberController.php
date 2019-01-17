<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MemberController extends AbstractController
{
    public function week()
    {
        $week = random_int(0, 100);

        return $this->render('member/week.html.twig', ['week' => $week]);
    }
}