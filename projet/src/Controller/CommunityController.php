<?php

namespace App\Controller;

use App\Entity\Community;
use App\Entity\Follow;
use App\Entity\Organise;
use App\Form\CommunityType;
use App\Repository\CommunityRepository;
use App\Repository\FollowRepository;
use App\Repository\OrganiseRepository;
use App\Repository\EventRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/{_locale}/community")
 * @IsGranted("ROLE_USER") 
 */
class CommunityController extends AbstractController
{
    /**
     * @Route("/", name="community_index", methods={"GET"})
     */
    public function index(CommunityRepository $communityRepository): Response
    {
        return $this->render('community/index.html.twig', [
            'communitiesPublic' => $communityRepository->findCommuPublic(),
            'communitiesOrga' => $communityRepository->findCommuOrganise($this->getUser()),
            'communitiesFollow' => $communityRepository->findCommuFollow($this->getUser()),
        ]);
    }

    /**
     * @Route("/new", name="community_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $community = new Community();
        $form = $this->createForm(CommunityType::class, $community);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && isset($_POST['creator'])) {
            $organise = new Organise();
            $organise->setTheuser($this->getUser());
            $community->addOrganise($organise);
            $community->setPublic(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($community);
            $entityManager->flush();

            return $this->redirectToRoute('community_index');
        }

        return $this->render('community/new.html.twig', [
            'community' => $community,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="community_show", methods={"GET"})
     */
    public function show(Community $community, FollowRepository $followRepo): Response
    {
        $follows = true;
        if($followRepo->isFollowing($this->getUser(), $community) == null){
            $follows = false;
        }
        return $this->render('community/show.html.twig', [
            'community' => $community,
            'follows' => $follows
        ]);
    }

    /**
     * @Route("/follow", name="community_follow", methods={"GET", "POST"})
     */
    public function follow(CommunityRepository $communityRepository, Request $request): Response
    {
        $follow = new Follow();
        if(isset($_POST['community']))
        {
            $follow->setCommunity($communityRepository->findOneById($_POST['community']));
            $follow->setTheuser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($follow);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('community_index');
    }

    /**
     * @Route("/{id}/edit", name="community_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Community $community): Response
    {
        $form = $this->createForm(CommunityType::class, $community);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('community_index');
        }

        return $this->render('community/edit.html.twig', [
            'community' => $community,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="community_delete", methods={"DELETE"})
     */
    public function delete(CommentRepository $commentRepo, EventRepository $eventRepo, FollowRepository $followRepo, OrganiseRepository $orgaRepo, Request $request, Community $community): Response
    {
        if ($this->isCsrfTokenValid('delete'.$community->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($eventRepo->findByCommunity($community) as $event){
                foreach ($commentRepo->findByEvent($event) as $comment){
                    $entityManager->remove($comment);
                }
                $entityManager->remove($event);
            }
            foreach ($followRepo->findByCommunity($community) as $follow){
                $entityManager->remove($follow);
            }
            foreach ($orgaRepo->findByCommunity($community) as $orga){
                $entityManager->remove($orga);
            }
            $entityManager->remove($community);
            $entityManager->flush();
        }

        return $this->redirectToRoute('community_index');
    }
}
