<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }
/**
 * Permet de créer une annonce
 *@Route("/ads/new",name="ads_create")

 * @return Response
 */
    public function create(Request $request, ObjectManager $manager)
    {
        $ad = new Ad();
        $image = new Image();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$manager=$this->getDoctrine()->getManager();
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $ad->setAuthor($this->getUser());
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "l'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show', ['slug' => $ad->getslug()]);
        }

        return $this->render('ad/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     *Permet d'affiche ke formulaire d'édition
     *@Route("/ads/{slug}/edit",name="ads_edit")
     *
     * @return Reponse

     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$manager=$this->getDoctrine()->getManager();
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show', ['slug' => $ad->getslug()]);
        }

        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad,
        ]);
    }

/**
 * Permet d'afficher une soule annonce
 *
 * @Route("/ads/{slug}",name="ads_show")
 * @return Response
 */
    public function show(Ad $ad)
    {
        //je récupére l'annonce qui correspond au slug
        // $ad=$repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig', ['ad' => $ad]);

    }

}
