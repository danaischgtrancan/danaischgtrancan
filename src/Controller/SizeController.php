<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProSize;
use App\Form\ProductType;
use App\Form\ProSizeType;
use App\Repository\ProductRepository;
use App\Repository\ProSizeRepository;
use App\Repository\SizeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;



class SizeController extends AbstractController
{
    

}
